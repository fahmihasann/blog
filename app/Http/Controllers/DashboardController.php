<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Skill;
use App\Models\Technology;

class DashboardController extends Controller
{
    public function index()
    {
        return view('post.dashboard', [
            'totalProjects'     => Project::count(),
            'totalCategories'   => Category::count(),
            'totalSkills'       => Skill::count(),
            'totalTechnologies' => Technology::count(),

            // Indikator: Published + Draft harus sama dengan total project.
            'totalPublished'    => Project::where('status', 'published')->count(),
            'totalDraft'        => Project::where('status', 'draft')->count(),

            // "Skill Teratas" = 5 skill dengan level tertinggi
            // (urutan: advanced > intermediate > beginner).
            'topSkills'         => Skill::orderByRaw("FIELD(level, 'advanced', 'intermediate', 'beginner')")
                ->take(5)
                ->get(),

            'projectsByCategory' => Category::withCount('projects')->get(),

            'latestProjects'    => Project::with('category')->latest()->take(5)->get(),
        ]);
    }
}
