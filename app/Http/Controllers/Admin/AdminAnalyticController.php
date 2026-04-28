<?php

namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;

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

        $facultyRows = DB::table(DB::raw("(select coalesce(nullif(faculty, ''), 'Unassigned') as faculty_name from users) as sub"))
            ->select('faculty_name as faculty', DB::raw('count(*) as total'))
            ->groupBy('faculty_name')
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

        $appointmentHeatmap = $this->appointmentHeatmap($days);
        $capacityByWeek = $this->capacityByWeek($appointmentRowsByWeek);
        $overbookedTimetables = $this->overbookedTimetables();
        $studentBookingDistribution = $this->studentBookingDistribution();
        $mentorCapacityRows = $this->mentorCapacityRows();
        $mentorFillRows = $mentorCapacityRows->sortByDesc('fill_rate')->take(10)->values();
        $mentorTimetableRows = $mentorCapacityRows->sortByDesc('timetable_count')->take(10)->values();
        $mentorFillLabels = $this->labelsOrFallback($mentorFillRows->pluck('name'), 'No mentor data');
        $mentorFillData = $this->valuesOrFallback($mentorFillRows->pluck('fill_rate'));
        $mentorTimetableLabels = $this->labelsOrFallback($mentorTimetableRows->pluck('name'), 'No mentor data');
        $mentorTimetableData = $this->valuesOrFallback($mentorTimetableRows->pluck('timetable_count'));
        $mentorStatusByFaculty = $this->mentorStatusBreakdown('faculty');
        $mentorStatusByLanguage = $this->mentorStatusBreakdown('language');
        $mentorStatusByLevel = $this->mentorStatusBreakdown('level');
        $studentFacultyRows = $this->profileDimensionRows('student', 'faculty');
        $studentLanguageRows = $this->profileDimensionRows('student', 'language');
        $studentLevelRows = $this->profileDimensionRows('student', 'level');
        $studentParticipation = $this->studentAppointmentParticipation();
        $topStudentRows = $this->topStudentRows();
        $mandatoryFormStats = $this->mandatoryFormStats();
        $formCompletionTrend = $this->formCompletionTrend();
        $teamLeaderSlotHeatmap = $this->teamLeaderSlotHeatmap();
        $teamLeaderReservationStats = $this->teamLeaderReservationStats();

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

            'appointmentHeatmap' => (new LarapexChart)->heatMapChart()
                ->setTitle('Appointments by Weekday and Time')
                ->setSubtitle('Booked sessions by day and timetable slot')
                ->setXAxis($appointmentHeatmap['labels'])
                ->setDataset($appointmentHeatmap['series'])
                ->setHeight(340)
                ->setColors(['#0ea5e9']),

            'capacityUsageByWeek' => (new LarapexChart)->barChart()
                ->setTitle('Capacity Usage by Week')
                ->setSubtitle('Booked appointments compared with available timetable capacity')
                ->addData($capacityByWeek['booked'], 'Booked')
                ->addData($capacityByWeek['capacity'], 'Capacity')
                ->setXAxis($weekLabels)
                ->setHeight(320)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#0ea5e9', '#94a3b8']),

            'overbookedTimetables' => (new LarapexChart)->horizontalBarChart()
                ->setTitle('Overbooked Timetables')
                ->setSubtitle('Slots with more than 5 booked appointments')
                ->addData($overbookedTimetables['data'], 'Appointments')
                ->setXAxis($overbookedTimetables['labels'])
                ->setHeight(340)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#ef4444'])
                ->setDataLabels(),

            'studentBookingDistribution' => (new LarapexChart)->donutChart()
                ->setTitle('Student Booking Distribution')
                ->setSubtitle('Students grouped by appointment count')
                ->setLabels($studentBookingDistribution['labels'])
                ->addData($studentBookingDistribution['data'])
                ->setHeight(300)
                ->setColors(['#94a3b8', '#0ea5e9', '#14b8a6', '#f59e0b', '#ef4444']),

            'mentorFillRate' => (new LarapexChart)->horizontalBarChart()
                ->setTitle('Mentor Fill Rate')
                ->setSubtitle('Appointments booked as a percentage of mentor capacity')
                ->addData($mentorFillData, 'Fill %')
                ->setXAxis($mentorFillLabels)
                ->setHeight(340)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#16a34a'])
                ->setDataLabels(),

            'mentorTimetableCount' => (new LarapexChart)->horizontalBarChart()
                ->setTitle('Mentor Timetable Count')
                ->setSubtitle('Mentors with the most created timetable slots')
                ->addData($mentorTimetableData, 'Slots')
                ->setXAxis($mentorTimetableLabels)
                ->setHeight(340)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#0ea5e9'])
                ->setDataLabels(),

            'mentorStatusByFaculty' => (new LarapexChart)->barChart()
                ->setTitle('Mentor Status by Faculty')
                ->setSubtitle('Active, paused, and suspended mentors by faculty')
                ->setStacked(true)
                ->setDataset($mentorStatusByFaculty['series'])
                ->setXAxis($mentorStatusByFaculty['labels'])
                ->setHeight(320)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#16a34a', '#f59e0b', '#ef4444']),

            'mentorStatusByLanguage' => (new LarapexChart)->barChart()
                ->setTitle('Mentor Status by Language')
                ->setSubtitle('Active, paused, and suspended mentors by language')
                ->setStacked(true)
                ->setDataset($mentorStatusByLanguage['series'])
                ->setXAxis($mentorStatusByLanguage['labels'])
                ->setHeight(320)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#16a34a', '#f59e0b', '#ef4444']),

            'mentorStatusByLevel' => (new LarapexChart)->barChart()
                ->setTitle('Mentor Status by Level')
                ->setSubtitle('Active, paused, and suspended mentors by level')
                ->setStacked(true)
                ->setDataset($mentorStatusByLevel['series'])
                ->setXAxis($mentorStatusByLevel['labels'])
                ->setHeight(320)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#16a34a', '#f59e0b', '#ef4444']),

            'studentsByFaculty' => (new LarapexChart)->barChart()
                ->setTitle('Students by Faculty')
                ->setSubtitle('Student accounts grouped by recorded faculty')
                ->addData($this->valuesOrFallback($studentFacultyRows->pluck('total')), 'Students')
                ->setXAxis($this->labelsOrFallback($studentFacultyRows->pluck('label'), 'No faculty data'))
                ->setHeight(300)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#2563eb'])
                ->setDataLabels(),

            'studentsByLanguage' => (new LarapexChart)->barChart()
                ->setTitle('Students by Language')
                ->setSubtitle('Student accounts grouped by recorded language')
                ->addData($this->valuesOrFallback($studentLanguageRows->pluck('total')), 'Students')
                ->setXAxis($this->labelsOrFallback($studentLanguageRows->pluck('label'), 'No language data'))
                ->setHeight(300)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#14b8a6'])
                ->setDataLabels(),

            'studentsByLevel' => (new LarapexChart)->barChart()
                ->setTitle('Students by Level')
                ->setSubtitle('Student accounts grouped by recorded level')
                ->addData($this->valuesOrFallback($studentLevelRows->pluck('total')), 'Students')
                ->setXAxis($this->labelsOrFallback($studentLevelRows->pluck('label'), 'No level data'))
                ->setHeight(300)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#7c3aed'])
                ->setDataLabels(),

            'studentAppointmentParticipation' => (new LarapexChart)->donutChart()
                ->setTitle('Student Appointment Participation')
                ->setSubtitle('Students with at least one appointment compared with students without bookings')
                ->setLabels($studentParticipation['labels'])
                ->addData($studentParticipation['data'])
                ->setHeight(300)
                ->setColors(['#16a34a', '#94a3b8']),

            'topStudentsByAppointmentCount' => (new LarapexChart)->horizontalBarChart()
                ->setTitle('Top Students by Appointment Count')
                ->setSubtitle('Most active students by booked appointment count')
                ->addData($this->valuesOrFallback($topStudentRows->pluck('appointment_count')), 'Appointments')
                ->setXAxis($this->labelsOrFallback($topStudentRows->pluck('name'), 'No student bookings'))
                ->setHeight(340)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#f59e0b'])
                ->setDataLabels(),

            'mandatoryFormCompletionRate' => (new LarapexChart)->barChart()
                ->setTitle('Mandatory Form Completion Rate')
                ->setSubtitle('Completed mandatory submissions as a share of expected role/form pairs')
                ->addData($mandatoryFormStats->pluck('percentage')->all(), 'Completion %')
                ->setXAxis($mandatoryFormStats->pluck('label')->all())
                ->setHeight(300)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#7c3aed'])
                ->setDataLabels(),

            'formCompletionTrend' => (new LarapexChart)->lineChart()
                ->setTitle('Form Completion Trend')
                ->setSubtitle('Recorded form submissions by date')
                ->addData($formCompletionTrend['data'], 'Submissions')
                ->setXAxis($formCompletionTrend['labels'])
                ->setHeight(320)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setMarkers(['#0ea5e9'], 4, 6)
                ->setStroke(3, ['#0ea5e9'], 'smooth')
                ->setColors(['#0ea5e9']),

            'incompleteMandatoryFormsByRole' => (new LarapexChart)->barChart()
                ->setTitle('Incomplete Mandatory Forms by Role')
                ->setSubtitle('Expected mandatory submissions that have not been completed')
                ->addData($mandatoryFormStats->pluck('incomplete')->all(), 'Incomplete')
                ->setXAxis($mandatoryFormStats->pluck('label')->all())
                ->setHeight(300)
                ->setGrid('#e5e7eb', 0.45, 4)
                ->setColors(['#ef4444'])
                ->setDataLabels(),

            'teamLeaderSlotUsage' => (new LarapexChart)->heatMapChart()
                ->setTitle('Team Leader Slot Usage')
                ->setSubtitle('Team leader reservations by day and time')
                ->setXAxis($teamLeaderSlotHeatmap['labels'])
                ->setDataset($teamLeaderSlotHeatmap['series'])
                ->setHeight(320)
                ->setColors(['#f59e0b']),

            'teamLeadersWithoutTimetable' => (new LarapexChart)->donutChart()
                ->setTitle('Team Leaders Without Timetable')
                ->setSubtitle('Reservation coverage for team leader accounts')
                ->setLabels($teamLeaderReservationStats['labels'])
                ->addData($teamLeaderReservationStats['data'])
                ->setHeight(300)
                ->setColors(['#16a34a', '#ef4444']),
        ];

        $chartPicker = $this->chartPickerOptions();
        $slideshowCharts = collect($chartPicker)
            ->filter(fn ($option, $key) => isset($charts[$key]))
            ->mapWithKeys(fn ($option, $key) => [$key => $this->cloneChartForSlideshow($charts[$key])])
            ->all();

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

        $chartSections = [
            [
                'title' => 'Appointment Insights',
                'description' => 'Booking demand, capacity, overbooking risk, and student booking patterns.',
                'charts' => [
                    ['key' => 'appointmentHeatmap', 'span' => 'lg:col-span-2'],
                    ['key' => 'studentBookingDistribution'],
                    ['key' => 'capacityUsageByWeek', 'span' => 'lg:col-span-2'],
                    ['key' => 'overbookedTimetables'],
                ],
            ],
            [
                'title' => 'Mentor Insights',
                'description' => 'Mentor capacity, timetable coverage, and status distribution by profile fields.',
                'charts' => [
                    ['key' => 'mentorFillRate'],
                    ['key' => 'mentorTimetableCount'],
                    ['key' => 'mentorStatusByFaculty'],
                    ['key' => 'mentorStatusByLanguage'],
                    ['key' => 'mentorStatusByLevel'],
                ],
            ],
            [
                'title' => 'Student Insights',
                'description' => 'Student profile distribution, participation, and high-activity students.',
                'charts' => [
                    ['key' => 'studentsByFaculty'],
                    ['key' => 'studentsByLanguage'],
                    ['key' => 'studentsByLevel'],
                    ['key' => 'studentAppointmentParticipation'],
                    ['key' => 'topStudentsByAppointmentCount', 'span' => 'lg:col-span-2'],
                ],
            ],
            [
                'title' => 'Form Insights',
                'description' => 'Mandatory form progress and submission activity over time.',
                'charts' => [
                    ['key' => 'mandatoryFormCompletionRate'],
                    ['key' => 'incompleteMandatoryFormsByRole'],
                    ['key' => 'formCompletionTrend', 'span' => 'lg:col-span-2'],
                ],
            ],
            [
                'title' => 'Team Leader Insights',
                'description' => 'Team leader timetable coverage and reservation patterns.',
                'charts' => [
                    ['key' => 'teamLeaderSlotUsage', 'span' => 'lg:col-span-2'],
                    ['key' => 'teamLeadersWithoutTimetable'],
                ],
            ],
        ];

        return view('admin.databaseAnalytics', [
            'charts' => $charts,
            'slideshowCharts' => $slideshowCharts,
            'chartPicker' => $chartPicker,
            'chartSections' => $chartSections,
            'stats' => $stats,
            'rolePanels' => $rolePanels,
            'facultyRows' => $facultyRows,
            'topMentors' => $topMentors,
            'formCompletionStats' => $formCompletionStats,
            'dayLoadRows' => $this->dayLoadRows($days, $appointmentRowsByDay, $timetableCountsByDay),
            'timeSlotRows' => $appointmentRowsByTimeSlot,
        ]);
    }

    private function chartPickerOptions(): array
    {
        return [
            'roleDistribution' => ['label' => 'User Distribution'],
            'appointmentsByWeek' => ['label' => 'Appointment Trend'],
            'timetableAvailability' => ['label' => 'Timetable Capacity'],
            'mentorStatus' => ['label' => 'Mentor Status'],
            'appointmentsByDay' => ['label' => 'Daily Appointment Load'],
            'appointmentsByTimeSlot' => ['label' => 'Appointments by Time Slot'],
            'accountGrowth' => ['label' => 'Account Creation'],
            'formInventory' => ['label' => 'Form Inventory'],
            'formCompletion' => ['label' => 'Form Completion'],
            'studentWeeklyActivity' => ['label' => 'Student Activity'],
            'studentFormCompletionByType' => ['label' => 'Student Form Completion'],
            'mentorWorkload' => ['label' => 'Mentor Workload'],
            'mentorTimetableCoverage' => ['label' => 'Mentor Timetable Coverage'],
            'mentorFormCompletionByType' => ['label' => 'Mentor Form Completion'],
            'teamLeaderTimetableByDay' => ['label' => 'Team Leader Timetables'],
            'teamLeaderFormCompletionByType' => ['label' => 'Team Leader Form Completion'],
            'appointmentHeatmap' => ['label' => 'Appointment Heatmap'],
            'capacityUsageByWeek' => ['label' => 'Capacity Usage by Week'],
            'overbookedTimetables' => ['label' => 'Overbooked Timetables'],
            'studentBookingDistribution' => ['label' => 'Student Booking Distribution'],
            'mentorFillRate' => ['label' => 'Mentor Fill Rate'],
            'mentorTimetableCount' => ['label' => 'Mentor Timetable Count'],
            'mentorStatusByFaculty' => ['label' => 'Mentor Status by Faculty'],
            'mentorStatusByLanguage' => ['label' => 'Mentor Status by Language'],
            'mentorStatusByLevel' => ['label' => 'Mentor Status by Level'],
            'studentsByFaculty' => ['label' => 'Students by Faculty'],
            'studentsByLanguage' => ['label' => 'Students by Language'],
            'studentsByLevel' => ['label' => 'Students by Level'],
            'studentAppointmentParticipation' => ['label' => 'Student Participation'],
            'topStudentsByAppointmentCount' => ['label' => 'Top Students by Appointments'],
            'mandatoryFormCompletionRate' => ['label' => 'Mandatory Form Completion'],
            'formCompletionTrend' => ['label' => 'Form Completion Trend'],
            'incompleteMandatoryFormsByRole' => ['label' => 'Incomplete Mandatory Forms'],
            'teamLeaderSlotUsage' => ['label' => 'Team Leader Slot Usage'],
            'teamLeadersWithoutTimetable' => ['label' => 'Team Leaders Without Timetable'],
        ];
    }

    private function cloneChartForSlideshow(LarapexChart $chart): LarapexChart
    {
        $clone = clone $chart;
        $clone->id = 'slide'.\Illuminate\Support\Str::random(20);

        return $clone;
    }

    private function appointmentHeatmap(array $days): array
    {
        $timeSlots = Timetable::query()
            ->select('time_slot')
            ->distinct()
            ->orderBy('time_slot')
            ->pluck('time_slot');

        if ($timeSlots->isEmpty()) {
            $timeSlots = collect(['No slots']);
        }

        $rows = Appointment::query()
            ->join('timetables', 'appointments.timetable_id', '=', 'timetables.id')
            ->select('timetables.day', 'timetables.time_slot', DB::raw('count(*) as total'))
            ->groupBy('timetables.day', 'timetables.time_slot')
            ->get();

        return [
            'labels' => $timeSlots->all(),
            'series' => collect($days)->map(function ($day) use ($timeSlots, $rows) {
                return [
                    'name' => $day,
                    'data' => $timeSlots->map(function ($slot) use ($day, $rows) {
                        return (int) ($rows->first(fn ($row) => $row->day === $day && $row->time_slot === $slot)->total ?? 0);
                    })->all(),
                ];
            })->all(),
        ];
    }

    private function capacityByWeek($appointmentRowsByWeek): array
    {
        $capacityRowsByWeek = Timetable::query()
            ->select('week_number', DB::raw('count(*) * 5 as capacity_total'))
            ->groupBy('week_number')
            ->get()
            ->keyBy('week_number');

        return [
            'booked' => collect(range(1, 16))
                ->map(fn ($week) => (int) ($appointmentRowsByWeek[(string) $week]->total ?? 0))
                ->all(),
            'capacity' => collect(range(1, 16))
                ->map(fn ($week) => (int) ($capacityRowsByWeek[(string) $week]->capacity_total ?? 0))
                ->all(),
        ];
    }

    private function overbookedTimetables(): array
    {
        $rows = Appointment::query()
            ->join('timetables', 'appointments.timetable_id', '=', 'timetables.id')
            ->select(
                'timetables.week_number',
                'timetables.day',
                'timetables.time_slot',
                'timetables.table_number',
                DB::raw('count(*) as total')
            )
            ->groupBy('timetables.week_number', 'timetables.day', 'timetables.time_slot', 'timetables.table_number')
            ->havingRaw('count(*) > 5')
            ->orderByDesc('total')
            ->limit(12)
            ->get();

        return [
            'labels' => $this->labelsOrFallback($rows->map(fn ($row) => 'W'.$row->week_number.' '.$row->day.' '.$row->time_slot.' T'.$row->table_number), 'No overbooked slots'),
            'data' => $this->valuesOrFallback($rows->pluck('total')),
        ];
    }

    private function studentBookingDistribution(): array
    {
        $counts = Appointment::query()
            ->select('student_id', DB::raw('count(*) as total'))
            ->groupBy('student_id')
            ->pluck('total', 'student_id');

        return [
            'labels' => ['0 appointments', '1 appointment', '2 appointments', '3 appointments', '4+ appointments'],
            'data' => [
                max(0, Student::count() - $counts->count()),
                $counts->filter(fn ($total) => (int) $total === 1)->count(),
                $counts->filter(fn ($total) => (int) $total === 2)->count(),
                $counts->filter(fn ($total) => (int) $total === 3)->count(),
                $counts->filter(fn ($total) => (int) $total >= 4)->count(),
            ],
        ];
    }

    private function mentorCapacityRows()
    {
        return Mentor::query()
            ->join('users', 'mentors.user_id', '=', 'users.id')
            ->leftJoin('timetables', 'mentors.id', '=', 'timetables.mentor_id')
            ->leftJoin('appointments', 'timetables.id', '=', 'appointments.timetable_id')
            ->select(
                'mentors.id',
                'users.name',
                DB::raw('count(distinct timetables.id) as timetable_count'),
                DB::raw('count(appointments.id) as appointment_count')
            )
            ->groupBy('mentors.id', 'users.name')
            ->get()
            ->map(function ($row) {
                $capacity = (int) $row->timetable_count * 5;
                $row->capacity = $capacity;
                $row->fill_rate = $capacity > 0 ? round(((int) $row->appointment_count / $capacity) * 100, 1) : 0;

                return $row;
            });
    }

    private function mentorStatusBreakdown(string $column): array
    {
        $statuses = ['active', 'paused', 'suspended'];

        $rows = DB::table(DB::raw("
            (select coalesce(nullif(users.{$column}, ''), 'Unassigned') as label,
                    mentors.status
             from mentors
             inner join users on mentors.user_id = users.id) as sub
        "))
            ->select('label', 'status', DB::raw('count(*) as total'))
            ->groupBy('label', 'status')
            ->get();

        $labels = $rows->groupBy('label')
            ->map(fn ($items) => $items->sum('total'))
            ->sortDesc()
            ->keys()
            ->take(8)
            ->values();

        if ($labels->isEmpty()) {
            $labels = collect(['No data']);
        }

        return [
            'labels' => $labels->all(),
            'series' => collect($statuses)->map(function ($status) use ($labels, $rows) {
                return [
                    'name' => ucfirst($status),
                    'data' => $labels->map(function ($label) use ($status, $rows) {
                        return (int) ($rows->first(fn ($row) => $row->label === $label && $row->status === $status)->total ?? 0);
                    })->all(),
                ];
            })->all(),
        ];
    }

    private function profileDimensionRows(string $role, string $column)
    {
        $sub = DB::table('users')
            ->selectRaw("coalesce(nullif({$column}, ''), 'Unassigned') as label")
            ->where('role', $role);

        return DB::table($sub, 'sub')
            ->select('label', DB::raw('count(*) as total'))
            ->groupBy('label')
            ->orderByDesc('total')
            ->limit(8)
            ->get();
    }

    private function studentAppointmentParticipation(): array
    {
        $totalStudents = Student::count();
        $withAppointments = Appointment::query()
            ->select('student_id')
            ->distinct()
            ->count('student_id');

        return [
            'labels' => ['With appointments', 'Without appointments'],
            'data' => [$withAppointments, max(0, $totalStudents - $withAppointments)],
        ];
    }

    private function topStudentRows()
    {
        return Student::query()
            ->join('users', 'students.user_id', '=', 'users.id')
            ->leftJoin('appointments', 'students.id', '=', 'appointments.student_id')
            ->select('students.id', 'students.student_id', 'users.name', DB::raw('count(appointments.id) as appointment_count'))
            ->groupBy('students.id', 'students.student_id', 'users.name')
            ->havingRaw('count(appointments.id) > 0')
            ->orderByDesc('appointment_count')
            ->limit(10)
            ->get();
    }

    private function mandatoryFormStats()
    {
        $roles = [
            ['label' => 'Students', 'role' => 'student', 'people' => Student::count(), 'model' => StudentForm::class],
            ['label' => 'Mentors', 'role' => 'mentor', 'people' => Mentor::count(), 'model' => MentorForm::class],
            ['label' => 'Team Leaders', 'role' => 'team_leader', 'people' => TeamLeader::count(), 'model' => TeamLeaderForm::class],
        ];

        return collect($roles)->map(function ($role) {
            $forms = Form::where('for_role', $role['role'])->where('is_mandatory', true)->count();
            $expected = $role['people'] * $forms;
            $completed = $role['model']::query()
                ->join('forms', 'forms.id', '=', $role['model']::query()->getModel()->getTable().'.form_id')
                ->where('forms.for_role', $role['role'])
                ->where('forms.is_mandatory', true)
                ->where('completion_status', true)
                ->count();

            return [
                'label' => $role['label'],
                'expected' => $expected,
                'completed' => $completed,
                'incomplete' => max(0, $expected - $completed),
                'percentage' => $expected > 0 ? round(($completed / $expected) * 100, 1) : 0,
            ];
        });
    }

    private function formCompletionTrend(): array
    {
        $rows = collect([StudentForm::class, MentorForm::class, TeamLeaderForm::class])
            ->flatMap(function ($model) {
                return $model::query()
                    ->select(DB::raw('date(submitted_datetime) as submitted_day'), DB::raw('count(*) as total'))
                    ->whereNotNull('submitted_datetime')
                    ->where('completion_status', true)
                    ->groupBy(DB::raw('date(submitted_datetime)'))
                    ->get();
            })
            ->groupBy('submitted_day')
            ->map(fn ($items, $day) => ['day' => $day, 'total' => $items->sum('total')])
            ->sortBy('day')
            ->values();

        if ($rows->isEmpty()) {
            return ['labels' => ['No submissions'], 'data' => [0]];
        }

        return [
            'labels' => $rows->pluck('day')->all(),
            'data' => $rows->pluck('total')->map(fn ($total) => (int) $total)->all(),
        ];
    }

    private function teamLeaderSlotHeatmap(): array
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = TeamLeaderTimetable::query()
            ->select('time_slot')
            ->distinct()
            ->orderBy('time_slot')
            ->pluck('time_slot');

        if ($timeSlots->isEmpty()) {
            $timeSlots = collect(['No slots']);
        }

        $rows = TeamLeaderTimetable::query()
            ->select('day', 'time_slot', DB::raw('count(*) as total'))
            ->groupBy('day', 'time_slot')
            ->get();

        return [
            'labels' => $timeSlots->all(),
            'series' => collect($days)->map(function ($day) use ($timeSlots, $rows) {
                return [
                    'name' => $day,
                    'data' => $timeSlots->map(function ($slot) use ($day, $rows) {
                        return (int) ($rows->first(fn ($row) => $row->day === $day && $row->time_slot === $slot)->total ?? 0);
                    })->all(),
                ];
            })->all(),
        ];
    }

    private function teamLeaderReservationStats(): array
    {
        $total = TeamLeader::count();
        $reserved = TeamLeaderTimetable::query()
            ->select('team_leader_id')
            ->distinct()
            ->count('team_leader_id');

        return [
            'labels' => ['Reserved timetable', 'No timetable'],
            'data' => [$reserved, max(0, $total - $reserved)],
        ];
    }

    private function labelsOrFallback($values, string $fallback): array
    {
        $labels = collect($values)
            ->filter(fn ($value) => $value !== null && $value !== '')
            ->map(fn ($value) => (string) $value)
            ->values();

        return $labels->isEmpty() ? [$fallback] : $labels->all();
    }

    private function valuesOrFallback($values): array
    {
        $data = collect($values)
            ->map(fn ($value) => is_numeric($value) ? $value + 0 : 0)
            ->values();

        return $data->isEmpty() ? [0] : $data->all();
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