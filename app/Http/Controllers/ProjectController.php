<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    /**
     * Halaman admin daftar project: search dan filter status.
     */
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:100',
            'status' => 'nullable|in:published,draft',
        ]);

        $projects = Project::with(['category', 'technologies'])
            ->when($filters['search'] ?? null, fn ($q, $s) => $q->where(
                fn ($w) => $w->where('title', 'like', "%{$s}%")
                    ->orWhere('short_description', 'like', "%{$s}%")
            ))
            ->when($filters['status'] ?? null, fn ($q, $status) => $q->where('status', $status))
            ->orderByRaw('project_date IS NULL')
            ->orderByDesc('project_date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        return view('projects.index', compact('projects'));
    }

    /**
     * Form tambah project.
     */
    public function create()
    {
        return view('projects.create', [
            'categories' => Category::orderBy('name')->get(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    /**
     * Simpan project baru beserta thumbnail dan technologies.
     */
    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());
        $technologyIds = $validated['technologies'] ?? [];
        unset($validated['technologies']); // bukan kolom tabel projects

        $data = [
            'title' => $validated['name'],
            'slug' => Project::uniqueSlug($validated['name']),
            'category_id' => $validated['category_id'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'project_date' => $validated['project_date'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'project_url' => $validated['project_url'] ?? null,
            'repository_url' => $validated['repository_url'] ?? null,
        ];

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project = Project::create($data);
        $project->technologies()->sync($technologyIds);

        return redirect()->route('post.projects.create')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    /**
     * Detail project (admin).
     */
    public function show(Project $project)
    {
        $project->load(['category', 'technologies', 'images']);

        return view('projects.show', compact('project'));
    }

    /**
     * Form edit project.
     */
    public function edit(Project $project)
    {
        $project->load(['images', 'technologies']);

        return view('projects.edit', [
            'project' => $project,
            'categories' => Category::orderBy('name')->get(),
            'technologies' => Technology::orderBy('name')->get(),
        ]);
    }

    /**
     * Update project. File thumbnail lama dihapus saat diganti.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate($this->rules($project));
        $technologyIds = $validated['technologies'] ?? [];
        unset($validated['technologies']);

        $data = [
            'title' => $validated['name'],
            'category_id' => $validated['category_id'],
            'short_description' => $validated['short_description'] ?? null,
            'description' => $validated['description'] ?? null,
            'status' => $validated['status'],
            'project_date' => $validated['project_date'] ?? null,
            'is_featured' => $request->boolean('is_featured'),
            'project_url' => $validated['project_url'] ?? null,
            'repository_url' => $validated['repository_url'] ?? null,
        ];

        // Slug ikut berubah bila judul diubah.
        if ($project->title !== $validated['name']) {
            $data['slug'] = Project::uniqueSlug($validated['name'], $project->id);
        }

        if ($request->hasFile('thumbnail')) {
            // Hapus file lama dulu bila ada.
            if ($project->thumbnail) {
                Storage::disk('public')->delete($project->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')
                ->store('projects/thumbnails', 'public');
        }

        $project->update($data);
        $project->technologies()->sync($technologyIds);

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

    /**
     * Aturan validasi untuk store dan update.
     */
    private function rules(?Project $project = null): array
    {
        $uniqueTitle = 'unique:projects,title' . ($project ? ',' . $project->id : '');

        return [
            'name' => 'required|max:255|' . $uniqueTitle,
            'category_id' => 'required|exists:categories,id',
            'short_description' => 'nullable|max:255',
            'description' => 'nullable',
            'status' => 'required|in:draft,published',
            'project_date' => 'nullable|date',
            'is_featured' => 'nullable|boolean',
            'project_url' => 'nullable|url|max:255',
            'repository_url' => 'nullable|url|max:255',
            'technologies' => 'nullable|array',
            'technologies.*' => 'exists:technologies,id',
            'thumbnail' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048|dimensions:min_width=400,min_height=300',
        ];
    }
}
