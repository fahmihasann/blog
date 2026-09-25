@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')

<div class="mt-10">

    <div class="flex items-center justify-between mb-8">
        <h1 class="text-4xl font-bold text-gray-900">
            Project Portofolio
        </h1>

        <a
            href="{{ route('projects.create') }}"
            class="px-4 py-2 bg-black text-white rounded-lg"
        >
            Tambah Project
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-3 bg-green-50 border border-green-200 rounded-lg text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">

        @foreach ($projects as $project)

            <div class="bg-white rounded-xl border border-gray-200 p-6 shadow-sm">

                <h2 class="text-xl font-bold text-gray-900 mb-3">
                    {{ $project->title }}
                </h2>

                <p class="text-gray-600 mb-4">
                    {{ $project->description }}
                </p>

                <div class="flex gap-4">

                    <a
                        href="{{ route('projects.show', $project) }}"
                        class="text-blue-600 hover:underline"
                    >
                        Lihat Detail
                    </a>

                    <a
                        href="{{ route('projects.edit', $project) }}"
                        class="text-green-600 hover:underline"
                    >
                        Edit
                    </a>

                    <form
                        action="{{ route('projects.destroy', $project) }}"
                        method="POST"
                        onsubmit="return confirm('Apakah kamu yakin ingin menghapus project ini?')"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="text-red-600 hover:text-red-800"
                        >
                            Delete
                        </button>
                    </form>

                </div>

            </div>

        @endforeach

    </div>

</div>

@endsection