<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStandApiDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stand_api_data', function (Blueprint $table) {
            $table->id();
            $table->string('icao');
            $table->string('stand');
            $table->integer('wtc')->default(2); // L=1, M=2, H=3, J=4
            $table->boolean('schengen')->default(false);
            $table->double('lat', 8, 6);
            $table->double('lon', 8, 6);
            $table->longText('companies')->nullable();
            $table->string('usage')->default('A');
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
        Schema::dropIfExists('stand_api_data');
    }
}
