<?php

namespace App\Models\General;

use App\Models\Data\File;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $table = "events";

    protected $fillable = [
        'id', 'title', 'description', 'date_time', 'has_image', 'image_id', 'publisher_id',
    ];

    // Relationships

    public function image()
    {
        return $this->hasOne(File::class, 'image_id', 'id');
    }

    public function publisher()
    {
        return $this->hasOne(User::class, 'publisher_id', 'id');
    }
}
