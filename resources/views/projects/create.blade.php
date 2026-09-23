@extends('layouts.app')

@section('title', 'Tambah Project - Portfolio')

@section('content')
<div class="mt-10 max-w-2xl">
    <h1 class="text-4xl font-bold text-gray-900 mb-2">
        Tambah Project
    </h1>

    <form action="{{ route('projects.store') }}" method="POST" class="space-y-6">
        @csrf

        <div>
            <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                Judul Project
            </label>

            <input 
                type="text" 
                name="title" 
                id="title" 
                value="{{ old('title') }}" 
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:border-black"
            >

            @error('title')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div>
            <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi Project
            </label>

            <textarea 
                name="description" 
                id="description" 
                rows="6" 
                class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:outline-none focus:border-black"
            >{{ old('description') }}</textarea>

            @error('description')
                <p class="mt-1 text-sm text-red-600">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex gap-3">
            <a href="{{ route('projects.index') }}" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm hover:bg-gray-50 transition">
                Batal
            </a>

            <button type="submit" class="px-4 py-2.5 bg-black text-white rounded-lg text-sm hover:bg-gray-800 transition">
                Simpan Project
            </button>
        </div>
    </form>
</div>
@endsection