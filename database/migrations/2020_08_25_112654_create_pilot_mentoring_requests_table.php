<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilotMentoringRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilot_mentoring_requests', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->bigInteger('student_id');
            $table->longText('motivation');
            $table->boolean('mail_consent');
            $table->boolean('taken')->default(false);
            $table->bigInteger('mentor_id')->nullable();
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
        Schema::dropIfExists('pilot_mentoring_requests');
    }
}
