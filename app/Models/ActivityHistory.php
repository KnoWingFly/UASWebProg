<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class ActivityHistory extends Model
{
    protected $fillable = [
        'user_id', 
        'activity_type', 
        'activity_date', 
        'description'
    ];

    /**
     * Get the user associated with the activity history
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'activity_user', 'activity_history_id', 'user_id');
    }
}