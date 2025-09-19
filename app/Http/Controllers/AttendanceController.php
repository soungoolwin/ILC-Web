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
                
                // Combine data from both records
                $attendanceData[] = [
                    'student_id'   => $checkInData['student_id'],
                    'name'         => $checkInData['name'],
                    'email'        => $checkInData['email'],
                    'course'       => $checkInData['course'],
                    'section'      => $checkInData['section'],
                    'date'         => $checkInData['date'],
                    'time'         => $checkInData['time'],
                    'check_in_ts'  => $checkInData['timestamp'],
                    'check_out_ts' => $checkOutData['timestamp'],
                ];
            }
        }

        // 4. Group the matched attendance data by Course -> Section
        $grouped = [];
        foreach ($attendanceData as $record) {
            $course    = trim($record['course']);
            $section   = trim($record['section']);
            $studentId = trim($record['student_id']);
            $date      = trim($record['date']);

            // Initialize the student's record if it's the first time
            if (!isset($grouped[$course][$section][$studentId])) {
                $grouped[$course][$section][$studentId] = [
                    'details' => [
                        'name'       => $record['name'],
                        'email'      => $record['email'],
                        'student_id' => $record['student_id'],
                    ],
                    'sessionsByDate' => [],
                ];
            }

            // Add the session details, grouped by the specific date
            $grouped[$course][$section][$studentId]['sessionsByDate'][$date][] = [
                'time' => $record['time'],
                // you can also keep timestamps if needed for a tooltip, etc.
                // 'check_in_ts' => $record['check_in_ts'],
                // 'check_out_ts' => $record['check_out_ts'],
            ];
        }

        // 5. Sort the complex data structure for organized display
        ksort($grouped, SORT_NATURAL); // Sort courses
        foreach ($grouped as &$sections) {
            ksort($sections, SORT_NATURAL); // Sort sections
            foreach ($sections as &$students) {
                ksort($students, SORT_NATURAL); // Sort students by ID
                foreach ($students as &$studentData) {
                    ksort($studentData['sessionsByDate'], SORT_NATURAL); // Sort dates for each student
                }
            }
        }
        unset($sections, $students, $studentData); // Unset all references

        // 6. Calculate summary counts for students per section and course
        $counts = [];
        foreach ($grouped as $course => $sections) {
            $courseStudentTotal = 0;
            foreach ($sections as $section => $students) {
                $counts[$course][$section]['student_count'] = count($students);
                $courseStudentTotal += count($students);
            }
            $counts[$course]['__total_students'] = $courseStudentTotal;
        }

        // 7. Pass the final data to the results view
        return view('admin.attendance.results', [
            'grouped' => $grouped,
            'counts'  => $counts,
        ]);
    }

    /**
     * A reusable helper function to parse a CSV file using league/csv.
     *
     * @param UploadedFile $file The uploaded CSV file.
     * @param string $type The type of file ('in' or 'out'), to determine headers.
     * @param string|null $error A variable passed by reference to hold any error messages.
     * @return array|null An associative array of parsed data or null on failure.
     */
    private function parseCsvFile(UploadedFile $file, string $type, ?string &$error = null): ?array
    {
        try {
            // Create a new CSV reader instance
            $csv = Reader::createFromPath($file->getRealPath(), 'r');
            $csv->setHeaderOffset(0); // Set the first row as the header

            // Define column header labels we expect to find in the CSVs
            $headers = [
                'timestamp' => 'Timestamp',
                'sid'       => 'Write your Student ID.',
                'date'      => 'Choose the session DATE. ',
                'time'      => 'Choose the session TIME. ',
            ];

            if ($type === 'in') {
                $headers += [
                    'username'  => 'Email Address',
                    'name'      => 'Write your full name in English.',
                    'course'    => 'Choose your course.',
                    'section'   => 'What is your section / group (908, 948 ?)',
                ];
            }
            
            // Verify that all required headers exist in the CSV file
            $csvHeaders = $csv->getHeader();
            foreach ($headers as $key => $label) {
                if (!in_array($label, $csvHeaders)) {
                    $error = "CSV header '{$label}' not found in " . $file->getClientOriginalName();
                    return null;
                }
            }

            $dataRows = [];
            foreach ($csv->getRecords() as $record) {
                $studentId = trim($record[$headers['sid']]);
                $sessionDate = trim($record[$headers['date']]);
                $sessionTime = trim($record[$headers['time']]);

                // Create a unique key for matching check-ins and check-outs
                $key = "{$studentId}-{$sessionDate}-{$sessionTime}";

                $rowData = [
                    'timestamp'  => $record[$headers['timestamp']],
                    'student_id' => $studentId,
                    'date'       => $sessionDate,
                    'time'       => $sessionTime,
                ];

                if ($type === 'in') {
                    $rowData += [
                        'email'    => $record[$headers['username']],
                        'name'     => $record[$headers['name']],
                        'course'   => $record[$headers['course']] ?? 'Unknown',
                        'section'  => $record[$headers['section']] ?? 'Unknown',
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