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
        Schema::create('qr_student_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('name');
            $table->string('section');
            $table->string('ajarn_name');
            $table->timestamps();

            // Set student_id as a foreign key referencing the column in qr_attendances
            // Note: This requires student_id in qr_attendances to be indexed or unique
            $table->foreign('student_id')->references('student_id')->on('qr_attendances')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_student_attendances');
    }
};
