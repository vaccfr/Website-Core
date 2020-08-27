<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateATCRosterMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('atc_roster_members', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->integer('vatsim_id');
            $table->string('fname');
            $table->string('lname');
            $table->string('rating');
            $table->string('rating_short');
            $table->boolean('visiting')->default(false);
            $table->boolean('approved_flag');
            $table->boolean('appr_lfpg_twr')->default(false);
            $table->boolean('appr_lfpg_app')->default(false);
            $table->boolean('appr_lfmn_twr')->default(false);
            $table->boolean('appr_lfmn_app')->default(false);
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
