<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\MaterialCategory;
use App\Models\LearningMaterial;
use Illuminate\Support\Facades\Storage;

class LearningMaterialController extends Controller
{
    /**
     * Display a list of published learning materials.
     */
    public function index()
    {
        $materials = LearningMaterial::where('is_published', true)
            ->with('category')
            ->latest()
            ->paginate(9);

        return view('user.materials.index', compact('materials'));
    }

    /**
     * Show the details of a specific learning material.
     */
    public function show(LearningMaterial $material)
    {
        return view('user.materials.show', compact('material'));
    }

    /**
     * Download a PDF learning material.
     */
    public function download(LearningMaterial $material)
    {
        try {
            if ($material->type !== 'pdf' || !Storage::disk('public')->exists($material->file_path)) {
                abort(404, 'PDF not found.');
            }

            $path = Storage::disk('public')->path($material->file_path);

            return response()->download($path, $material->title . '.pdf', [
                'Content-Type' => 'application/pdf',
                'Content-Disposition' => 'attachment; filename="' . $material->title . '.pdf"',
            ]);
        } catch (\Exception $e) {
            \Log::error('Error downloading PDF: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Failed to download PDF.']);
        }
    }
}
