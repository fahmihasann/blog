@extends('layouts.app')

@section('title', $project->title . ' - Portfolio')

@section('content')

<div class="mt-10 max-w-3xl mx-auto">

    <a href="{{ route('projects.index') }}"
       class="text-blue-600 hover:underline">
        Kembali ke Projects
    </a>

    <div class="mt-6 bg-white border border-gray-200 rounded-xl p-8 shadow-sm">

        <h1 class="text-3xl font-bold text-gray-900 mb-4">
            {{ $project->title }}
        </h1>

        <p class="text-gray-600">
            {{ $project->description }}
        </p>

    </div>

</div>

@endsection