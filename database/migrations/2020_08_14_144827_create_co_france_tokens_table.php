<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoFranceTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('co_france_tokens', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unique();
            $table->longText('token')->nullable();
            $table->string('password');
            $table->string('last_ip')->nullable();
            $table->timestamp('last_used')->nullable();
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
        Schema::dropIfExists('co_france_tokens');
    }
}
