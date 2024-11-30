<?php

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
        Schema::create('team_leader_timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_leader_id')->constrained('team_leaders')->onDelete('cascade');
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
            $table->enum('time_slot', ['09:00-11:00', '11:00-13:00', '13:00-15:00', '15:00-17:00', '17:00-20:00']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('team_leader_timetables');
    }
};
