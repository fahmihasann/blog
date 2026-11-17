@extends('layouts.app')

@section('title', $project->title . ' - Portfolio')

@section('content')
<div class="mx-auto mt-10 max-w-4xl">

    <a href="{{ route('projects') }}" class="text-blue-600 hover:underline">
        Kembali ke Projects
    </a>

    <article class="mt-6 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">

        @if ($project->thumbnail)
            <img src="{{ asset('storage/' . $project->thumbnail) }}"
                 alt="{{ $project->title }}"
                 class="h-72 w-full object-cover">
        @endif

        <div class="p-8">
            <div class="mb-2 flex flex-wrap items-center gap-3 text-xs font-semibold uppercase tracking-wider text-gray-500">
                <span>{{ $project->category?->name ?? 'Tanpa kategori' }}</span>

                @if ($project->project_date)
                    <span>&middot;</span>
                    <span>{{ $project->project_date->format('d M Y') }}</span>
                @endif

                @if ($project->is_featured)
                    <span class="rounded-full bg-amber-100 px-2 py-1 normal-case tracking-normal text-amber-700">
                        Unggulan
                    </span>
                @endif
            </div>

            <h1 class="mb-4 text-3xl font-bold text-gray-900">{{ $project->title }}</h1>

            @if ($project->short_description)
                <p class="mb-4 text-lg text-gray-700">{{ $project->short_description }}</p>
            @endif

            <p class="whitespace-pre-line text-gray-600">{{ $project->description }}</p>

            @if ($project->technologies->isNotEmpty())
                <div class="mt-6 flex flex-wrap gap-2">
                    @foreach ($project->technologies as $technology)
                        <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                            {{ $technology->name }}
                        </span>
                    @endforeach
                </div>
            @endif

            @if ($project->project_url || $project->repository_url)
                <div class="mt-6 flex flex-wrap gap-3">
                    @if ($project->project_url)
                        <a href="{{ $project->project_url }}" target="_blank" rel="noopener"
                           class="rounded-lg bg-blue-600 px-4 py-2 text-sm text-white transition hover:bg-blue-700">
                            Lihat Project
                        </a>
                    @endif

                    @if ($project->repository_url)
                        <a href="{{ $project->repository_url }}" target="_blank" rel="noopener"
                           class="rounded-lg border border-gray-300 px-4 py-2 text-sm text-gray-800 transition hover:bg-gray-50">
                            Repository
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </article>

    @if ($project->images->isNotEmpty())
        <section class="mt-10">
            <h2 class="mb-5 text-2xl font-bold text-gray-900">Gallery</h2>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3">
                @foreach ($project->images as $img)
                    <figure class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                        <img src="{{ asset('storage/' . $img->image) }}"
                             alt="{{ $img->caption ?: $project->title }}"
                             class="h-48 w-full object-cover">

                        @if ($img->caption)
                            <figcaption class="p-3 text-sm text-gray-600">
                                {{ $img->caption }}
                            </figcaption>
                        @endif
                    </figure>
                @endforeach
            </div>
        </section>
    @endif

</div>
@endsection
