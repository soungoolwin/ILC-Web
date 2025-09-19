<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use League\Csv\Reader;

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
        $checkIns = $this->parseCsvFile($request->file('check_in_csv'), 'in', $inError);
        if (!$checkIns) {
            return back()->with('error', $inError);
        }

        $checkOuts = $this->parseCsvFile($request->file('check_out_csv'), 'out', $outError);
        if (!$checkOuts) {
            return back()->with('error', $outError);
        }

        // 3. Match records from check-in and check-out files
        $attendanceData = [];
        foreach ($checkIns as $key => $checkInData) {
            if (isset($checkOuts[$key])) {
                $checkOutData = $checkOuts[$key];
                
                $attendanceData[] = [
                    'student_id'   => $checkInData['student_id'],
                    'name'         => $checkInData['name'],
                    'email'        => $checkInData['email'],
                    'course'       => $checkInData['course'],
                    'section'      => $checkInData['section'],
                    'ajarn_name'   => $checkInData['ajarn_name'],
                    'date'         => $checkInData['date'],
                    'time'         => $checkInData['time'],
                    'check_in_ts'  => $checkInData['timestamp'],
                    'check_out_ts' => $checkOutData['timestamp'],
                ];
            }
        }

        // 4. Group data by Course -> Ajarn Name -> Section
        $grouped = [];
        foreach ($attendanceData as $record) {
            $course    = trim($record['course']);
            $ajarnName = trim($record['ajarn_name']);
            if (empty($ajarnName) || $ajarnName === 'N/A') {
                $ajarnName = 'Unassigned'; // Group students without an Ajarn together
            }
            $section   = trim($record['section']);
            $studentId = trim($record['student_id']);
            $date      = trim($record['date']);

            if (!isset($grouped[$course][$ajarnName][$section][$studentId])) {
                $grouped[$course][$ajarnName][$section][$studentId] = [
                    'details' => [
                        'name'       => $record['name'],
                        'email'      => $record['email'],
                        'student_id' => $record['student_id'],
                    ],
                    'sessionsByDate' => [],
                ];
            }

            $grouped[$course][$ajarnName][$section][$studentId]['sessionsByDate'][$date][] = [
                'time' => $record['time'],
            ];
        }

        // 5. Sort the complex data structure
        ksort($grouped, SORT_NATURAL); // Sort courses
        foreach ($grouped as &$ajarns) {
            ksort($ajarns, SORT_NATURAL); // Sort ajarns
            foreach ($ajarns as &$sections) {
                ksort($sections, SORT_NATURAL); // Sort sections
                foreach ($sections as &$students) {
                    ksort($students, SORT_NATURAL); // Sort students by ID
                    foreach ($students as &$studentData) {
                        ksort($studentData['sessionsByDate'], SORT_NATURAL); // Sort dates
                    }
                }
            }
        }
        unset($ajarns, $sections, $students, $studentData);

        // 6. Calculate summary counts and get unique sections for filters
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

            $headers = [
                'timestamp' => 'Timestamp',
                'sid'       => 'Write your Student ID.',
                'date'      => 'Choose the session DAY. ',
                'time'      => 'Choose the session TIME. ',
            ];

            if ($type === 'in') {
                $headers += [
                    'username' => 'Username',
                    'name'     => 'Write your full name in English.',
                    'course'   => 'Choose your course.',
                    'section'  => 'What is your section / group (908, 948 ?)',
                    'aj_name'  => 'Ajarn Name', // Added Ajarn Name header
                ];
            }
            
            $csvHeaders = $csv->getHeader();
            foreach ($headers as $key => $label) {
                if (!in_array($label, $csvHeaders)) {
                    // Ajarn Name is optional, so we don't throw an error if it's missing
                    if ($key === 'aj_name') continue; 
                    
                    $error = "CSV header '{$label}' not found in " . $file->getClientOriginalName();
                    return null;
                }
            }

            $dataRows = [];
            foreach ($csv->getRecords() as $record) {
                $studentId = trim($record[$headers['sid']]);
                $sessionDate = trim($record[$headers['date']]);
                $sessionTime = trim($record[$headers['time']]);

                $key = "{$studentId}-{$sessionDate}-{$sessionTime}";

                $rowData = [
                    'timestamp'  => $record[$headers['timestamp']],
                    'student_id' => $studentId,
                    'date'       => $sessionDate,
                    'time'       => $sessionTime,
                ];

                if ($type === 'in') {
                    $rowData += [
                        'email'      => $record[$headers['username']],
                        'name'       => $record[$headers['name']],
                        'course'     => $record[$headers['course']] ?? 'Unknown',
                        'section'    => $record[$headers['section']] ?? 'Unknown',
                        // Read Ajarn Name value, provide default if column doesn't exist for a row
                        'ajarn_name' => isset($headers['aj_name']) ? ($record[$headers['aj_name']] ?? 'N/A') : 'N/A',
                    ];
                }

                $dataRows[$key] = $rowData;
            }
            return $dataRows;

        } catch (\Exception $e) {
            $error = "Failed to process file: " . $file->getClientOriginalName() . " - " . $e->getMessage();
            return null;
        }
    }
}