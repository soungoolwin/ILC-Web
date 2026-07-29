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
        Schema::table('team_leader_timetables', function (Blueprint $table) {
            $table->foreignId('semester_id')->nullable()->after('id')->constrained('semesters');
        });

        // Backfill from the owning team leader's semester so nothing gets
        // hidden by the new scope after migrating.
        DB::statement('
            UPDATE team_leader_timetables
            SET semester_id = (SELECT team_leaders.semester_id FROM team_leaders WHERE team_leaders.id = team_leader_timetables.team_leader_id)
            WHERE semester_id IS NULL
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_leader_timetables', function (Blueprint $table) {
            $table->dropConstrainedForeignId('semester_id');
        });
    }
};
