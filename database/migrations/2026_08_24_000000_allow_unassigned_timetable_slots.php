<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Student appointment slots do not have to belong to a mentor shift anymore
     */
    public function up(): void
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->unsignedBigInteger('mentor_id')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('timetables', function (Blueprint $table) {
            $table->unsignedBigInteger('mentor_id')->nullable(false)->change();
        });
    }
};
