<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTeamLeaderFormsTable extends Migration
{
    public function up()
    {
        Schema::create('team_leader_forms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('team_leader_id')->constrained('team_leaders')->onDelete('cascade');
            $table->foreignId('form_id')->constrained('forms')->onDelete('cascade');
            $table->boolean('completion_status')->default(false);
            $table->timestamp('submitted_datetime')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('teamleader_forms');
    }
}

