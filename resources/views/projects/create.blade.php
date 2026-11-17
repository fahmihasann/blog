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

    {{-- Pesan validasi --}}
    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
            <ul class="list-inside list-disc">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
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
            <label for="short_description" class="mb-2 block text-sm font-medium text-gray-700">Ringkasan</label>
            <input type="text" name="short_description" id="short_description" value="{{ old('short_description') }}"
                   maxlength="255"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            @error('short_description')
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
            <label for="project_date" class="mb-2 block text-sm font-medium text-gray-700">Tanggal Project</label>
            <input type="date" name="project_date" id="project_date"
                   value="{{ old('project_date') }}"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            @error('project_date')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="project_url" class="mb-2 block text-sm font-medium text-gray-700">URL Project</label>
            <input type="url" name="project_url" id="project_url" value="{{ old('project_url') }}"
                   placeholder="https://contoh.com"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            @error('project_url')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="repository_url" class="mb-2 block text-sm font-medium text-gray-700">URL Repository</label>
            <input type="url" name="repository_url" id="repository_url" value="{{ old('repository_url') }}"
                   placeholder="https://github.com/..."
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            @error('repository_url')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <span class="mb-2 block text-sm font-medium text-gray-700">Technologies</span>
            <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                @forelse ($technologies as $technology)
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="technologies[]" value="{{ $technology->id }}"
                               {{ in_array($technology->id, old('technologies', [])) ? 'checked' : '' }}>
                        {{ $technology->name }}
                    </label>
                @empty
                    <p class="text-sm text-gray-500">Belum ada data technology.</p>
                @endforelse
            </div>
            @error('technologies')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
            @error('technologies.*')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                   {{ old('is_featured') ? 'checked' : '' }}
                   class="rounded border-gray-300">
            <label for="is_featured" class="text-sm font-medium text-gray-700">Tampilkan sebagai project unggulan</label>
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
            <a href="{{ route('projects') }}"
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
