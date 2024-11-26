<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use App\Models\LearningMaterial;

class MaterialCategoryController extends Controller
{
    public function index()
    {
        // Fetch categories for user view
        $categories = MaterialCategory::with('children')
            ->withCount('learningMaterials')
            ->latest()
            ->paginate(10);
    
        // Count uncategorized materials (where material_category_id is 0)
        $uncategorizedCount = LearningMaterial::where('material_category_id', 0)->count();
    
        return view('user.categories.index', compact('categories', 'uncategorizedCount'));
    }
    

public function show($id)
    {
        if ($id === 'uncategorized') {
            // Fetch uncategorized materials with material_category_id = 0
            $materials = LearningMaterial::where('material_category_id', 0)->paginate(10);

            // Get all categories for the dropdown
            $allCategories = MaterialCategory::all();

            // Create a pseudo-category object for Blade compatibility
            $category = (object) [
                'id' => 'uncategorized',
                'name' => 'Uncategorized',
                'description' => 'Learning materials that haven\'t been assigned to any category',
                'created_at' => '0000-00-00',
            ];

            return view('user.categories.show', compact('category', 'materials', 'allCategories'));
        }

        // Logic for other categories
        $category = MaterialCategory::with('learningMaterials')->findOrFail($id);
        $materials = $category->learningMaterials()->paginate(10);

        // Get all categories for the dropdown
        $allCategories = MaterialCategory::all();

        return view('user.categories.show', compact('category', 'materials', 'allCategories'));
    }
}
