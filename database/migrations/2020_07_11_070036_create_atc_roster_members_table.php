<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAtcRosterMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atc_roster_members', function (Blueprint $table) {
            $table->integer('id')->unique();
            $table->integer('vatsim_id');
            $table->string('fname');
            $table->string('lname');
            $table->string('rating');
            $table->string('rating_short');
            $table->string('rating_long');
            $table->boolean('approved_flag');
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
        Schema::dropIfExists('atc_roster_members');
    }
}
