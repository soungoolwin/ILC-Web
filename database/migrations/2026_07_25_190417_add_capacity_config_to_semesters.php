<?php

use App\Models\Semester;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->unsignedSmallInteger('year')->nullable()->after('name');
            $table->unsignedTinyInteger('term')->nullable()->after('year');
            $table->json('team_leader_slot_limits')->nullable()->after('is_current');
            $table->unsignedInteger('table_capacity_default')->nullable()->after('team_leader_slot_limits');
            $table->json('table_capacity_grid')->nullable()->after('table_capacity_default');
        });

        // Backfill every existing semester with the values that used to be
        // hardcoded, so behavior is unchanged until an admin edits them.
        // Year/term are best-effort (term defaults to 1) since older rows
        // predate the year+term dropdown and only ever had a free-text name.
        foreach (Semester::all() as $semester) {
            $semester->update([
                'year' => $semester->year ?? $semester->start_date?->year ?? now()->year,
                'term' => $semester->term ?? 1,
                'team_leader_slot_limits' => Semester::DEFAULT_TEAM_LEADER_SLOT_LIMITS,
                'table_capacity_default' => Semester::DEFAULT_TABLE_CAPACITY_DEFAULT,
                'table_capacity_grid' => Semester::DEFAULT_TABLE_CAPACITY_GRID,
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('semesters', function (Blueprint $table) {
            $table->dropColumn(['year', 'term', 'team_leader_slot_limits', 'table_capacity_default', 'table_capacity_grid']);
        });
    }
};
