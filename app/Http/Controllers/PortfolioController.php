<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Halaman gabungan daftar project (publik + aksi admin).
     */
    public function projects(Request $request)
    {
        $request->validate([
            'search' => 'nullable|string|max:200',
            'per_page' => 'nullable|integer|in:5,10,25',
        ]);

        $search = $request->input('search', '');
        $perPage = (int) $request->input('per_page', 10);

        $projects = Project::query()
            ->with('category')
            // Tamu hanya melihat project berstatus published.
            ->when(! auth()->check(), function ($query) {
                $query->where('status', 'published');
            })
            ->when($search !== '', function ($query) use ($search) {
                $query->where('title', 'like', '%' . $search . '%');
            })
            ->latest()
            ->paginate($perPage)
            ->withQueryString();

        return view('projects', compact('projects', 'search', 'perPage'));
    }

    /**
     * Halaman publik detail project beserta gallery.
     */
    public function show(Project $project)
    {
        // Draft tidak boleh diakses tamu, termasuk lewat URL langsung.
        abort_if(! auth()->check() && $project->status !== 'published', 404);

        $project->load(['category', 'images']);

        return view('portofolio.project', compact('project'));
    }
}
