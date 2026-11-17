@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')
    <div class="mt-10">

        {{-- Judul + aksi admin --}}
        <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <h1 class="text-4xl font-bold text-gray-900">Project Portofolio</h1>

            @auth
                <a href="{{ route('post.projects.create') }}"
                   class="inline-block rounded-lg bg-black px-5 py-3 text-center text-sm text-white transition hover:bg-gray-800">
                    Tambah Project
                </a>
            @endauth
        </div>

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

        {{-- Search + filter + sorting (form GET) --}}
        <form action="{{ route('projects') }}" method="GET"
              class="mb-8 flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:flex-wrap sm:items-end">

            <div class="w-full sm:w-64">
                <label for="search" class="mb-2 block text-sm font-medium text-gray-700">Cari project</label>
                <input type="text" name="search" id="search" value="{{ request('search') }}"
                       placeholder="Judul atau deskripsi"
                       class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
            </div>

            <div class="w-full sm:w-52">
                <label for="category" class="mb-2 block text-sm font-medium text-gray-700">Kategori</label>
                <select name="category" id="category"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                    <option value="">Semua kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected(request('category') === $category->slug)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-52">
                <label for="technology" class="mb-2 block text-sm font-medium text-gray-700">Technology</label>
                <select name="technology" id="technology"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                    <option value="">Semua technology</option>
                    @foreach ($technologies as $technology)
                        <option value="{{ $technology->slug }}" @selected(request('technology') === $technology->slug)>
                            {{ $technology->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="w-full sm:w-56">
                <label for="sort" class="mb-2 block text-sm font-medium text-gray-700">Urutkan</label>
                <select name="sort" id="sort"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                    <option value="terbaru" @selected(request('sort', 'terbaru') === 'terbaru')>Tanggal project terbaru</option>
                    <option value="terlama" @selected(request('sort') === 'terlama')>Tanggal project terlama</option>
                    <option value="az" @selected(request('sort') === 'az')>Judul A-Z</option>
                </select>
            </div>

            <div class="flex gap-2">
                <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2 text-white transition hover:bg-blue-700">
                    Cari
                </button>
                <a href="{{ route('projects') }}"
                   class="rounded-lg bg-gray-200 px-5 py-2 text-gray-800 transition hover:bg-gray-300">
                    Reset
                </a>
            </div>
        </form>

        {{-- Ringkasan hasil --}}
        <div class="mb-4 flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
            <p class="text-sm text-gray-600">
                <span class="font-semibold text-gray-900">{{ $projects->total() }}</span> hasil ditemukan
            </p>

            @if (request()->hasAny(['search', 'category', 'technology', 'sort']))
                <p class="text-xs text-gray-500">
                    Filter aktif:
                    @if (request('search')) <span class="font-medium">"{{ request('search') }}"</span> @endif
                    @if (request('category')) <span class="ml-1">· kategori: {{ request('category') }}</span> @endif
                    @if (request('technology')) <span class="ml-1">· technology: {{ request('technology') }}</span> @endif
                </p>
            @endif
        </div>

        {{-- Grid project --}}
        <div class="grid grid-cols-1 gap-8 md:grid-cols-2 lg:grid-cols-3">
            @forelse ($projects as $project)
                <div class="flex flex-col overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm transition duration-300 hover:shadow-md">

                    @if ($project->thumbnail)
                        <img src="{{ asset('storage/' . $project->thumbnail) }}"
                             alt="{{ $project->title }}"
                             class="h-52 w-full border-b border-gray-100 object-cover">
                    @endif

                    <div class="flex flex-1 flex-col p-6">
                        <div class="mb-2 flex items-center justify-between gap-3">
                            <p class="text-xs font-semibold uppercase tracking-wider text-gray-500">
                                {{ $project->category?->name ?? 'Tanpa kategori' }}
                            </p>

                            @auth
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $project->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $project->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            @endauth
                        </div>

                        <h3 class="mb-2 text-lg font-bold text-gray-900">
                            <a href="{{ route('projects.show', $project) }}" class="hover:underline">
                                {{ $project->title }}
                            </a>
                        </h3>

                        <p class="mb-4 text-sm text-gray-600">
                            {{ \Illuminate\Support\Str::limit($project->short_description ?: $project->description, 150) }}
                        </p>

                        @if ($project->technologies->isNotEmpty())
                            <div class="mb-4 flex flex-wrap gap-2">
                                @foreach ($project->technologies as $technology)
                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-medium text-gray-700">
                                        {{ $technology->name }}
                                    </span>
                                @endforeach
                            </div>
                        @endif

                        <div class="mt-auto flex flex-wrap items-center gap-4 border-t border-gray-100 pt-4 text-sm">
                            <a href="{{ route('projects.show', $project) }}" class="text-blue-600 hover:underline">
                                Lihat Detail
                            </a>

                            @auth
                                <a href="{{ route('post.projects.edit', $project) }}" class="text-green-600 hover:underline">
                                    Edit
                                </a>

                                <form action="{{ route('post.projects.destroy', $project) }}" method="POST"
                                      onsubmit="return confirm('Apakah kamu yakin ingin menghapus project ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800">
                                        Hapus
                                    </button>
                                </form>
                            @endauth
                        </div>
                    </div>
                </div>
            @empty
                <div class="rounded-xl border border-gray-200 bg-white p-8 text-center text-gray-500 md:col-span-2 lg:col-span-3">
                    <p class="text-lg font-medium">Tidak ada project yang cocok.</p>
                    <p class="mt-2 text-sm">Coba ubah kata kunci, kategori, atau technology.</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if ($projects->total() > 0)
            <div class="mt-8">
                {{ $projects->links() }}
            </div>
        @endif

    </div>
@endsection
