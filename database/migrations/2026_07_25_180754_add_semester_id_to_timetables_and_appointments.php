<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->foreignId('semester_id')->nullable()->after('id')->constrained('semesters');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->foreignId('semester_id')->nullable()->after('id')->constrained('semesters');
        });

        // Backfill existing rows from their mentor/student's semester so
        // nothing gets hidden by the new scope after migrating.
        DB::statement('
            UPDATE timetables
            SET semester_id = (SELECT mentors.semester_id FROM mentors WHERE mentors.id = timetables.mentor_id)
            WHERE semester_id IS NULL
        ');

        DB::statement('
            UPDATE appointments
            SET semester_id = (SELECT students.semester_id FROM students WHERE students.id = appointments.student_id)
            WHERE semester_id IS NULL
        ');

        // This constraint used to make a (day, time_slot, week_number,
        // table_number) combo unique forever, across every mentor and
        // every semester — meaning once a physical table/slot was used
        // once, no future semester could ever reuse it. Scope it to the
        // semester instead so tables free up each new term.
        Schema::table('timetables', function (Blueprint $table) {
            $table->dropUnique('mentor_table_schedule_unique');
            $table->unique(['semester_id', 'day', 'time_slot', 'week_number', 'table_number'], 'semester_table_schedule_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->dropUnique('semester_table_schedule_unique');
            $table->unique(['day', 'time_slot', 'week_number', 'table_number'], 'mentor_table_schedule_unique');
            $table->dropConstrainedForeignId('semester_id');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropConstrainedForeignId('semester_id');
        });
    }
};
