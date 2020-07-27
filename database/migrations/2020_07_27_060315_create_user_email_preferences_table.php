<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserEmailPreferencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_email_preferences', function (Blueprint $table) {
            $table->bigInteger('id')->unique();
            $table->boolean('event_emails')->default(true);
            $table->boolean('atc_booking_emails')->default(true);
            $table->boolean('atc_mentoring_emails')->default(true);
            $table->boolean('website_update_emails')->default(true);
            $table->boolean('news_emails')->default(true);
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
        Schema::dropIfExists('user_email_preferences');
    }
}
