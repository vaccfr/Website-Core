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
            $table->string('subject')->nullable();
            $table->longText('body')->nullable();
            $table->boolean('read')->default(false);
            $table->timestamp('read_at')->nullable();
            $table->boolean('recipient_archived')->default(false);
            $table->boolean('sender_archived')->default(false);
            $table->boolean('recipient_trashed')->default(false);
            $table->boolean('sender_trashed')->default(false);
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
