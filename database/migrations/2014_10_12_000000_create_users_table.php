<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->integer('vatsim_id');
            $table->string('fname')->nullable();
            $table->string('lname')->nullable();
            $table->string('email')->unique();
            $table->string('atc_rating');
            $table->string('atc_rating_short');
            $table->string('atc_rating_long');
            $table->string('pilot_rating');
            $table->string('division_id')->nullable();
            $table->string('division_name')->nullable();
            $table->string('region_id')->nullable();
            $table->string('region_name')->nullable();
            $table->string('subdiv_id')->nullable();
            $table->string('subdiv_name')->nullable();
            $table->boolean('is_staff')->default(false);
            $table->integer('staff_level')->default(0);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
