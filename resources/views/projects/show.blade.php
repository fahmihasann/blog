@extends('layouts.app')

@section('title', $project->title . ' - Portfolio')

@section('content')
<div class="mx-auto mt-10 max-w-3xl">

    <a href="{{ route('post.projects.index') }}" class="text-blue-600 hover:underline">
        Kembali ke Kelola Project
    </a>

    <div class="mt-6 rounded-xl border border-gray-200 bg-white p-8 shadow-sm">

        @if ($project->thumbnail)
            <img src="{{ asset('storage/' . $project->thumbnail) }}"
                 alt="{{ $project->title }}"
                 class="mb-6 h-64 w-full rounded-lg object-cover">
        @endif

        <h1 class="mb-2 text-3xl font-bold text-gray-900">{{ $project->title }}</h1>

        <p class="mb-4 text-sm text-gray-500">
            {{ $project->category?->name ?? 'Tanpa kategori' }} &middot; {{ ucfirst($project->status) }}
        </p>

        <p class="whitespace-pre-line text-gray-600">{{ $project->description }}</p>

        @if ($project->images->isNotEmpty())
            <div class="mt-8 grid grid-cols-2 gap-4 md:grid-cols-3">
                @foreach ($project->images as $image)
                    <img src="{{ asset('storage/' . $image->image) }}"
                         alt="{{ $image->caption ?: $project->title }}"
                         class="h-32 w-full rounded-lg object-cover">
                @endforeach
            </div>
        @endif

        <a href="{{ route('post.projects.edit', $project) }}"
           class="mt-8 inline-block rounded-lg bg-black px-4 py-2.5 text-sm text-white transition hover:bg-gray-800">
            Edit Project
        </a>
    </div>

</div>
@endsection
