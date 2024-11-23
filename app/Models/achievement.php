<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class achievement extends Model
{
    use HasFactory;

    protected $table = 'achievements';

    protected $fillable = [
        'user_id',       
        'title',         
        'description',   
        'icon',          
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }    
}
