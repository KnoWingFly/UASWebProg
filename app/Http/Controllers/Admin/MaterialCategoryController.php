<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MaterialCategoryController extends Controller
{
    public function index()
    {
        $categories = MaterialCategory::withCount('learningMaterials')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:material_categories',
            'description' => 'nullable'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        MaterialCategory::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(MaterialCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, MaterialCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255|unique:material_categories,name,' . $category->id,
            'description' => 'nullable'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(MaterialCategory $category)
    {
        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}