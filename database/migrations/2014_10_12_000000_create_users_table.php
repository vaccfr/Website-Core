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
            $table->string('lname')->nullable();
            $table->string('fname')->nullable();
            $table->string('atc_rating');
            $table->string('pilot_rating');
            $table->string('region_code')->nullable();
            $table->string('region_name')->nullable();
            $table->string('division_code')->nullable();
            $table->string('division_name')->nullable();
            $table->string('subdivision_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
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
