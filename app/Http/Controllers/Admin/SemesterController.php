<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Semester;
use Illuminate\Http\Request;

class SemesterController extends Controller
{
    public function index()
    {
        $semesters = Semester::orderByDesc('year')->orderByDesc('term')->get();

        // Prefill the "start a new semester" form with the current
        // semester's capacity settings so an admin isn't retyping them
        // from scratch every term.
        $defaults = Semester::current() ?? new Semester();

        return view('admin.semesters.index', compact('semesters', 'defaults'));
    }

    public function store(Request $request)
    {
        $semester = Semester::create($this->capacityData($request) + [
            'name' => Semester::nameFor((int) $request->input('year'), (int) $request->input('term')),
            'year' => $request->input('year'),
            'term' => $request->input('term'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);
        $semester->activate();

        return redirect()->route('admin.semesters.index')
            ->with('success', "'{$semester->name}' is now the current semester.");
    }

    public function edit(Semester $semester)
    {
        return view('admin.semesters.edit', compact('semester'));
    }

    public function update(Request $request, Semester $semester)
    {
        $semester->update($this->capacityData($request) + [
            'name' => Semester::nameFor((int) $request->input('year'), (int) $request->input('term')),
            'year' => $request->input('year'),
            'term' => $request->input('term'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ]);

        return redirect()->route('admin.semesters.index')
            ->with('success', "'{$semester->name}' was updated.");
    }

    public function activate(Semester $semester)
    {
        $semester->activate();

        return redirect()->route('admin.semesters.index')
            ->with('success', "'{$semester->name}' is now the current semester.");
    }

    /**
     * Validate and shape the shared fields between store() and update():
     * dates, team-leader slot limits, and the full day x hour-slot
     * table-capacity grid.
     */
    private function capacityData(Request $request): array
    {
        $rules = [
            'year' => 'required|integer|min:2000|max:2100',
            'term' => 'required|integer|in:1,2,3',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'tl_limit' => 'required|array',
            'tl_limit.*' => 'required|integer|min:0',
            'table_capacity_default' => 'required|integer|min:1',
            'capacity' => 'required|array',
        ];

        foreach (Semester::DAYS as $day) {
            foreach (Semester::HOUR_SLOTS as $slot) {
                $rules["capacity.{$day}.{$slot}"] = 'required|integer|min:0';
            }
        }

        $data = $request->validate($rules);

        return [
            'team_leader_slot_limits' => $data['tl_limit'],
            'table_capacity_default' => $data['table_capacity_default'],
            'table_capacity_grid' => $data['capacity'],
        ];
    }
}
