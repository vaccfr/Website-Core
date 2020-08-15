<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDiscordDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discord_data', function (Blueprint $table) {
            $table->bigInteger('user_id')->unique();
            $table->bigInteger('discord_id');
            $table->string('username');
            $table->boolean('banned')->default(false);
            $table->longText('sso_code');
            $table->longText('sso_access_token');
            $table->longText('sso_refresh_token');
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
        Schema::dropIfExists('discord_data');
    }
}
