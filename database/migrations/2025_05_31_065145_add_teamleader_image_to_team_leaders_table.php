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
        Schema::table('team_leaders', function (Blueprint $table) {
            $table->string('teamleader_image')->nullable()->after('user_id'); // Add a nullable string column for the image
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('team_leaders', function (Blueprint $table) {
            $table->dropColumn('teamleader_image'); // Drop the teamleader_image column
        });
    }
};