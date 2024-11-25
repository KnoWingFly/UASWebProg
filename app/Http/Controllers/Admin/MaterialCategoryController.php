<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use App\Models\LearningMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MaterialCategoryController extends Controller
{
    public function index()
    {
        $categories = MaterialCategory::withCount('learningMaterials')
            ->with(['parent', 'children']) // Load both parent and children
            ->latest()
            ->paginate(10);

        // Get count of uncategorized materials (where material_category_id is 0)
        $uncategorizedCount = LearningMaterial::where('material_category_id', 0)->count();

        $uncategorized = LearningMaterial::where('material_category_id', 0);
        $allCategories = MaterialCategory::all();

        return view('admin.categories.index', compact('categories', 'allCategories', 'uncategorizedCount'));
    }

    public function create()
    {
        $categories = MaterialCategory::all();
        return view('admin.categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:material_categories',
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:material_categories,id'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        // Prevent category from being its own parent
        if (!empty($validated['parent_id'])) {
            $parent = MaterialCategory::find($validated['parent_id']);
            if ($parent && $parent->parent_id) {
                return back()->with('error', 'Cannot create nested categories beyond one level.');
            }
        }

        MaterialCategory::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(MaterialCategory $category)
    {
        // Get all categories except the current one and its children
        $categories = MaterialCategory::where('id', '!=', $category->id)
            ->whereNotIn('parent_id', [$category->id])
            ->get();

        return view('admin.categories.edit', compact('category', 'categories'));
    }

    public function update(Request $request, LearningMaterial $material)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'material_category_id' => 'nullable|exists:material_categories,id',
            'type' => 'required|in:video,pdf',
            'content_url' => 'required|url'
        ]);
    
        $material->update($validated);
    
        return redirect()->back()->with('success', 'Learning material updated successfully.');
    }

    public function destroy(MaterialCategory $category)
    {
        // Check if category has children
        if ($category->children()->exists()) {
            return back()->with('error', 'Cannot delete category with subcategories. Please delete or reassign subcategories first.');
        }

        // Handle learning materials when deleting category
        if ($category->learningMaterials()->exists()) {
            // Set materials to uncategorized (null category_id)
            $category->learningMaterials()->update(['material_category_id' => null]);
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully. Associated materials have been moved to uncategorized.');
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
    
            return view('admin.categories.show', compact('category', 'materials', 'allCategories'));
        }
    
        // Logic for other categories
        $category = MaterialCategory::with('learningMaterials')->findOrFail($id);
        $materials = $category->learningMaterials()->paginate(10);
        
        // Get all categories for the dropdown
        $allCategories = MaterialCategory::all();
    
        return view('admin.categories.show', compact('category', 'materials', 'allCategories'));
    }

}