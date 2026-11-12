<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectGalleryController extends Controller
{
    /**
     * Unggah beberapa gambar gallery sekaligus.
     */
    public function store(Request $request, Project $project)
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096|dimensions:min_width=800',
        ]);

        $existing = $project->images()->count();
        $incoming = count($request->file('images', []));

        // Batas 10 gambar dihitung dari total per project, bukan per request.
        if ($existing + $incoming > 10) {
            return back()->withErrors([
                'images' => 'Maksimal 10 gambar per project. Saat ini sudah ada ' . $existing . ' gambar.',
            ])->withInput();
        }

        foreach ($request->file('images') as $file) {
            $project->images()->create([
                'image' => $file->store('projects/gallery', 'public'),
            ]);
        }

        return back()->with('success', 'Gambar gallery berhasil diunggah.');
    }

    /**
     * Perbarui caption gambar gallery.
     */
    public function update(Request $request, Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);

        $validated = $request->validate([
            'caption' => 'nullable|string|max:255',
        ]);

        $image->update($validated);

        return back()->with('success', 'Caption gambar diperbarui.');
    }

    /**
     * Hapus satu gambar gallery beserta file fisiknya.
     */
    public function destroy(Project $project, ProjectImage $image)
    {
        abort_if($image->project_id !== $project->id, 404);

        Storage::disk('public')->delete($image->image);
        $image->delete();

        return back()->with('success', 'Gambar dihapus.');
    }
}
