<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateATCStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atc_stations', function (Blueprint $table) {
            $table->id();
            $table->integer('airport_id');
            $table->string('code');
            $table->string('callsign')->nullable();
            $table->string('frequency');
            $table->string('rank');
            $table->string('solo_rank');
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
        Schema::dropIfExists('atc_stations');
    }
}
