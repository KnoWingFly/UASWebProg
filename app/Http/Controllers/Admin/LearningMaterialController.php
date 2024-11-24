<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LearningMaterial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LearningMaterialController extends Controller
{
    public function index()
    {
        $recentMaterials = LearningMaterial::orderBy('created_at', 'desc')->take(10)->get();
        $materials = LearningMaterial::latest()->paginate(10);
        return view('admin.materials.dashboard', compact('recentMaterials', 'materials'));
    }

    public function create()
    {
        return view('admin.materials.create');
    }

    public function store(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'type' => 'required|in:pdf,video,article',
            'file' => 'required_if:type,pdf|mimes:pdf|max:10240',  // Validate PDF files only
            'video_url' => 'required_if:type,video|url',
            'content' => 'required_if:type,article',
            'is_published' => 'boolean'
        ]);

        // Check if a file is uploaded
        if ($request->hasFile('file')) {
            // Store the file and get the path
            $path = $request->file('file')->store('materials', 'public');
            // Add the file path to the validated data
            $validated['file_path'] = $path;
        }

        // Create a new learning material record in the database
        LearningMaterial::create($validated);

        // Redirect with success message
        return redirect()->route('admin.materials.index')
            ->with('success', 'Learning material created successfully.');
    }

    public function edit(LearningMaterial $material)
    {
        return view('admin.materials.edit', compact('material'));
    }

    public function update(Request $request, LearningMaterial $material)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'title' => 'required|max:255',
            'description' => 'nullable',
            'type' => 'required|in:pdf,video,article',
            'file' => 'nullable|mimes:pdf|max:10240',  // Validate PDF files only
            'video_url' => 'required_if:type,video|url',
            'content' => 'required_if:type,article',
            'is_published' => 'boolean'
        ]);

        // Check if a new file is uploaded
        if ($request->hasFile('file')) {
            // If there's an old file, delete it from storage
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }
            // Store the new file and get the path
            $path = $request->file('file')->store('materials', 'public');
            // Add the new file path to the validated data
            $validated['file_path'] = $path;
        }

        // Update the existing material with the new data
        $material->update($validated);

        // Redirect with success message
        return redirect()->route('admin.materials.index')
            ->with('success', 'Learning material updated successfully.');
    }

    public function destroy(LearningMaterial $material)
    {
        // Delete the file from storage if it exists
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        // Delete the material from the database
        $material->delete();

        // Redirect with success message
        return redirect()->route('admin.materials.index')
            ->with('success', 'Learning material deleted successfully.');
    }

    public function uploadPdf(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:pdf|max:10240',
            'title' => 'required|max:255',
            'description' => 'nullable',
        ]);

        $path = $request->file('file')->store('materials', 'public');

        LearningMaterial::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => 'pdf',  
            'file_path' => $path,
            'is_published' => $request->is_published ?? false,
        ]);

        // Return a success message
        return response()->json([
            'success' => true,
            'file_path' => $path,
            'message' => 'PDF uploaded and saved successfully.',
        ]);
    }

    public function uploadVideo(Request $request)
    {
        $request->validate([
            'video_url' => 'required|url', 
        ]);

        LearningMaterial::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => 'video',
            'video_url' => $request->video_url,
            'is_published' => $request->is_published ?? false,
        ]);

        return redirect()->route('admin.materials.index')
            ->with('success', 'Video uploaded successfully.');
    }
}