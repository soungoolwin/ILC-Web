<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentFormsTable extends Migration
{
    public function up()
    {
        Schema::create('student_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained('students')->onDelete('cascade');
            $table->foreignId('form_id')->constrained('forms')->onDelete('cascade');
            $table->boolean('completion_status')->default(false);
            $table->timestamp('submitted_datetime')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_forms');
    }
}

