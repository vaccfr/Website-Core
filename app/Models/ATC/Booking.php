<?php

namespace App\Models\ATC;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'id', 'user_id', 'vatsim_id', 'position', 'start_date', 'end_date', 'training', 'unique_id', 'vatbook_id'
    ];

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'vatsim_id', 'vatsim_id');
    }
}
