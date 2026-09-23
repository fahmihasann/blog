@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')

<div class="mt-10">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-bold text-gray-900">
            Project Portofolio
        </h1>

        <a href="{{ route('projects.create') }}"
        class="px-4 py-2 bg-black text-white rounded-lg">
            Tambah Project
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        @foreach ($projects as $project)

            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">

                <h2 class="text-xl font-bold text-gray-900 mb-3">
                    {{ $project->title }}
                </h2>

                <p class="text-gray-600 mb-4">
                    {{ $project->description }}
                </p>

                <a href="{{ route('projects.show', $project) }}"
                   class="text-blue-600">
                    Lihat Detail
                </a>

            </div>

        @endforeach

    </div>

</div>

@endsection