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
            <p class="mb-2 text-xs font-semibold uppercase tracking-wider text-gray-500">
                {{ $project->category?->name ?? 'Tanpa kategori' }}
            </p>

            <h1 class="mb-4 text-3xl font-bold text-gray-900">{{ $project->title }}</h1>

            <p class="whitespace-pre-line text-gray-600">{{ $project->description }}</p>
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
