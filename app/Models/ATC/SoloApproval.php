<?php

namespace App\Models\ATC;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class SoloApproval extends Model
{
    protected $table = "solo_approvals";

    protected $fillable = [
        'id', 'student_id', 'mentor_id', 'position', 'start_date', 'end_date'
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

    public function station()
    {
        return $this->hasOne(ATCStation::class, 'code', 'position');
    }
}
