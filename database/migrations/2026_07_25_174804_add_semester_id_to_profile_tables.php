<?php

use App\Models\Semester;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private array $tables = [
        'students' => 'student_id',
        'mentors' => 'mentor_id',
        'team_leaders' => 'team_leader_id',
    ];

    /**
     * Drop the existing single-column unique index on $column, if one
     * exists. Looked up by columns rather than a guessed name since the
     * exact index name can differ across drivers.
     */
    private function dropSingleColumnUnique(string $table, string $column): void
    {
        foreach (Schema::getIndexes($table) as $index) {
            if ($index['unique'] && ! $index['primary'] && $index['columns'] === [$column]) {
                Schema::table($table, fn (Blueprint $blueprint) => $blueprint->dropUnique($index['name']));
            }
        }
    }

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        foreach ($this->tables as $table => $idColumn) {
            Schema::table($table, function (Blueprint $blueprint) {
                $blueprint->foreignId('semester_id')->nullable()->after('id')->constrained('semesters');
            });

            $this->dropSingleColumnUnique($table, 'user_id');
            $this->dropSingleColumnUnique($table, $idColumn);
        }

        $semester = Semester::current();

        if (! $semester) {
            // year/term/capacity columns don't exist yet at this point in
            // the migration history — they're added and backfilled for
            // this row by the later add_capacity_config_to_semesters
            // migration, which also fixes up `name` if needed.
            $semester = Semester::create([
                'name' => Semester::nameFor(now()->year, 1),
                'start_date' => now()->startOfYear(),
                'end_date' => now()->startOfYear()->addMonths(5),
                'is_current' => true,
            ]);
        }

        foreach (array_keys($this->tables) as $table) {
            \DB::table($table)->whereNull('semester_id')->update(['semester_id' => $semester->id]);
        }

        foreach ($this->tables as $table => $idColumn) {
            Schema::table($table, function (Blueprint $blueprint) use ($idColumn) {
                $blueprint->unique(['user_id', 'semester_id']);
                $blueprint->unique([$idColumn, 'semester_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        foreach ($this->tables as $table => $idColumn) {
            Schema::table($table, function (Blueprint $blueprint) use ($idColumn) {
                $blueprint->dropUnique([$table.'_user_id_semester_id_unique']);
                $blueprint->dropUnique([$table.'_'.$idColumn.'_semester_id_unique']);
                $blueprint->dropConstrainedForeignId('semester_id');
                $blueprint->unique('user_id');
                $blueprint->unique($idColumn);
            });
        }
    }
};
