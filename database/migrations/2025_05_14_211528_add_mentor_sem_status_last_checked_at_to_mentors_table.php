<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMentorSemStatusLastCheckedAtToMentorsTable extends Migration
{
    public function up()
    {
        Schema::table('mentors', function (Blueprint $table) {
            $table->integer('mentor_sem')->default(1); // Default value is 1
            $table->string('status')->default('active'); // Default status is 'active'
            $table->timestamp('last_checked_at')->nullable(); // Nullable timestamp for last check
        });
    }

    public function down()
    {
        Schema::table('mentors', function (Blueprint $table) {
            $table->dropColumn(['mentor_sem', 'status', 'last_checked_at']);
        });
    }
}