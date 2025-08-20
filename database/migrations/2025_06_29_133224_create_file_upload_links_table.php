<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileUploadLinksTable extends Migration
{
    public function up()
    {
        Schema::create('file_upload_links', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the upload link
            $table->text('url'); // URL of the resource
            $table->enum('for_role', ['student', 'mentor', 'team_leader']); // Who it's for
            $table->timestamps(); // created_at and updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('file_upload_links');
    }
}

