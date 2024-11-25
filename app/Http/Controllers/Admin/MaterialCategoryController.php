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

    public function update(Request $request, MaterialCategory $category)
    {
        // Validate the input for category update
        $validated = $request->validate([
            'name' => 'required|max:255|unique:material_categories,name,' . $category->id,
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:material_categories,id'
        ]);

        // Check if the parent category is valid
        if (!empty($validated['parent_id'])) {
            $parent = MaterialCategory::find($validated['parent_id']);

            // Ensure the category is not its own parent
            if ($parent && $parent->id === $category->id) {
                return back()->with('error', 'A category cannot be its own parent.');
            }

            // Check if the parent category has a parent (nested categories are not allowed beyond one level)
            if ($parent && $parent->parent_id) {
                return back()->with('error', 'Cannot create nested categories beyond one level.');
            }
        }

        // Update the category
        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }



    public function destroy(MaterialCategory $category)
    {
        // Check if category has subcategories
        if ($category->children()->exists()) {
            // Remove parent association for subcategories
            $category->children()->update(['parent_id' => null]);
        }

        // Handle learning materials when deleting category
        if ($category->learningMaterials()->exists()) {
            // Set materials to uncategorized (category_id = 0)
            $category->learningMaterials()->update(['material_category_id' => 0]);
        }

        // Delete the category (both parent and any orphaned subcategories will be deleted)
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category and its subcategories have been deleted successfully. Associated materials have been moved to uncategorized.');
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