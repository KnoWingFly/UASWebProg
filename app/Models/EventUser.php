<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventUser extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'event_user';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'event_id',
        'user_id',
    ];

    /**
     * Define the relationship with the Event model.
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    /**
     * Define the relationship with the User model.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
