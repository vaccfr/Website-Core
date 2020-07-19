<?php

namespace App\Models\ATC;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class MentoringRequest extends Model
{
    protected $table = "mentoring_requests";

    protected $fillable = [
        'id', 'student_id', 'icao', 'motivation', 'taken', 'mentor_id',
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'student_id', 'id');
    }

    public function mentor()
    {
        return $this->hasOne(Mentor::class, 'mentor_id', 'id');
    }
}
