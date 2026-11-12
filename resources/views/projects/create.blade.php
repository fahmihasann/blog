@extends('layouts.app')

@section('title', 'Tambah Project - Portfolio')

@section('content')
<div class="mt-10 max-w-2xl">

    <h1 class="mb-8 text-3xl font-bold text-gray-900">Tambah Project</h1>

    {{-- Pesan sukses --}}
    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('post.projects.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Nama Project</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            @error('name')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="category_id" class="mb-2 block text-sm font-medium text-gray-700">Kategori</label>
            <select name="category_id" id="category_id"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
                <option value="">Pilih kategori</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            @error('category_id')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="mb-2 block text-sm font-medium text-gray-700">Deskripsi Project</label>
            <textarea name="description" id="description" rows="6"
                      class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">{{ old('description') }}</textarea>
            @error('description')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="mb-2 block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
                <option value="draft" {{ old('status', 'draft') === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status') === 'published' ? 'selected' : '' }}>Published</option>
            </select>
            @error('status')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="thumbnail" class="mb-2 block text-sm font-medium text-gray-700">Thumbnail</label>
            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            <p class="mt-1 text-xs text-gray-500">JPG, JPEG, PNG, atau WEBP. Maksimal 2 MB, minimal 400x300 px.</p>
            @error('thumbnail')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex gap-3">
            <a href="{{ route('post.projects.index') }}"
               class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm transition hover:bg-gray-50">
                Batal
            </a>
            <button type="submit" class="rounded-lg bg-black px-4 py-2.5 text-sm text-white transition hover:bg-gray-800">
                Simpan
            </button>
        </div>
    </form>

</div>
@endsection
