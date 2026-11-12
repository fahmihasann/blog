<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Halaman kelola lama diarahkan ke halaman project gabungan.
     */
    public function index()
    {
        return redirect()->route('projects');
    }

    /**
     * Form tambah project.
     */
    public function create()
    {
        return view('projects.create', [
            'categories' => Category::all(),
        ]);
    }

    /**
     * Simpan project baru beserta thumbnail.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|min:10',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
        ]);

        $data = [
            'title' => $validated['name'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        Project::create($data);

        return redirect()->route('post.projects.create')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    /**
     * Detail project (admin).
     */
    public function show(Project $project)
    {
        $project->load(['category', 'images']);

        return view('projects.show', compact('project'));
    }

    /**
     * Form edit project.
     */
    public function edit(Project $project)
    {
        $project->load('images');

        return view('projects.edit', [
            'project' => $project,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Update project. File thumbnail lama dihapus saat diganti.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string|min:10',
            'status' => 'required|in:draft,published',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
        ]);

        $data = [
            'title' => $validated['name'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ];

        if ($request->hasFile('thumbnail')) {
            // Hapus file lama dulu bila ada.
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project->update($data);

        return redirect()->route('post.projects.edit', $project)
            ->with('success', 'Project berhasil diperbarui.');
    }

    /**
     * Hapus project beserta thumbnail dan seluruh file gallery.
     */
    public function destroy(Project $project)
    {
        if ($project->thumbnail) {
            Storage::disk('public')->delete($project->thumbnail);
        }

        foreach ($project->images as $image) {
            Storage::disk('public')->delete($image->image);
        }

        // Baris project_images ikut terhapus otomatis lewat cascadeOnDelete.
        $project->delete();

        return redirect()->route('projects')
            ->with('success', 'Project dihapus.');
    }
}
