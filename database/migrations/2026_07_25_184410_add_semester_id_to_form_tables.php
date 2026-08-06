<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'student_forms' => ['students', 'student_id'],
        'mentor_forms' => ['mentors', 'mentor_id'],
        'team_leader_forms' => ['team_leaders', 'team_leader_id'],
    ];

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $table => [$ownerTable, $ownerKey]) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->foreignId('semester_id')->nullable()->after('id')->constrained('semesters');
            });

            // Backfill from the owning student/mentor/team leader's semester
            // so nothing gets hidden by the new scope after migrating.
            DB::statement("
                UPDATE {$table}
                SET semester_id = (SELECT {$ownerTable}.semester_id FROM {$ownerTable} WHERE {$ownerTable}.id = {$table}.{$ownerKey})
                WHERE semester_id IS NULL
            ");
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach (array_keys($this->tables) as $table) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->dropConstrainedForeignId('semester_id');
            });
        }
    }
};
