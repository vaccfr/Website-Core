<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserAtcSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_atc_sessions', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('start');
            $table->string('end');
            $table->string('server');
            $table->string('vatsim_id');
            $table->integer('type');
            $table->integer('rating');
            $table->string('callsign');
            $table->integer('times_held_callsign');
            $table->string('minutes_on_callsign');
            $table->integer('total_minutes_on_callsign');
            $table->integer('aircrafttracked');
            $table->integer('aircraftseen');
            $table->integer('flightsamended');
            $table->integer('handoffsinitiated');
            $table->integer('handoffsreceived');
            $table->integer('handoffsrefused');
            $table->integer('squawksassigned');
            $table->integer('cruisealtsmodified');
            $table->integer('tempaltsmodified');
            $table->integer('scratchpadmods');
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
        Schema::dropIfExists('user_atc_sessions');
    }
}
