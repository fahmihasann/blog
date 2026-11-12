@extends('layouts.app')

@section('title', 'Dashboard Admin - Portfolio')

@section('content')
<div class="mt-10">

    <h1 class="mb-8 text-3xl font-bold text-gray-900">Dashboard Admin</h1>

    {{-- Ringkasan data --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-4">
        <x-stat-card label="Projects" :value="$totalProjects" />
        <x-stat-card label="Categories" :value="$totalCategories" />
        <x-stat-card label="Technologies" :value="$totalTechnologies" />
        <x-stat-card label="Skills" :value="$totalSkills" />
        <x-stat-card label="Published" :value="$totalPublished" />
        <x-stat-card label="Draft" :value="$totalDraft" />
    </div>

    {{-- Project terbaru --}}
    <div class="mt-8 overflow-hidden rounded-lg bg-white shadow-md">
        <div class="border-b border-gray-100 px-6 py-4">
            <h2 class="text-lg font-semibold text-gray-900">Project Terbaru</h2>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Tanggal Dibuat</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($latestProjects as $project)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                <a href="{{ route('post.projects.edit', $project) }}" class="hover:underline">
                                    {{ $project->title }}
                                </a>
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $project->category?->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $project->created_at?->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-center text-gray-500">
                                Belum ada project.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">

        {{-- Skill teratas --}}
        <div class="rounded-lg bg-white p-6 shadow-md">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Skill Teratas</h2>

            @forelse ($topSkills as $skill)
                <div class="flex items-center justify-between border-b border-gray-100 py-2 last:border-0">
                    <span class="text-gray-700">{{ $skill->name }}</span>
                    <span class="text-xs font-semibold uppercase text-gray-500">{{ $skill->level }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada skill.</p>
            @endforelse
        </div>

        {{-- Jumlah project per kategori --}}
        <div class="rounded-lg bg-white p-6 shadow-md">
            <h2 class="mb-4 text-lg font-semibold text-gray-900">Project per Kategori</h2>

            @forelse ($projectsByCategory as $category)
                <div class="flex items-center justify-between border-b border-gray-100 py-2 last:border-0">
                    <span class="text-gray-700">{{ $category->name }}</span>
                    <span class="text-sm font-semibold text-gray-900">{{ $category->projects_count }}</span>
                </div>
            @empty
                <p class="text-sm text-gray-500">Belum ada kategori.</p>
            @endforelse
        </div>

    </div>

</div>
@endsection
