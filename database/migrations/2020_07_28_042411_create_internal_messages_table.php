<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInternalMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('internal_messages', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->bigInteger('sender_id');
            $table->bigInteger('recipient_id');
            $table->string('subject')->default('(No subject)');
            $table->longText('body')->default('(No content found)');
            $table->boolean('read');
            $table->timestamp('read_at');
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
        Schema::dropIfExists('internal_messages');
    }
}
