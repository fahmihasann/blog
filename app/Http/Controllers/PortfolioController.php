<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Technology;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Halaman publik daftar project: search, filter kategori & technology,
     * sorting berbasis project_date, pagination.
     */
    public function projects(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:255',
            'technology' => 'nullable|string|max:255',
            'sort' => 'nullable|in:terbaru,terlama,az',
        ]);

        $query = Project::with('category', 'technologies')
            ->where('status', 'published')
            ->when($filters['search'] ?? null, fn ($q, $s) => $q->where(
                fn ($w) => $w->where('title', 'like', "%{$s}%")
                    ->orWhere('short_description', 'like', "%{$s}%")
                    ->orWhere('description', 'like', "%{$s}%")
            ))
            ->when($filters['category'] ?? null, fn ($q, $c) => $q->whereHas(
                'category',
                fn ($w) => $w->where('slug', $c)
            ))
            ->when($filters['technology'] ?? null, fn ($q, $t) => $q->whereHas(
                'technologies',
                fn ($w) => $w->where('slug', $t)
            ));

        // Urutan utama memakai project_date; project tanpa tanggal diletakkan di akhir.
        $query->orderByRaw('project_date IS NULL');

        switch ($filters['sort'] ?? 'terbaru') {
            case 'terlama':
                $query->orderBy('project_date')->orderBy('id');
                break;
            case 'az':
                $query->orderBy('title');
                break;
            default:
                $query->orderByDesc('project_date')->orderByDesc('id');
        }

        $projects = $query->paginate(9)->withQueryString();
        $categories = Category::orderBy('name')->get();
        $technologies = Technology::orderBy('name')->get();

        return view('projects', compact('projects', 'categories', 'technologies'));
    }

    /**
     * Halaman publik detail project (route model binding lewat slug).
     */
    public function show(Project $project)
    {
        // Draft tidak boleh diakses lewat URL langsung.
        abort_if($project->status !== 'published', 404);

        $project->load(['category', 'technologies', 'images']);

        return view('portofolio.project', compact('project'));
    }
}