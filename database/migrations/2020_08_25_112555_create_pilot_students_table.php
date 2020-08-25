<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePilotStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pilot_students', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->integer('vatsim_id');
            $table->bigInteger('mentor_id')->nullable();
            $table->boolean('active')->default(false);
            $table->string('status')->default('Waiting for Mentor');
            $table->integer('progress')->default(0);
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
        Schema::dropIfExists('pilot_students');
    }
}
