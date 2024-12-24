<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    use HasFactory;

    protected $table = 'event_user';

    protected $fillable = [
        'event_id',
        'user_id',
    ];

    // Add this relationship
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    // Add this if you need the user relationship
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}