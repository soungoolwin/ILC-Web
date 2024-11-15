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
        Schema::create('timetables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('mentors')->onDelete('cascade');
            $table->enum('day', ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday']);
            $table->string('time_slot');
            $table->integer('table_number');
            $table->boolean('reserved')->default(false);
            $table->enum('week_number', ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']);
            $table->timestamps();
            $table->unique(['mentor_id', 'day', 'time_slot', 'week_number', 'table_number'], 'mentor_schedule_unique');
            $table->unique(['day', 'time_slot', 'week_number', 'table_number'], 'mentor_table_schedule_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('timetables');
    }
};
