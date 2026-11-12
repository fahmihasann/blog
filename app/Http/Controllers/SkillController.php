<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    /**
     * Daftar skill.
     */
    public function index()
    {
        return view('skills.index', [
            'skills' => Skill::with('category')->orderBy('name')->get(),
        ]);
    }

    /**
     * Form edit skill.
     */
    public function edit(Skill $skill)
    {
        return view('skills.edit', [
            'skill' => $skill,
            'categories' => Category::all(),
        ]);
    }

    /**
     * Simpan perubahan skill.
     */
    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'category_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'level' => 'required|in:beginner,intermediate,advanced',
        ]);

        $skill->update($validated);

        return redirect()->route('post.skills.edit', $skill)
            ->with('success', 'Skill berhasil diperbarui.');
    }
}
