<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use App\Models\LearningMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class MaterialCategoryController extends Controller
{
    public function index()
    {
        // Fetch all categories, including nested subcategories
        $categories = MaterialCategory::with([
            'parent',
            'children.children', // Allow for deeper nesting
            'children' => function ($query) {
                $query->withCount('learningMaterials');
            }
        ])
            ->withCount('learningMaterials')
            ->latest()
            ->paginate(10);

        // Get all categories for potential parent selection
        $allCategories = MaterialCategory::all();

        $uncategorizedCount = LearningMaterial::where('material_category_id', 0)->count();

        return view('admin.categories.index', compact('categories', 'allCategories', 'uncategorizedCount'));
    }

    public function create()
    {
        $allCategories = MaterialCategory::whereNull('parent_id')->get();
        $category = new MaterialCategory();
        return view('admin.categories.create', compact('allCategories', 'category'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:material_categories',
            'description' => 'nullable',
            'parent_id' => [
                'nullable',
                'exists:material_categories,id',
                function ($attribute, $value, $fail) {
                    if ($value) {
                        // Check category depth
                        $currentParent = MaterialCategory::find($value);
                        $depth = 0;

                        // Check total number of subcategories for this parent
                        $subcategoriesCount = MaterialCategory::where('parent_id', $value)->count();
                        if ($subcategoriesCount >= 3) {
                            $fail('A parent category can have a maximum of 3 subcategories.');
                        }

                        while ($currentParent) {
                            $depth++;
                            if ($depth > 2) { // Allow up to 3 levels deep
                                $fail('Category depth cannot exceed 3 levels.');
                                break;
                            }
                            $currentParent = $currentParent->parent;
                        }
                    }
                }
            ]
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        MaterialCategory::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(MaterialCategory $category)
    {
        // Get all categories except the current one and its children
        $allCategories = MaterialCategory::where('id', '!=', $category->id)
            ->whereNotIn('parent_id', [$category->id])
            ->get();

        return view('admin.categories.edit', compact('category', 'allCategories'));
    }

    public function update(Request $request, MaterialCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:material_categories,name,' . $category->id,
            'description' => 'nullable',
            'parent_id' => [
                'nullable',
                'exists:material_categories,id',
                function ($attribute, $value, $fail) use ($category) {
                    // Prevent setting the category as its own parent
                    if ($value == $category->id) {
                        $fail('A category cannot be its own parent.');
                    }

                    // Prevent circular and deep nesting references
                    if ($value) {
                        $currentParent = MaterialCategory::find($value);
                        $visited = collect([$category->id]);
                        $depth = 0;

                        while ($currentParent) {
                            // Check for circular reference
                            if ($visited->contains($currentParent->id)) {
                                $fail('Cannot create circular category references.');
                                break;
                            }

                            $visited->push($currentParent->id);
                            $depth++;

                            // Limit category depth to 3 levels
                            if ($depth > 2) {
                                $fail('Category depth cannot exceed 3 levels.');
                                break;
                            }

                            $currentParent = $currentParent->parent;
                        }

                        // If this category already has children, prevent setting a parent
                        if ($category->children->isNotEmpty()) {
                            $fail('A category with subcategories cannot have a parent.');
                        }
                    }
                }
            ]
        ]);

        // Update the category with validated data
        $category->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'parent_id' => $validated['parent_id'] ?? null,
            'slug' => Str::slug($validated['name'])
        ]);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(MaterialCategory $category)
    {
        DB::transaction(function () use ($category) {
            // Move all materials in this category to uncategorized (0)
            LearningMaterial::where('material_category_id', $category->id)
                ->update(['material_category_id' => 0]);

            // Set all subcategories' parent to null
            MaterialCategory::where('parent_id', $category->id)
                ->update(['parent_id' => null]);

            // Delete the category
            $category->delete();
        });

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted. Associated materials have been moved to uncategorized.');
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