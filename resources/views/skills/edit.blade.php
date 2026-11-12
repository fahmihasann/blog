@extends('layouts.app')

@section('title', 'Edit Skill - Portfolio')

@section('content')
<div class="mt-10 max-w-2xl">

    <h1 class="mb-8 text-3xl font-bold text-gray-900">Edit Skill</h1>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('post.skills.update', $skill) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Nama Skill</label>
            <input type="text" name="name" id="name" value="{{ old('name', $skill->name) }}"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            @error('name')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category_id" class="mb-2 block text-sm font-medium text-gray-700">Kategori</label>
            <select name="category_id" id="category_id"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id', $skill->category_id) == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="mb-2 block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="4"
                      class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">{{ old('description', $skill->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="level" class="mb-2 block text-sm font-medium text-gray-700">Level</label>
            <select name="level" id="level"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
                @foreach (['beginner', 'intermediate', 'advanced'] as $level)
                    <option value="{{ $level }}" {{ old('level', $skill->level) === $level ? 'selected' : '' }}>
                        {{ ucfirst($level) }}
                    </option>
                @endforeach
            </select>
            @error('level')
                <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <a href="{{ route('post.skills.index') }}"
               class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm transition hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="rounded-lg bg-black px-4 py-2.5 text-sm text-white transition hover:bg-gray-800">
                Update Skill
            </button>
        </div>
    </form>

</div>
@endsection
