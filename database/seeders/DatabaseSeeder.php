<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\FileUploadLink;
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
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run()
    {
        // Create Admin User
        User::factory()->create([
            'name' => 'Demo Admin',
            'nickname' => 'admin',
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpassword'),
        ]);

        $forms = $this->createDemoForms();
        $this->createDemoUploadLinks();

        // Create many Students
        $students = Student::factory()->count(100)->create();

        // Create many Mentors
        $mentors = Mentor::factory()->count(15)->create();

        // Create Team Leaders
        $teamLeaders = TeamLeader::factory()->count(8)->create();

        // Track used table numbers for each time slot to prevent duplicates
        $usedTables = [];
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlotPairs = [
            ['09:00-09:30', '09:30-10:00'],
            ['10:00-10:30', '10:30-11:00'],
            ['11:00-11:30', '11:30-12:00'],
            ['13:00-13:30', '13:30-14:00'],
            ['14:00-14:30', '14:30-15:00'],
        ];

        // Assign timetables for each mentor
        foreach ($mentors as $index => $mentor) {
            $day = $days[$index % count($days)];
            $timeSlots = $timeSlotPairs[$index % count($timeSlotPairs)];

            foreach (range(1, 10) as $week) {
                // Assign an available table number
                $tableNumber = $this->getAvailableTableNumber($usedTables, $day, $timeSlots[0], $week);

                // First half-hour slot
                Timetable::factory()->create([
                    'mentor_id' => $mentor->id,
                    'day' => $day,
                    'time_slot' => $timeSlots[0],
                    'table_number' => $tableNumber,
                    'week_number' => (string) $week, // Cast week to string for enum compatibility
                ]);

                // Second half-hour slot
                Timetable::factory()->create([
                    'mentor_id' => $mentor->id,
                    'day' => $day,
                    'time_slot' => $timeSlots[1],
                    'table_number' => $tableNumber,
                    'week_number' => (string) $week, // Cast week to string for enum compatibility
                ]);
            }
        }

        $this->createTeamLeaderTimetables($teamLeaders);

        // Assign 10 random appointments for each student across different weeks
        $timetables = Timetable::all();

        foreach ($students as $student) {
            $randomTimetables = $timetables->random(10);

            foreach ($randomTimetables as $timetable) {
                Appointment::factory()->create([
                    'student_id' => $student->id,
                    'timetable_id' => $timetable->id,
                ]);
            }
        }

        $this->markFullTimetables();
        $this->createDemoFormCompletions($forms, $students, $mentors, $teamLeaders);
    }

    private function createDemoForms()
    {
        $forms = collect();

        $formDefinitions = [
            ['form_name' => 'Student Consent Form', 'form_type' => 'consent', 'for_role' => 'student', 'is_mandatory' => true],
            ['form_name' => 'Student English Pre-test', 'form_type' => 'pretest', 'for_role' => 'student', 'is_mandatory' => true],
            ['form_name' => 'Student English Post-test', 'form_type' => 'posttest', 'for_role' => 'student', 'is_mandatory' => true],
            ['form_name' => 'Student Feedback Questionnaire', 'form_type' => 'questionnaire', 'for_role' => 'student', 'is_mandatory' => false],
            ['form_name' => 'Mentor Consent Form', 'form_type' => 'consent', 'for_role' => 'mentor', 'is_mandatory' => true],
            ['form_name' => 'Mentor Training Pre-test', 'form_type' => 'pretest', 'for_role' => 'mentor', 'is_mandatory' => true],
            ['form_name' => 'Mentor Training Post-test', 'form_type' => 'posttest', 'for_role' => 'mentor', 'is_mandatory' => true],
            ['form_name' => 'Mentor Reflection Questionnaire', 'form_type' => 'questionnaire', 'for_role' => 'mentor', 'is_mandatory' => false],
            ['form_name' => 'Team Leader Consent Form', 'form_type' => 'consent', 'for_role' => 'team_leader', 'is_mandatory' => true],
            ['form_name' => 'Team Leader Pre-test', 'form_type' => 'pretest', 'for_role' => 'team_leader', 'is_mandatory' => true],
            ['form_name' => 'Team Leader Post-test', 'form_type' => 'posttest', 'for_role' => 'team_leader', 'is_mandatory' => true],
            ['form_name' => 'Team Leader Questionnaire', 'form_type' => 'questionnaire', 'for_role' => 'team_leader', 'is_mandatory' => false],
        ];

        foreach ($formDefinitions as $definition) {
            $forms->push(Form::create([
                ...$definition,
                'form_description' => 'https://forms.example.test/'.str($definition['form_name'])->slug(),
                'is_active' => true,
            ]));
        }

        return $forms;
    }

    private function createDemoUploadLinks(): void
    {
        foreach ([
            ['name' => 'Student File Upload', 'for_role' => 'student'],
            ['name' => 'Mentor File Upload', 'for_role' => 'mentor'],
            ['name' => 'Team Leader File Upload', 'for_role' => 'team_leader'],
        ] as $link) {
            FileUploadLink::create([
                'name' => $link['name'],
                'url' => 'https://drive.example.test/'.str($link['name'])->slug(),
                'for_role' => $link['for_role'],
            ]);
        }
    }

    private function createTeamLeaderTimetables($teamLeaders): void
    {
        $days = ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday'];
        $timeSlots = ['09:00-11:00', '11:00-13:00', '13:00-15:00', '15:00-17:00'];

        foreach ($teamLeaders as $index => $teamLeader) {
            TeamLeaderTimetable::create([
                'team_leader_id' => $teamLeader->id,
                'day' => $days[$index % count($days)],
                'time_slot' => $timeSlots[$index % count($timeSlots)],
            ]);
        }
    }

    private function markFullTimetables(): void
    {
        Timetable::withCount('appointments')->get()->each(function (Timetable $timetable) {
            if ($timetable->appointments_count >= 5) {
                $timetable->update(['reserved' => true]);
            }
        });
    }

    private function createDemoFormCompletions($forms, $students, $mentors, $teamLeaders): void
    {
        $this->completeFormsForRole($forms->where('for_role', 'student'), $students, StudentForm::class, 'student_id', 82);
        $this->completeFormsForRole($forms->where('for_role', 'mentor'), $mentors, MentorForm::class, 'mentor_id', 76);
        $this->completeFormsForRole($forms->where('for_role', 'team_leader'), $teamLeaders, TeamLeaderForm::class, 'team_leader_id', 68);
    }

    private function completeFormsForRole($forms, $people, string $modelClass, string $foreignKey, int $completionPercent): void
    {
        foreach ($people as $person) {
            foreach ($forms as $form) {
                if (fake()->numberBetween(1, 100) <= $completionPercent) {
                    $modelClass::create([
                        $foreignKey => $person->id,
                        'form_id' => $form->id,
                        'completion_status' => true,
                        'submitted_datetime' => fake()->dateTimeBetween('-45 days', 'now'),
                    ]);
                }
            }
        }
    }

    /**
     * Get an available table number for a given day, time slot, and week.
     */
    private function getAvailableTableNumber(&$usedTables, $day, $timeSlot, $week)
    {
        $key = "{$day}-{$timeSlot}-{$week}";

        // Initialize used tables if not set
        if (!isset($usedTables[$key])) {
            $usedTables[$key] = [];
        }

        // Find an available table number from 1 to 25
        for ($table = 1; $table <= 25; $table++) {
            if (!in_array($table, $usedTables[$key])) {
                $usedTables[$key][] = $table;
                return $table;
            }
        }

        throw new \Exception("No available tables for {$day} at {$timeSlot} for week {$week}");
    }
}