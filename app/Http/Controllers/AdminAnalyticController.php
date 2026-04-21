<?php

namespace App\Http\Controllers;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Appointment;
use App\Models\Form;
use App\Models\Mentor;
use App\Models\MentorForm;
use App\Models\Student;
use App\Models\StudentForm;
use App\Models\TeamLeader;
use App\Models\TeamLeaderForm;
use App\Models\TeamLeaderTimetable;
use App\Models\Timetable;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminAnalyticController extends Controller
{
    public function index()
    {
        $roleLabels = ['Students', 'Mentors', 'Team Leaders', 'Admins'];
        $roleKeys = ['student', 'mentor', 'team_leader', 'admin'];
        $roleCountsByKey = User::query()
            ->select('role', DB::raw('count(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role');
        $roleCounts = collect($roleKeys)
            ->map(fn ($role) => (int) ($roleCountsByKey[$role] ?? 0))
            ->all();

        $appointmentRowsByWeek = Appointment::query()
            ->join('timetables', 'appointments.timetable_id', '=', 'timetables.id')
            ->select(
                'timetables.week_number',
                DB::raw('count(*) as total'),
                DB::raw('count(distinct appointments.student_id) as student_total'),
                DB::raw('count(distinct appointments.timetable_id) as slot_total')
            )
            ->groupBy('timetables.week_number')
            ->get()
            ->keyBy('week_number');
        $weekLabels = collect(range(1, 16))->map(fn ($week) => 'Week '.$week)->all();
        $appointmentsByWeek = collect(range(1, 16))
            ->map(fn ($week) => (int) ($appointmentRowsByWeek[(string) $week]->total ?? 0))
            ->all();
        $uniqueStudentsByWeek = collect(range(1, 16))
            ->map(fn ($week) => (int) ($appointmentRowsByWeek[(string) $week]->student_total ?? 0))
            ->all();
        $activeSlotsByWeek = collect(range(1, 16))
            ->map(fn ($week) => (int) ($appointmentRowsByWeek[(string) $week]->slot_total ?? 0))
            ->all();

        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $appointmentRowsByDay = Appointment::query()
            ->join('timetables', 'appointments.timetable_id', '=', 'timetables.id')
            ->select(
                'timetables.day',
                DB::raw('count(*) as total'),
                DB::raw('count(distinct appointments.student_id) as student_total')
            )
            ->groupBy('timetables.day')
            ->get()
            ->keyBy('day');
        $appointmentsByDay = collect($days)
            ->map(fn ($day) => (int) ($appointmentRowsByDay[$day]->total ?? 0))
            ->all();
        $studentsByDay = collect($days)
            ->map(fn ($day) => (int) ($appointmentRowsByDay[$day]->student_total ?? 0))
            ->all();

        $timetableCountsByDay = Timetable::query()
            ->select('day', DB::raw('count(*) as total'), DB::raw('sum(case when reserved = 1 then 1 else 0 end) as reserved_total'))
            ->groupBy('day')
            ->get()
            ->keyBy('day');
        $reservedByDay = collect($days)
            ->map(fn ($day) => (int) ($timetableCountsByDay[$day]->reserved_total ?? 0))
            ->all();
        $openByDay = collect($days)
            ->map(function ($day) use ($timetableCountsByDay) {
                $row = $timetableCountsByDay[$day] ?? null;
                return max(0, (int) ($row->total ?? 0) - (int) ($row->reserved_total ?? 0));
            })
            ->all();

        $appointmentRowsByTimeSlot = Appointment::query()
            ->join('timetables', 'appointments.timetable_id', '=', 'timetables.id')
            ->select('timetables.time_slot', DB::raw('count(*) as total'))
            ->groupBy('timetables.time_slot')
            ->orderBy('timetables.time_slot')
            ->get();
        $timeSlotLabels = $appointmentRowsByTimeSlot->pluck('time_slot')->values()->all();
        $appointmentsByTimeSlot = $appointmentRowsByTimeSlot->pluck('total')->map(fn ($total) => (int) $total)->values()->all();

        if (empty($timeSlotLabels)) {
            $timeSlotLabels = ['No appointments'];
            $appointmentsByTimeSlot = [0];
        }

        $mentorStatusRows = Mentor::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->get();
        $mentorStatusLabels = $mentorStatusRows->pluck('status')->map(fn ($status) => ucfirst($status ?: 'Unknown'))->values()->all();
        $mentorStatusData = $mentorStatusRows->pluck('total')->map(fn ($total) => (int) $total)->values()->all();

        if (empty($mentorStatusLabels)) {
            $mentorStatusLabels = ['No mentors'];
            $mentorStatusData = [0];
        }

        $formCompletionStats = $this->formCompletionStats();
        $formCompletionLabels = $formCompletionStats->pluck('label')->all();
        $formCompletionData = $formCompletionStats->pluck('percentage')->all();

        $formTypes = ['pretest', 'posttest', 'questionnaire', 'consent'];
        $formRoles = ['student', 'mentor', 'team_leader'];
        $formInventoryRows = Form::query()
            ->select('form_type', 'for_role', DB::raw('count(*) as total'))
            ->groupBy('form_type', 'for_role')
            ->get();
        $formsByTypeAndRole = collect($formRoles)->mapWithKeys(function ($role) use ($formTypes, $formInventoryRows) {
            return [
                $role => collect($formTypes)->map(function ($type) use ($role, $formInventoryRows) {
                    return (int) ($formInventoryRows
                        ->first(fn ($row) => $row->for_role === $role && $row->form_type === $type)
                        ->total ?? 0);
                })->all(),
            ];
        });

        $accountGrowthRows = User::query()
            ->select(DB::raw('date(created_at) as created_day'), 'role', DB::raw('count(*) as total'))
            ->groupBy(DB::raw('date(created_at)'), 'role')
            ->orderBy('created_day')
            ->get();
        $accountGrowthLabels = $accountGrowthRows->pluck('created_day')->unique()->values();
        if ($accountGrowthLabels->isEmpty()) {
            $accountGrowthLabels = collect([now()->toDateString()]);
        }

        $facultyRows = User::query()
            ->select(DB::raw("coalesce(nullif(faculty, ''), 'Unassigned') as faculty"), DB::raw('count(*) as total'))
            ->groupBy(DB::raw("coalesce(nullif(faculty, ''), 'Unassigned')"))
            ->orderByDesc('total')
            ->limit(8)
            ->get();

        $topMentors = Mentor::query()
            ->join('users', 'mentors.user_id', '=', 'users.id')
            ->leftJoin('timetables', 'mentors.id', '=', 'timetables.mentor_id')
            ->leftJoin('appointments', 'timetables.id', '=', 'appointments.timetable_id')
            ->select(
                'mentors.id',
                'mentors.mentor_id',
                'mentors.status',
                'users.name',
                DB::raw('count(distinct timetables.id) as timetable_count'),
                DB::raw('count(appointments.id) as appointment_count')
            )
            ->groupBy('mentors.id', 'mentors.mentor_id', 'mentors.status', 'users.name')
            ->orderByDesc('appointment_count')
            ->limit(8)
            ->get();

        $studentCompletionByType = $this->completionByType('student', Student::count(), StudentForm::class);
        $mentorCompletionByType = $this->completionByType('mentor', Mentor::count(), MentorForm::class);
        $teamLeaderCompletionByType = $this->completionByType('team_leader', TeamLeader::count(), TeamLeaderForm::class);

        $mentorWorkloadLabels = $topMentors->pluck('name')->values()->all();
        $mentorWorkloadData = $topMentors->pluck('appointment_count')->map(fn ($total) => (int) $total)->values()->all();
        if (empty($mentorWorkloadLabels)) {
            $mentorWorkloadLabels = ['No mentors'];
            $mentorWorkloadData = [0];
        }

        $mentorSlotsByDay = collect($days)
            ->map(fn ($day) => (int) ($timetableCountsByDay[$day]->total ?? 0))
            ->all();

        $teamLeaderTimetableCountsByDay = TeamLeaderTimetable::query()
            ->select('day', DB::raw('count(*) as total'))
            ->groupBy('day')
            ->get()
            ->keyBy('day');
        $teamLeaderReservationsByDay = collect($days)
            ->map(fn ($day) => (int) ($teamLeaderTimetableCountsByDay[$day]->total ?? 0))
            ->all();

        $charts = [
            'roleDistribution' => (new LarapexChart)->donutChart()
                ->setTitle('User Distribution')
                ->setSubtitle('Accounts by role')
                ->setLabels($roleLabels)
                ->addData($roleCounts)
                ->setHeight(280)
                ->setColors(['#2563eb', '#16a34a', '#7c3aed', '#f59e0b']),

            'appointmentsByWeek' => (new LarapexChart)->lineChart()
                ->setTitle('Appointment Trend')
                ->setSubtitle('Bookings, participating students, and active slots by academic week')
                ->addData($appointmentsByWeek, 'Appointments')
                ->addData($uniqueStudentsByWeek, 'Unique students')
                ->addData($activeSlotsByWeek, 'Booked slots')
                ->setXAxis($weekLabels)
                ->setHeight(300)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setMarkers(['#2563eb', '#16a34a', '#f59e0b'], 4, 6)
                ->setStroke(3, ['#2563eb', '#16a34a', '#f59e0b'], 'smooth')
                ->setColors(['#2563eb', '#16a34a', '#f59e0b']),

            'timetableAvailability' => (new LarapexChart)->barChart()
                ->setTitle('Timetable Capacity')
                ->setSubtitle('Reserved and open mentor timetable slots')
                ->addData($reservedByDay, 'Reserved')
                ->addData($openByDay, 'Open')
                ->setXAxis($days)
                ->setHeight(300)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#ef4444', '#14b8a6']),

            'mentorStatus' => (new LarapexChart)->donutChart()
                ->setTitle('Mentor Status')
                ->setLabels($mentorStatusLabels)
                ->addData($mentorStatusData)
                ->setHeight(280)
                ->setColors(['#16a34a', '#f59e0b', '#ef4444', '#64748b']),

            'formCompletion' => (new LarapexChart)->barChart()
                ->setTitle('Form Completion')
                ->setSubtitle('Completed submissions as a share of expected role/form pairs')
                ->addData($formCompletionData, 'Completion %')
                ->setXAxis($formCompletionLabels)
                ->setHeight(280)
                ->setColors(['#7c3aed'])
                ->setDataLabels(),

            'appointmentsByDay' => (new LarapexChart)->barChart()
                ->setTitle('Daily Appointment Load')
                ->setSubtitle('Appointment volume and unique student reach by weekday')
                ->addData($appointmentsByDay, 'Appointments')
                ->addData($studentsByDay, 'Unique students')
                ->setXAxis($days)
                ->setHeight(280)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#0ea5e9', '#22c55e']),

            'appointmentsByTimeSlot' => (new LarapexChart)->horizontalBarChart()
                ->setTitle('Appointments by Time Slot')
                ->setSubtitle('Booked sessions by exact timetable slot')
                ->addData($appointmentsByTimeSlot, 'Appointments')
                ->setXAxis($timeSlotLabels)
                ->setHeight(320)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#14b8a6'])
                ->setDataLabels(),

            'accountGrowth' => (new LarapexChart)->lineChart()
                ->setTitle('Account Creation')
                ->setSubtitle('New accounts by role and date')
                ->addData($this->seriesByRole($accountGrowthRows, $accountGrowthLabels, 'student'), 'Students')
                ->addData($this->seriesByRole($accountGrowthRows, $accountGrowthLabels, 'mentor'), 'Mentors')
                ->addData($this->seriesByRole($accountGrowthRows, $accountGrowthLabels, 'team_leader'), 'Team Leaders')
                ->addData($this->seriesByRole($accountGrowthRows, $accountGrowthLabels, 'admin'), 'Admins')
                ->setXAxis($accountGrowthLabels->all())
                ->setHeight(280)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setMarkers(['#2563eb', '#16a34a', '#7c3aed', '#f59e0b'], 4, 6)
                ->setStroke(3, ['#2563eb', '#16a34a', '#7c3aed', '#f59e0b'], 'smooth')
                ->setColors(['#2563eb', '#16a34a', '#7c3aed', '#f59e0b']),

            'formInventory' => (new LarapexChart)->barChart()
                ->setTitle('Form Inventory')
                ->setSubtitle('Configured forms by type and target role')
                ->addData($formsByTypeAndRole['student'], 'Students')
                ->addData($formsByTypeAndRole['mentor'], 'Mentors')
                ->addData($formsByTypeAndRole['team_leader'], 'Team Leaders')
                ->setXAxis(collect($formTypes)->map(fn ($type) => ucfirst($type))->all())
                ->setHeight(280)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#2563eb', '#16a34a', '#7c3aed']),

            'studentWeeklyActivity' => (new LarapexChart)->lineChart()
                ->setTitle('Student Activity')
                ->setSubtitle('Appointments and unique student participation by week')
                ->addData($appointmentsByWeek, 'Appointments')
                ->addData($uniqueStudentsByWeek, 'Unique students')
                ->setXAxis($weekLabels)
                ->setHeight(300)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setMarkers(['#2563eb', '#16a34a'], 4, 6)
                ->setStroke(3, ['#2563eb', '#16a34a'], 'smooth')
                ->setColors(['#2563eb', '#16a34a']),

            'studentFormCompletionByType' => (new LarapexChart)->barChart()
                ->setTitle('Student Form Completion')
                ->setSubtitle('Completion percentage by form type')
                ->addData($studentCompletionByType['percentages'], 'Completion %')
                ->setXAxis($studentCompletionByType['labels'])
                ->setHeight(280)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#2563eb'])
                ->setDataLabels(),

            'mentorWorkload' => (new LarapexChart)->horizontalBarChart()
                ->setTitle('Mentor Workload')
                ->setSubtitle('Booked appointments by mentor')
                ->addData($mentorWorkloadData, 'Appointments')
                ->setXAxis($mentorWorkloadLabels)
                ->setHeight(320)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#16a34a'])
                ->setDataLabels(),

            'mentorTimetableCoverage' => (new LarapexChart)->barChart()
                ->setTitle('Mentor Timetable Coverage')
                ->setSubtitle('Available mentor slots and booked appointments by day')
                ->addData($mentorSlotsByDay, 'Timetable slots')
                ->addData($appointmentsByDay, 'Appointments')
                ->setXAxis($days)
                ->setHeight(280)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#0ea5e9', '#16a34a']),

            'teamLeaderTimetableByDay' => (new LarapexChart)->barChart()
                ->setTitle('Team Leader Timetables')
                ->setSubtitle('Reserved team leader support slots by day')
                ->addData($teamLeaderReservationsByDay, 'Reservations')
                ->setXAxis($days)
                ->setHeight(280)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#7c3aed'])
                ->setDataLabels(),

            'teamLeaderFormCompletionByType' => (new LarapexChart)->barChart()
                ->setTitle('Team Leader Form Completion')
                ->setSubtitle('Completion percentage by form type')
                ->addData($teamLeaderCompletionByType['percentages'], 'Completion %')
                ->setXAxis($teamLeaderCompletionByType['labels'])
                ->setHeight(280)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#f59e0b'])
                ->setDataLabels(),

            'mentorFormCompletionByType' => (new LarapexChart)->barChart()
                ->setTitle('Mentor Form Completion')
                ->setSubtitle('Completion percentage by form type')
                ->addData($mentorCompletionByType['percentages'], 'Completion %')
                ->setXAxis($mentorCompletionByType['labels'])
                ->setHeight(280)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#16a34a'])
                ->setDataLabels(),
        ];

        $capacity = Timetable::count() * 5;
        $appointmentCount = Appointment::count();
        $activeMentors = Mentor::where('status', 'active')->count();

        $stats = [
            ['label' => 'Users', 'value' => User::count(), 'meta' => 'Total registered accounts', 'accent' => 'bg-blue-600'],
            ['label' => 'Students', 'value' => Student::count(), 'meta' => 'Learner profiles', 'accent' => 'bg-emerald-600'],
            ['label' => 'Mentors', 'value' => Mentor::count(), 'meta' => $activeMentors.' active', 'accent' => 'bg-violet-600'],
            ['label' => 'Team Leaders', 'value' => TeamLeader::count(), 'accent' => 'bg-amber-500'],
            ['label' => 'Appointments', 'value' => $appointmentCount, 'meta' => $capacity > 0 ? round(($appointmentCount / $capacity) * 100, 1).'% capacity used' : 'No capacity yet', 'accent' => 'bg-cyan-600'],
            ['label' => 'Timetables', 'value' => Timetable::count(), 'meta' => array_sum($reservedByDay).' marked reserved', 'accent' => 'bg-rose-600'],
            ['label' => 'Forms', 'value' => Form::count(), 'meta' => 'Active and inactive', 'accent' => 'bg-slate-700'],
            ['label' => 'Completed Forms', 'value' => StudentForm::count() + MentorForm::count() + TeamLeaderForm::count(), 'meta' => 'Recorded completions', 'accent' => 'bg-lime-600'],
        ];

        $rolePanels = [
            'students' => [
                'title' => 'Students',
                'description' => 'Appointment participation and required form progress for learners.',
                'accent' => 'border-blue-600',
                'stats' => [
                    ['label' => 'Students', 'value' => Student::count()],
                    ['label' => 'Appointments', 'value' => $appointmentCount],
                    ['label' => 'Avg. Appts / Student', 'value' => Student::count() > 0 ? round($appointmentCount / Student::count(), 1) : 0],
                    ['label' => 'Form Completion', 'value' => $this->overallCompletionRate($studentCompletionByType).'%'],
                ],
                'charts' => ['studentWeeklyActivity', 'studentFormCompletionByType'],
                'completionRows' => $studentCompletionByType['rows'],
            ],
            'mentors' => [
                'title' => 'Mentors',
                'description' => 'Mentor status, timetable coverage, workload, and form progress.',
                'accent' => 'border-emerald-600',
                'stats' => [
                    ['label' => 'Mentors', 'value' => Mentor::count()],
                    ['label' => 'Active', 'value' => $activeMentors],
                    ['label' => 'Timetable Slots', 'value' => Timetable::count()],
                    ['label' => 'Form Completion', 'value' => $this->overallCompletionRate($mentorCompletionByType).'%'],
                ],
                'charts' => ['mentorWorkload', 'mentorTimetableCoverage', 'mentorFormCompletionByType'],
                'completionRows' => $mentorCompletionByType['rows'],
            ],
            'teamLeaders' => [
                'title' => 'Team Leaders',
                'description' => 'Team leader count, support timetable coverage, and form progress.',
                'accent' => 'border-amber-500',
                'stats' => [
                    ['label' => 'Team Leaders', 'value' => TeamLeader::count()],
                    ['label' => 'Reservations', 'value' => TeamLeaderTimetable::count()],
                    ['label' => 'Reserved Days', 'value' => collect($teamLeaderReservationsByDay)->filter()->count()],
                    ['label' => 'Form Completion', 'value' => $this->overallCompletionRate($teamLeaderCompletionByType).'%'],
                ],
                'charts' => ['teamLeaderTimetableByDay', 'teamLeaderFormCompletionByType'],
                'completionRows' => $teamLeaderCompletionByType['rows'],
            ],
        ];

        return view('admin.databaseAnalytics', [
            'charts' => $charts,
            'stats' => $stats,
            'rolePanels' => $rolePanels,
            'facultyRows' => $facultyRows,
            'topMentors' => $topMentors,
            'formCompletionStats' => $formCompletionStats,
            'dayLoadRows' => $this->dayLoadRows($days, $appointmentRowsByDay, $timetableCountsByDay),
            'timeSlotRows' => $appointmentRowsByTimeSlot,
        ]);
    }

    private function formCompletionStats()
    {
        $roles = [
            [
                'label' => 'Students',
                'people' => Student::count(),
                'forms' => Form::where('for_role', 'student')->count(),
                'completed' => StudentForm::where('completion_status', true)->count(),
            ],
            [
                'label' => 'Mentors',
                'people' => Mentor::count(),
                'forms' => Form::where('for_role', 'mentor')->count(),
                'completed' => MentorForm::where('completion_status', true)->count(),
            ],
            [
                'label' => 'Team Leaders',
                'people' => TeamLeader::count(),
                'forms' => Form::where('for_role', 'team_leader')->count(),
                'completed' => TeamLeaderForm::where('completion_status', true)->count(),
            ],
        ];

        return collect($roles)->map(function ($role) {
            $expected = $role['people'] * $role['forms'];

            return [
                'label' => $role['label'],
                'people' => $role['people'],
                'forms' => $role['forms'],
                'completed' => $role['completed'],
                'expected' => $expected,
                'percentage' => $expected > 0 ? round(($role['completed'] / $expected) * 100, 1) : 0,
            ];
        });
    }

    private function seriesByRole($rows, $labels, string $role): array
    {
        return $labels->map(function ($label) use ($rows, $role) {
            return (int) ($rows->first(fn ($row) => $row->created_day === $label && $row->role === $role)->total ?? 0);
        })->all();
    }

    private function dayLoadRows(array $days, $appointmentRowsByDay, $timetableCountsByDay)
    {
        return collect($days)->map(function ($day) use ($appointmentRowsByDay, $timetableCountsByDay) {
            $appointments = (int) ($appointmentRowsByDay[$day]->total ?? 0);
            $students = (int) ($appointmentRowsByDay[$day]->student_total ?? 0);
            $slots = (int) ($timetableCountsByDay[$day]->total ?? 0);
            $capacity = $slots * 5;

            return [
                'day' => $day,
                'appointments' => $appointments,
                'students' => $students,
                'slots' => $slots,
                'capacity' => $capacity,
                'utilization' => $capacity > 0 ? round(($appointments / $capacity) * 100, 1) : 0,
            ];
        });
    }

    private function completionByType(string $role, int $peopleCount, string $completionModel): array
    {
        $types = ['pretest', 'posttest', 'questionnaire', 'consent'];

        $rows = collect($types)->map(function ($type) use ($role, $peopleCount, $completionModel) {
            $formsCount = Form::where('for_role', $role)->where('form_type', $type)->count();
            $expected = $peopleCount * $formsCount;
            $completed = $completionModel::query()
                ->join('forms', 'forms.id', '=', $completionModel::query()->getModel()->getTable().'.form_id')
                ->where('forms.for_role', $role)
                ->where('forms.form_type', $type)
                ->where('completion_status', true)
                ->count();

            return [
                'type' => ucfirst($type),
                'forms' => $formsCount,
                'expected' => $expected,
                'completed' => $completed,
                'percentage' => $expected > 0 ? round(($completed / $expected) * 100, 1) : 0,
            ];
        });

        return [
            'labels' => $rows->pluck('type')->all(),
            'percentages' => $rows->pluck('percentage')->all(),
            'rows' => $rows,
        ];
    }

    private function overallCompletionRate(array $completionByType): float
    {
        $expected = $completionByType['rows']->sum('expected');
        $completed = $completionByType['rows']->sum('completed');

        return $expected > 0 ? round(($completed / $expected) * 100, 1) : 0;
    }
}
