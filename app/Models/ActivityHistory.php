<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityHistory extends Model
{
    use HasFactory;

    protected $table = 'activity_histories';

    protected $fillable = [
        'user_id',
        'activity_type',
        'activity_date',
        'description',  
    ];

    // Define the relationship between ActivityHistory and User
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
