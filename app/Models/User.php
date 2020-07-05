<?php

namespace App\Models;

use App\Models\Admin\Staff;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'vatsim_id', 'fname', 'lname', 'atc_rating', 'pilot_rating', 
        'region_code', 'region_name', 'division_code', 'division_name', 'subdivision_name',
        'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // Relationships

    public function staff()
    {
        return $this->hasOne(Staff::class, 'vatsim_id', 'vatsim_id');
    }
}
