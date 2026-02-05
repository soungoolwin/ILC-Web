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
        Schema::create('qr_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('student_id');
            $table->string('day'); 
            $table->string('time'); 
            $table->timestamps();
            
            // Indexing student_id for faster lookups
            $table->index('student_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('qr_attendances');
    }
};
