<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\Mentor;
use App\Models\Student;
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
            'role' => 'admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('adminpassword'),
        ]);

        // Create many Students
        $students = Student::factory()->count(100)->create();

        // Create many Mentors
        $mentors = Mentor::factory()->count(15)->create();

        // Track used table numbers for each time slot to prevent duplicates
        $usedTables = [];

        // Assign timetables for each mentor
        foreach ($mentors as $mentor) {
            foreach (range(1, 10) as $week) {
                // Assign an available table number
                $tableNumber = $this->getAvailableTableNumber($usedTables, 'Monday', '9:00-9:30', $week);

                // First half-hour slot
                Timetable::factory()->create([
                    'mentor_id' => $mentor->id,
                    'day' => 'Monday', // Fixed for testing
                    'time_slot' => '9:00-9:30',
                    'table_number' => $tableNumber,
                    'week_number' => (string) $week, // Cast week to string for enum compatibility
                ]);

                // Second half-hour slot
                Timetable::factory()->create([
                    'mentor_id' => $mentor->id,
                    'day' => 'Monday',
                    'time_slot' => '9:30-10:00',
                    'table_number' => $tableNumber,
                    'week_number' => (string) $week, // Cast week to string for enum compatibility
                ]);
            }
        }

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
