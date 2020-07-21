<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserConnectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_connections', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('vatsim_id');
            $table->integer('type');
            $table->integer('rating');
            $table->string('callsign');
            $table->string('start');
            $table->string('end');
            $table->string('server');
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
        Schema::dropIfExists('user_connections');
    }
}
