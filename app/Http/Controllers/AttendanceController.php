<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AttendanceController extends Controller
{
    public function index()
    {
        // Simple upload form + (optional) sample button
        return view('admin.attendance.index');
    }

    public function preview(Request $request)
    {
        $request->validate([
            'csv' => ['required','file','mimes:csv,txt'],
        ]);

        $handle = fopen($request->file('csv')->getRealPath(), 'r');
        if (!$handle) {
            return back()->with('error', 'Unable to open file.');
        }

        // Read header row exactly as in your file
        $header = fgetcsv($handle);
        if (!$header) {
            return back()->with('error', 'Empty CSV.');
        }

        // Helper to find columns safely by label
        $idx = fn(string $label) => array_search($label, $header);

        $col = [
            'timestamp' => $idx('Timestamp'),
            'username'  => $idx('Username'),
            'sid1'      => $idx('Write your Student ID.'),
            'sid2'      => $idx('Write your Student ID again.'),
            'name'      => $idx('Write your full name in English.'),
            'course'    => $idx('Choose your course.'),
            'section'   => $idx('What is your section / group (908, 948 ?)'),
            'date'      => $idx('Choose the session DATE. '),
            'time'      => $idx('Choose the session TIME. '),
        ];

        // Quick sanity check in case headers change
        foreach ($col as $key => $i) {
            if ($i === false) {
                return back()->with('error', "CSV header missing: {$key}");
            }
        }

        $rows = [];
        while (($data = fgetcsv($handle)) !== false) {
            // skip blank lines
            if (count(array_filter($data, fn($v) => $v !== null && $v !== '')) === 0) continue;

            $rows[] = [
                'timestamp' => $data[$col['timestamp']] ?? null,
                'email'     => $data[$col['username']] ?? null,
                'student_id'=> $data[$col['sid1']] ?? null,
                'name'      => $data[$col['name']] ?? null,
                'course'    => $data[$col['course']] ?? 'Unknown',
                'section'   => $data[$col['section']] ?? 'Unknown',
                'date'      => $data[$col['date']] ?? null,
                'time'      => $data[$col['time']] ?? null,
            ];
        }
        fclose($handle);

        // Group: Course -> Section
        $grouped = [];
        foreach ($rows as $r) {
            $course  = trim($r['course'] ?? 'Unknown');
            $section = trim($r['section'] ?? 'Unknown');
            $grouped[$course][$section][] = $r;
        }

        // Sort by course and section for stable display
        ksort($grouped, SORT_NATURAL);
        foreach ($grouped as &$sections) {
            ksort($sections, SORT_NATURAL);
        }

        // Summary counts per course/section (nice for headers)
        $counts = [];
        foreach ($grouped as $course => $sections) {
            $courseTotal = 0;
            foreach ($sections as $section => $list) {
                $counts[$course][$section] = count($list);
                $courseTotal += count($list);
            }
            $counts[$course]['__total'] = $courseTotal;
        }

        return view('admin.attendance.preview', [
            'grouped' => $grouped,
            'counts'  => $counts,
        ]);
    }
}
