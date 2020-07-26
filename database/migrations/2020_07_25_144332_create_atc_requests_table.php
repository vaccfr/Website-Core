<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateATCRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atc_requests', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('name');
            $table->integer('vatsim_id');
            $table->string('email');
            $table->longText('event_name');
            $table->string('event_date');
            $table->longText('event_sponsors');
            $table->string('event_website');
            $table->string('dep_airport_and_time');
            $table->string('arr_airport_and_time');
            $table->longText('requested_positions');
            $table->integer('expected_pilots');
            $table->longText('route');
            $table->longText('message');
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
        Schema::dropIfExists('atc_requests');
    }
}
