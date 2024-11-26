<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id'
    ];

    public function learningMaterials()
    {
        return $this->hasMany(LearningMaterial::class, 'material_category_id');
    }

    public function parent()
    {
        return $this->belongsTo(MaterialCategory::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(MaterialCategory::class, 'parent_id');
    }

    public function isDescendantOf($category)
{
    $parent = $this->parent;
    
    while ($parent) {
        if ($parent->id === $category->id) {
            return true;
        }
        $parent = $parent->parent;
    }
    
    return false;
}
}