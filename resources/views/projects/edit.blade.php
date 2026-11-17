@extends('layouts.app')

@section('title', 'Edit Project - Portfolio')

@section('content')
<div class="mt-10 max-w-2xl">

    <h1 class="mb-8 text-3xl font-bold text-gray-900">Edit Project</h1>

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

    <form id="project-form" action="{{ route('post.projects.update', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-gray-700">Nama Project</label>
            <input type="text" name="name" id="name" value="{{ old('name', $project->title) }}"
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
                    <option value="{{ $category->id }}" {{ old('category_id', $project->category_id) == $category->id ? 'selected' : '' }}>
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
            <input type="text" name="short_description" id="short_description"
                   value="{{ old('short_description', $project->short_description) }}" maxlength="255"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            @error('short_description')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="description" class="mb-2 block text-sm font-medium text-gray-700">Deskripsi Project</label>
            <textarea name="description" id="description" rows="6"
                      class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">{{ old('description', $project->description) }}</textarea>
            @error('description')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="status" class="mb-2 block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
                <option value="draft" {{ old('status', $project->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                <option value="published" {{ old('status', $project->status) === 'published' ? 'selected' : '' }}>Published</option>
            </select>
            @error('status')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="project_date" class="mb-2 block text-sm font-medium text-gray-700">Tanggal Project</label>
            <input type="date" name="project_date" id="project_date"
                   value="{{ old('project_date', $project->project_date?->format('Y-m-d')) }}"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            @error('project_date')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="project_url" class="mb-2 block text-sm font-medium text-gray-700">URL Project</label>
            <input type="url" name="project_url" id="project_url"
                   value="{{ old('project_url', $project->project_url) }}"
                   placeholder="https://contoh.com"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            @error('project_url')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="repository_url" class="mb-2 block text-sm font-medium text-gray-700">URL Repository</label>
            <input type="url" name="repository_url" id="repository_url"
                   value="{{ old('repository_url', $project->repository_url) }}"
                   placeholder="https://github.com/..."
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            @error('repository_url')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <span class="mb-2 block text-sm font-medium text-gray-700">Technologies</span>
            <div class="grid grid-cols-2 gap-2 sm:grid-cols-3">
                @php
                    $selectedTechnologies = old('technologies', $project->technologies->pluck('id')->all());
                @endphp
                @forelse ($technologies as $technology)
                    <label class="flex items-center gap-2 text-sm text-gray-700">
                        <input type="checkbox" name="technologies[]" value="{{ $technology->id }}"
                               {{ in_array($technology->id, $selectedTechnologies) ? 'checked' : '' }}>
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
                   {{ old('is_featured', $project->is_featured) ? 'checked' : '' }}
                   class="rounded border-gray-300">
            <label for="is_featured" class="text-sm font-medium text-gray-700">Tampilkan sebagai project unggulan</label>
        </div>

        <div>
            <label for="thumbnail" class="mb-2 block text-sm font-medium text-gray-700">Thumbnail</label>

            @if ($project->thumbnail)
                <img src="{{ asset('storage/' . $project->thumbnail) }}"
                     alt="{{ $project->title }}"
                     class="mb-3 h-40 w-full rounded-lg object-cover">
            @endif

            <input type="file" name="thumbnail" id="thumbnail" accept="image/*"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
            <p class="mt-1 text-xs text-gray-500">Kosongkan jika tidak ingin mengganti thumbnail.</p>
            @error('thumbnail')
                <p class="mt-1 text-red-500 text-sm">{{ $message }}</p>
            @enderror
        </div>

    </form>

    {{-- Gallery --}}
    <div class="mt-8">
        <h2 class="mb-2 block text-sm font-medium text-gray-700">Gallery</h2>

        <form action="{{ route('post.projects.images.store', $project) }}" method="POST" enctype="multipart/form-data" class="space-y-3">
            @csrf
            <div>
                <input type="file" name="images[]" multiple accept="image/*"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2.5 focus:border-black focus:outline-none">
                <p class="mt-1 text-xs text-gray-500">Maksimal 10 gambar per project. Lebar minimal 800 px.</p>
            </div>
            @error('images')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror
            @error('images.*')
                <p class="text-red-500 text-sm">{{ $message }}</p>
            @enderror

            <button type="submit" class="rounded-lg bg-blue-600 px-4 py-2.5 text-sm text-white transition hover:bg-blue-700">
                Unggah Gambar
            </button>
        </form>

        <div class="mt-6 grid grid-cols-2 gap-4 md:grid-cols-3">
            @forelse ($project->images as $image)
                <div class="overflow-hidden rounded-lg border border-gray-200 bg-white shadow-sm">
                    <img src="{{ asset('storage/' . $image->image) }}"
                         alt="{{ $image->caption ?: $project->title }}"
                         class="h-40 w-full object-cover">

                    <div class="space-y-3 p-3">
                        <form action="{{ route('post.projects.images.update', [$project, $image]) }}" method="POST" class="space-y-2">
                            @csrf
                            @method('PUT')
                            <input type="text" name="caption" value="{{ old('caption', $image->caption) }}"
                                   placeholder="Caption gambar"
                                   class="w-full rounded-lg border border-gray-300 px-3 py-1.5 text-sm focus:border-black focus:outline-none">
                            <button type="submit" class="text-sm text-blue-600 hover:underline">
                                Simpan Caption
                            </button>
                        </form>

                        <form action="{{ route('post.projects.images.destroy', [$project, $image]) }}" method="POST"
                              onsubmit="return confirm('Hapus gambar ini?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-sm text-red-600 hover:text-red-800">
                                Hapus Gambar
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-sm text-gray-500">Belum ada gambar gallery.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-8 flex gap-3">
        <a href="{{ route('projects') }}"
           class="rounded-lg border border-gray-300 px-4 py-2.5 text-sm transition hover:bg-gray-50">
            Batal
        </a>
        <button type="submit" form="project-form" class="rounded-lg bg-black px-4 py-2.5 text-sm text-white transition hover:bg-gray-800">
            Update Project
        </button>
    </div>

</div>
@endsection
