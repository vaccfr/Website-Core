<?php

namespace App\Models\ATC;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class MentoringRequest extends Model
{
    protected $table = "mentoring_requests";

    protected $fillable = [
        'id', 'student_id', 'icao', 'motivation', 'mail_consent', 'taken', 'mentor_id',
    ];

    // Relationships

    public function user()
    {
        return $this->hasOne(User::class, 'id', 'student_id');
    }

    public function mentor()
    {
        return $this->hasOne(Mentor::class, 'id', 'mentor_id');
    }
}
