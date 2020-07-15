<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBookingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->bigInteger('user_id');
            $table->integer('vatsim_id');
            $table->string('position');
            $table->string('date');
            $table->string('time');
            $table->boolean('training');
            $table->bigInteger('unique_id');
            $table->string('start_time');
            $table->string('end_time');
            $table->integer('vatbook_id');
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
        Schema::dropIfExists('bookings');
    }
}
