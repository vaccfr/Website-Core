<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->string('title');
            $table->longText('description');
            $table->string('date');
            $table->string('start_time');
            $table->string('end_time');
            $table->boolean('has_image')->default(false);
            $table->bigInteger('image_id')->nullable();
            $table->string('image_url')->nullable();
            $table->bigInteger('publisher_id');
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
        Schema::dropIfExists('events');
    }
}
