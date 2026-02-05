<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\UploadedFile;
use League\Csv\Reader;
use App\Models\QrAttendance;
use App\Models\QrStudentAttendance;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    /**
     * Display the upload form.
     */
    public function index()
    {
        return view('admin.attendance.index');
    }

    public function store(Request $request)
    {
        // Decode the hidden input data
        $attendanceData = json_decode($request->input('attendance_data'), true);

        if (!$attendanceData || empty($attendanceData)) {
            return redirect()->route('admin.attendance.index')->with('error', 'No data to store.');
        }

        try {
            $this->storeAttendanceData($attendanceData);
            return redirect()->route('admin.attendance.index')->with('success', 'Attendance data stored successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to store data: ' . $e->getMessage());
        }
    }

    /**
     * Process the uploaded CSV files and display the attendance results.
     */
    public function preview(Request $request)
    {
        $request->validate([
            'check_in_csv' => ['required', 'file', 'mimes:csv,txt'],
            'check_out_csv' => ['required', 'file', 'mimes:csv,txt'],
        ]);

        $checkIns = $this->parseCsvFile($request->file('check_in_csv'), 'in', $inError);
        if (!$checkIns) {
            return back()->with('error', $inError);
        }

        $checkOuts = $this->parseCsvFile($request->file('check_out_csv'), 'out', $outError);
        if (!$checkOuts) {
            return back()->with('error', $outError);
        }

        $firstCheckOutKey = key($checkOuts);
        $isIdOnlyKeyFormat = !empty($checkOuts) && 
                             (strpos($firstCheckOutKey, '-') === false || empty($checkOuts[$firstCheckOutKey]['date']));

        $attendanceData = [];
        $checkOutsById = $isIdOnlyKeyFormat ? $checkOuts : [];

        foreach ($checkIns as $fullKey => $checkInData) {
            $studentId = $checkInData['student_id'];
            $matchedCheckOutData = null;

            if (!$isIdOnlyKeyFormat) {
                if (isset($checkOuts[$fullKey])) {
                    $matchedCheckOutData = $checkOuts[$fullKey];
                    unset($checkOuts[$fullKey]);
                }
            } else {
                if (isset($checkOutsById[$studentId])) {
                    $matchedCheckOutData = $checkOutsById[$studentId];
                }
            }

            if ($matchedCheckOutData) {
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
                    'check_out_ts' => $matchedCheckOutData['timestamp'],
                ];
            }
        }

        // Call the separate storage function
        $this->storeAttendanceData($attendanceData);

        // Grouping and Sorting logic for the view
        $grouped = $this->groupAttendanceData($attendanceData);

        return view('admin.attendance.results', [
            'grouped'        => $grouped['data'],
            'counts'         => $grouped['counts'],
            'uniqueSections' => $grouped['sections'],
            'rawAttendance'  => $attendanceData,
        ]);
    }

    /**
     * Store attendance data into the database.
     */
    private function storeAttendanceData(array $attendanceData)
    {
        DB::transaction(function () use ($attendanceData) {
            foreach ($attendanceData as $record) {
                // 1. Create session record
                QrAttendance::create([
                    'student_id' => $record['student_id'],
                    'day'        => $record['date'],
                    'time'       => $record['time'],
                ]);

                // 2. Update student profile linked by student_id
                QrStudentAttendance::updateOrCreate(
                    ['student_id' => $record['student_id']],
                    [
                        'name'       => $record['name'],
                        'section'    => $record['section'],
                        'ajarn_name' => $record['ajarn_name'],
                    ]
                );
            }
        });
    }

    private function groupAttendanceData(array $attendanceData)
    {
        $grouped = [];
        foreach ($attendanceData as $record) {
            $course    = trim($record['course']);
            $ajarnName = trim($record['ajarn_name']) ?: 'Unassigned';
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
                'time'         => $record['time'],
                'check_in_ts'  => $record['check_in_ts'],
                'check_out_ts' => $record['check_out_ts'],
            ];
        }

        // Sort results
        ksort($grouped, SORT_NATURAL);
        $counts = [];
        $uniqueSections = [];

        foreach ($grouped as $course => $ajarns) {
            $courseTotal = 0;
            $sectionsForCourse = [];
            foreach ($ajarns as $ajarn => $sections) {
                $ajarnTotal = 0;
                $sectionsForCourse = array_merge($sectionsForCourse, array_keys($sections));
                foreach ($sections as $section => $students) {
                    $studentCount = count($students);
                    $counts[$course][$ajarn][$section]['student_count'] = $studentCount;
                    $ajarnTotal += $studentCount;
                }
                $counts[$course][$ajarn]['__total_students'] = $ajarnTotal;
                $courseTotal += $ajarnTotal;
            }
            $counts[$course]['__total_students'] = $courseTotal;
            $uniqueSections[$course] = array_values(array_unique($sectionsForCourse));
            sort($uniqueSections[$course], SORT_NATURAL);
        }

        return ['data' => $grouped, 'counts' => $counts, 'sections' => $uniqueSections];
    }

    /**
     * A reusable helper function to parse a CSV file.
     */
    private function parseCsvFile(UploadedFile $file, string $type, ?string &$error = null): ?array
    {
        try {
            $csv = Reader::createFromPath($file->getRealPath(), 'r');
            $csv->setHeaderOffset(0);
            
            $requiredHeaders = [
                'timestamp' => 'Timestamp',
                'sid'       => 'Write your Student ID.',
            ];
            $optionalHeaders = [];

            if ($type === 'in') {
                $requiredHeaders += [
                    'date'      => 'Choose the session DAY. ',
                    'time'      => 'Choose the session TIME. ',
                    'username'  => 'Email Address',
                    'name'      => 'Write your full name in English.',
                    'course'    => 'Choose your course.',
                    'section'   => 'What is your section / group (908, 948 ?)',
                ];
                $optionalHeaders += ['aj_name'  => 'Ajarn Name'];
            } else {
                $optionalHeaders += [
                    'date'      => 'Choose the session DAY. ',
                    'time'      => 'Choose the session TIME. ',
                ];
            }
            
            $csvHeaders = $csv->getHeader();
            $presentHeaders = array_flip($csvHeaders);

            foreach ($requiredHeaders as $key => $label) {
                if (!isset($presentHeaders[$label])) {
                    $error = "CSV header '{$label}' not found in " . $file->getClientOriginalName();
                    return null;
                }
            }
            
            $mapping = [];
            $hasDateAndTime = true;
            
            foreach ($requiredHeaders as $key => $label) {
                $mapping[$key] = $label;
            }
            
            foreach ($optionalHeaders as $key => $label) {
                if (isset($presentHeaders[$label])) {
                    $mapping[$key] = $label;
                } else {
                    $mapping[$key] = null;
                    if ($type === 'out' && ($key === 'date' || $key === 'time')) {
                        $hasDateAndTime = false;
                    }
                }
            }

            $dataRows = [];
            foreach ($csv->getRecords() as $record) {
                $studentId = trim($record[$mapping['sid']]);
                $sessionDate = $mapping['date'] ? trim($record[$mapping['date']]) : '';
                $sessionTime = $mapping['time'] ? trim($record[$mapping['time']]) : '';
                
                $key = ($type === 'out' && !$hasDateAndTime) 
                    ? $studentId 
                    : "{$studentId}-{$sessionDate}-{$sessionTime}";

                $rowData = [
                    'timestamp'  => $record[$mapping['timestamp']],
                    'student_id' => $studentId,
                    'date'       => $sessionDate, 
                    'time'       => $sessionTime,
                ];

                if ($type === 'in') {
                    $rowData += [
                        'email'      => $record[$mapping['username']],
                        'name'       => $record[$mapping['name']],
                        'course'     => $record[$mapping['course']] ?? 'Unknown',
                        'section'    => $record[$mapping['section']] ?? 'Unknown',
                        'ajarn_name' => $mapping['aj_name'] ? ($record[$mapping['aj_name']] ?? 'N/A') : 'N/A',
                    ];
                }

                $dataRows[$key] = $rowData;
            }
            return $dataRows;

        } catch (\Exception $e) {
            $error = "Failed to process file: " . $e->getMessage();
            return null;
        }
    }
}