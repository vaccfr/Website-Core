<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTrainingSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->bigInteger('student_id');
            $table->bigInteger('mentor_id');
            $table->string('position');
            $table->string('date');
            $table->string('time');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('requested_by');
            $table->boolean('accepted_by_student');
            $table->boolean('accepted_by_mentor');
            $table->boolean('completed')->default(false);
            $table->string('status')->default('requested');
            $table->bigInteger('booking_id')->nullable();
            $table->longText('student_comment')->nullable();
            $table->longText('mentor_comment')->nullable();
            $table->longText('mentor_report')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('training_sessions');
    }
}
