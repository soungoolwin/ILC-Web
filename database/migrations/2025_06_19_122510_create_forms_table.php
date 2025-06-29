<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormsTable extends Migration
{
    public function up()
    {
        Schema::create('forms', function (Blueprint $table) {
            $table->id(); // Unique identifier for the form
            $table->string('form_name'); // Name of the form (e.g., "Pretest")
            $table->text('form_description'); // Usually the URL or detail of the form
            $table->enum('form_type', ['pretest', 'posttest', 'questionnaire', 'consent']); // Types of forms
            $table->enum('for_role', ['student', 'mentor', 'team_leader']); // Target roles
            $table->boolean('is_active')->default(true); // Whether the form is active
            $table->boolean('is_mandatory')->default(false); // Whether form submission is required
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('forms');
    }
}

