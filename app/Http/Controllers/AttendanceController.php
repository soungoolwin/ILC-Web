<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use League\Csv\Reader;
// Carbon is not used for this simple time matching logic.

class AttendanceController extends Controller
{
    /**
     * Display the upload form.
     */
    public function index()
    {
        return view('admin.attendance.index');
    }

    /**
     * Process the uploaded CSV files and display the attendance results.
     */
public function preview(Request $request)
    {
        // 1. Validate that both check-in and check-out files are present
        $request->validate([
            'check_in_csv' => ['required', 'file', 'mimes:csv,txt'],
            'check_out_csv' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        // 2. Parse both CSV files into structured arrays
        // The check-in file ('in') must contain all session details (Date, Time, Course, etc.)
        $checkIns = $this->parseCsvFile($request->file('check_in_csv'), 'in', $inError);
        if (!$checkIns) {
            return back()->with('error', $inError);
        }

        // The check-out file ('out') must contain the Student ID and Timestamp, 
        // and optionally Date/Time for reliable key matching.
        $checkOuts = $this->parseCsvFile($request->file('check_out_csv'), 'out', $outError);
        if (!$checkOuts) {
            return back()->with('error', $outError);
        }

        // Determine if checkOuts was parsed using the ID-only key format.
        // This occurs when the check-out CSV is missing the optional 'date' and 'time' columns.
        $firstCheckOutKey = key($checkOuts);
        $isIdOnlyKeyFormat = !empty($checkOuts) && 
                             (strpos($firstCheckOutKey, '-') === false || empty($checkOuts[$firstCheckOutKey]['date']));


        // 3. Match records from check-in and check-out files
        $attendanceData = [];
        $checkOutsById = [];

        if ($isIdOnlyKeyFormat) {
             // If ID-only format, use $checkOuts (which is keyed by student_id) for simple lookup.
            $checkOutsById = $checkOuts; 
        }

        // Iterate through all check-in records (the source of truth for session details)
        foreach ($checkIns as $fullKey => $checkInData) {
            $studentId = $checkInData['student_id'];
            $matchedCheckOutData = null;

            if (!$isIdOnlyKeyFormat) {
                // SCENARIO 1: Attempt full composite key match (ID-Date-Time). This is the V1 logic.
                if (isset($checkOuts[$fullKey])) {
                    $matchedCheckOutData = $checkOuts[$fullKey];
                    // Remove from checkOuts to ensure 1:1 match
                    unset($checkOuts[$fullKey]);
                }
            } else {
                // SCENARIO 2: Check-out file is ambiguous (ID-only).
                // We use the single (last) recorded check-out timestamp for this ID for ALL matching check-in sessions.
                if (isset($checkOutsById[$studentId])) {
                    $matchedCheckOutData = $checkOutsById[$studentId];
                    
                    // We DO NOT unset the generic check-out here, allowing it to pair with 
                    // multiple check-in records for the same student ID.
                }
            }

            if ($matchedCheckOutData) {
                // We found a match. Add to attendance data.
                $attendanceData[] = [
                    'student_id'   => $checkInData['student_id'],
                    'name'         => $checkInData['name'],
                    'email'        => $checkInData['email'],
                    'course'       => $checkInData['course'],
                    'section'      => $checkInData['section'],
                    'ajarn_name'   => $checkInData['ajarn_name'],
                    'date'         => $checkInData['date'], // Use IN date
                    'time'         => $checkInData['time'], // Use IN time
                    'check_in_ts'  => $checkInData['timestamp'],
                    'check_out_ts' => $matchedCheckOutData['timestamp'],
                ];
            }
        }

        // 4. Group data by Course -> Ajarn Name -> Section (Reverted to V1 structure)
        $grouped = [];
        foreach ($attendanceData as $record) {
            $course    = trim($record['course']);
            $ajarnName = trim($record['ajarn_name']);
            if (empty($ajarnName) || $ajarnName === 'N/A') {
                $ajarnName = 'Unassigned'; // Group students without an Ajarn together
            }
            $section   = trim($record['section']);
            $studentId = trim($record['student_id']);
            $date      = trim($record['date']); // Session Day (e.g., Wednesday)
            
            if (!isset($grouped[$course][$ajarnName][$section][$studentId])) {
                $grouped[$course][$ajarnName][$section][$studentId] = [
                    'details' => [
                        'name'       => $record['name'],
                        'email'      => $record['email'],
                        'student_id' => $record['student_id'],
                    ],
                    // Reverted: Store the original check-in time and timestamps for each session
                    'sessionsByDate' => [],
                ];
            }

            // Add the session details using the V1-style grouping
            $grouped[$course][$ajarnName][$section][$studentId]['sessionsByDate'][$date][] = [
                'time'         => $record['time'], // The original check-in time string
                'check_in_ts'  => $record['check_in_ts'], // Full check-in timestamp
                'check_out_ts' => $record['check_out_ts'], // Full check-out timestamp
            ];
        }

        // 5. Sort the complex data structure (Reverted to V1 sorting)
        ksort($grouped, SORT_NATURAL); // Sort courses
        foreach ($grouped as &$ajarns) {
            ksort($ajarns, SORT_NATURAL); // Sort ajarns
            foreach ($ajarns as &$sections) {
                ksort($sections, SORT_NATURAL); // Sort sections
                foreach ($sections as &$students) {
                    ksort($students, SORT_NATURAL); // Sort students by ID
                    foreach ($students as &$studentData) {
                        ksort($studentData['sessionsByDate'], SORT_NATURAL); // Sort dates (Wednesday, Friday, etc.)
                        
                        // No internal session sorting necessary for V1 approach
                    }
                }
            }
        }
        unset($ajarns, $sections, $students, $studentData);

        // NOTE: Step 5.5 (Attendance Summary Formatting) has been removed. 
        // The view must now iterate over $grouped[...]['sessionsByDate'][$date] 
        // to display the session times using the 'time' key.


        // 6. Calculate summary counts and get unique sections for filters
        // ... (This section remains unchanged, operates on the keys of the structure)
        $counts = [];
        $uniqueSections = [];
        foreach ($grouped as $course => $ajarns) {
            $courseStudentTotal = 0;
            $sectionsForCourse = [];
            foreach ($ajarns as $ajarn => $sections) {
                $ajarnStudentTotal = 0;
                $sectionsForCourse = array_merge($sectionsForCourse, array_keys($sections));
                foreach ($sections as $section => $students) {
                    $studentCount = count($students);
                    $counts[$course][$ajarn][$section]['student_count'] = $studentCount;
                    $ajarnStudentTotal += $studentCount;
                }
                $counts[$course][$ajarn]['__total_students'] = $ajarnStudentTotal;
                $courseStudentTotal += $ajarnStudentTotal;
            }
            $counts[$course]['__total_students'] = $courseStudentTotal;
            
            // Prepare unique sections for the dropdown filter
            $uniqueSections[$course] = array_unique($sectionsForCourse);
            sort($uniqueSections[$course], SORT_NATURAL);
        }

        // 7. Pass the final data to the results view
        return view('admin.attendance.results', [
            'grouped'        => $grouped,
            'counts'         => $counts,
            'uniqueSections' => $uniqueSections,
        ]);
    }

    /**
     * A reusable helper function to parse a CSV file using league/csv.
     */
    private function parseCsvFile(UploadedFile $file, string $type, ?string &$error = null): ?array
    {
        try {
            $csv = Reader::createFromPath($file->getRealPath(), 'r');
            $csv->setHeaderOffset(0);
            
            // Base headers required for all types
            $requiredHeaders = [
                'timestamp' => 'Timestamp',
                'sid'       => 'Write your Student ID.',
            ];
            $optionalHeaders = [];

            if ($type === 'in') {
                // Headers required for IN records (full session details)
                $requiredHeaders += [
                    'date'      => 'Choose the session DAY. ',
                    'time'      => 'Choose the session TIME. ',
                    'username'  => 'Email Address',
                    'name'      => 'Write your full name in English.',
                    'course'    => 'Choose your course.',
                    'section'   => 'What is your section / group (908, 948 ?)',
                ];
                // Optional header for IN records
                $optionalHeaders += ['aj_name'  => 'Ajarn Name'];
            } else { // $type === 'out'
                // Date and Time are optional for OUT records.
                $optionalHeaders += [
                    'date'      => 'Choose the session DAY. ',
                    'time'      => 'Choose the session TIME. ',
                ];
            }
            
            $csvHeaders = $csv->getHeader();
            $presentHeaders = array_flip($csvHeaders);

            // 1. Validate required headers
            foreach ($requiredHeaders as $key => $label) {
                if (!isset($presentHeaders[$label])) {
                    $error = "CSV header '{$label}' not found in " . $file->getClientOriginalName() . " (required for {$type} file).";
                    return null;
                }
            }
            
            // 2. Build the final mapping array, track if date/time are present for OUT file
            $mapping = [];
            $hasDateAndTime = true;
            
            // Map required headers
            foreach ($requiredHeaders as $key => $label) {
                $mapping[$key] = $label;
            }
            
            // Map optional headers if present in the CSV file, otherwise map to null
            foreach ($optionalHeaders as $key => $label) {
                if (isset($presentHeaders[$label])) {
                    $mapping[$key] = $label;
                } else {
                    $mapping[$key] = null; // Mark as missing
                    if ($type === 'out' && ($key === 'date' || $key === 'time')) {
                        $hasDateAndTime = false;
                    }
                }
            }

            $dataRows = [];
            foreach ($csv->getRecords() as $record) {
                $studentId = trim($record[$mapping['sid']]);

                // Retrieve Date and Time. If the column is missing in the CSV, $mapping['date'] is null 
                // and $sessionDate will be an empty string ''.
                $sessionDate = $mapping['date'] ? trim($record[$mapping['date']]) : '';
                $sessionTime = $mapping['time'] ? trim($record[$mapping['time']]) : '';
                
                // Key generation logic
                if ($type === 'out' && !$hasDateAndTime) {
                    // If check-out is missing date/time, use studentId only for the key.
                    $key = $studentId; 
                } else {
                    // Standard key (used for IN, or OUT with date/time)
                    $key = "{$studentId}-{$sessionDate}-{$sessionTime}";
                }

                $rowData = [
                    'timestamp'  => $record[$mapping['timestamp']],
                    'student_id' => $studentId,
                    // Note: If date/time is missing, these fields will be empty strings.
                    'date'       => $sessionDate, 
                    'time'       => $sessionTime,
                ];

                if ($type === 'in') {
                    $rowData += [
                        'email'      => $record[$mapping['username']],
                        'name'       => $record[$mapping['name']],
                        'course'     => $record[$mapping['course']] ?? 'Unknown',
                        'section'    => $record[$mapping['section']] ?? 'Unknown',
                        // Read Ajarn Name value, provide default if column doesn't exist or value is empty
                        'ajarn_name' => $mapping['aj_name'] ? ($record[$mapping['aj_name']] ?? 'N/A') : 'N/A',
                    ];
                }

                // If the key is ID-only, subsequent records for the same ID overwrite the previous,
                // ensuring we only store the *last* recorded check-out for that student ID.
                $dataRows[$key] = $rowData;
            }
            return $dataRows;

        } catch (\Exception $e) {
            $error = "Failed to process file: " . $file->getClientOriginalName() . " - " . $e->getMessage();
            return null;
        }
    }
}
