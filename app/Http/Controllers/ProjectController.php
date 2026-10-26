<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
{
    $request->validate([
        'search' => 'nullable|string|max:200',
        'per_page' => 'nullable|integer|in:5,10,25',
    ]);

    $search = $request->input('search', '');
    $perPage = (int) $request->input('per_page', 10);

    $projects = Project::query()
        ->when($search !== '', function ($query) use ($search) {
            $query->where('title', 'like', '%' . $search . '%');
        })
        ->latest()
        ->paginate($perPage)
        ->withQueryString();

    return view('projects.index', compact(
        'projects',
        'search',
        'perPage'
    ));
}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|min: 5|max: 200',
            'description' => 'required|string|min: 10',
        ]);

        Project::create([
            'title' => $request->input('title'),
            'description' => $request->input('description'),
        ]);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::findOrFail($id);
        $data = [
            'project' => $project,
        ];
        return view('projects.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = $request->validate([
            'title' => 'required|string|min: 5|max: 200',
            'description' => 'required|string|min:10',
        ]);

        $project = Project::findOrFail($id);

        $project->update($validatedData);

        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return redirect()->route('projects.index')
            ->with('success', 'Project berhasil dihapus.');
    }
}
