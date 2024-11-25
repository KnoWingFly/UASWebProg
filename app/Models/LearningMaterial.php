<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LearningMaterial extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'type',
        'file_path',
        'video_url',
        'material_category_id'
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    public function getFileUrlAttribute()
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function category()
    {
        return $this->belongsTo(MaterialCategory::class, 'material_category_id');
    }
}