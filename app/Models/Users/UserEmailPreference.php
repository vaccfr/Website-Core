<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;

class UserEmailPreference extends Model
{
    protected $table = "user_email_preferences";

    protected $fillable = [
        'id', 'event_emails', 'atc_booking_emails', 'atc_mentoring_emails',
        'website_update_emails', 'news_emails', 'internal_messaging_emails',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
