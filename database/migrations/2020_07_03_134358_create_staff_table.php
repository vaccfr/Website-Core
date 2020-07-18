<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaffTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('staff', function (Blueprint $table) {
            $table->id();
            $table->integer('vatsim_id');
            $table->integer('staff_level');
            $table->boolean('admin')->default(false);
            $table->boolean('atc_dpt')->default(false);
            $table->boolean('pilot_dpt')->default(false);
            $table->boolean('executive')->default(false);
            $table->boolean('events')->default(false);
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
        Schema::dropIfExists('staff');
    }
}
