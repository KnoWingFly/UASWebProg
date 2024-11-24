<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    protected $fillable = ['name', 'slug', 'description'];

    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class, 'category_id');
    }
}