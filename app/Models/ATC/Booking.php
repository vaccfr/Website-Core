<?php

namespace App\Models\ATC;

use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    protected $table = 'bookings';

    protected $fillable = [
        'id', 'user_id', 'vatsim_id', 'position', 'date', 'time', 'training', 'unique_id', 'start_time', 'end_time', 'vatbook_id'
    ];
}
