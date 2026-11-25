<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->validate([
            'search' => 'nullable|string|max:100',
            'category' => 'nullable|string|max:255',
        ]);

        $projects = Project::with(['category', 'technologies'])
            ->where('status', 'published')
            ->when($filters['search'] ?? null, fn ($q, $s) => $q->where(
                fn ($w) => $w->where('title', 'like', "%{$s}%")
                    ->orWhere('short_description', 'like', "%{$s}%")
            ))
            ->when($filters['category'] ?? null, fn ($q, $c) => $q->whereHas(
                'category',
                fn ($w) => $w->where('slug', $c)
            ))
            ->latest()
            ->paginate(9)
            ->withQueryString();

        return ProjectResource::collection($projects);
    }

    public function show(Project $project)
    {
        return new ProjectResource(
            $project->load(['category', 'technologies'])
        );
    }
}
