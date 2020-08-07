<?php

namespace App\Models\Admin;

use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;

class Staff extends Model
{
    use LogsActivity;
    
    protected $table = "staff";

    protected $fillable = [
        'id', 'vatsim_id', 'staff_level', 'title', 'admin', 'atc_dpt', 'pilot_dpt', 'executive', 'events',
    ];

    protected static $logName = "staff";
    protected static $logAttributes = [
        'id', 'vatsim_id', 'staff_level', 'title', 'admin', 'atc_dpt', 'pilot_dpt', 'executive', 'events',
    ];
    protected static $ignoreChangedAttributes = [
        'id', 'vatsim_id', 'updated_at'
    ];
    protected static $logOnlyDirty = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return "Staff Member {$eventName}";
    }

    // Relationships

    public function user()
    {
        return $this->belongsTo(User::class, 'vatsim_id', 'vatsim_id');
    }
}
