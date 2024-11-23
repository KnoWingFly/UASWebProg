<?php

// app/Models/Event.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class event extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'banner',
        'description',
        'participant_limit',
        'registration_start',
        'registration_end',
        'registration_status',
    ];

    protected $dates = [
        'registration_start',
        'registration_end',
    ];

    public function participants()
    {
        return $this->belongsToMany(User::class, 'event_user')->withTimestamps();
    }
}
