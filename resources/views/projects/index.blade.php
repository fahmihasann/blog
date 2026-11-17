@extends('layouts.app')

@section('title', 'Kelola Project - Portfolio')

@section('content')
<div class="mt-10">

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Kelola Project</h1>

        <a href="{{ route('post.projects.create') }}"
           class="inline-block rounded-lg bg-black px-5 py-3 text-center text-sm text-white transition hover:bg-gray-800">
            Tambah Project
        </a>
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

    {{-- Search + filter status --}}
    <form action="{{ route('post.projects.index') }}" method="GET"
          class="mb-6 flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:flex-wrap sm:items-end">

        <div class="w-full sm:w-72">
            <label for="search" class="mb-2 block text-sm font-medium text-gray-700">Cari project</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                   placeholder="Judul atau deskripsi singkat"
                   class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        <div class="w-full sm:w-52">
            <label for="status" class="mb-2 block text-sm font-medium text-gray-700">Status</label>
            <select name="status" id="status"
                    class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                <option value="">Semua status</option>
                <option value="published" @selected(request('status') === 'published')>Published</option>
                <option value="draft" @selected(request('status') === 'draft')>Draft</option>
            </select>
        </div>

        <div class="flex gap-2">
            <button type="submit" class="rounded-lg bg-blue-600 px-5 py-2 text-white transition hover:bg-blue-700">
                Cari
            </button>
            <a href="{{ route('post.projects.index') }}"
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

        @if (request()->hasAny(['search', 'status']))
            <p class="text-xs text-gray-500">
                Filter aktif:
                @if (request('search')) <span class="font-medium">"{{ request('search') }}"</span> @endif
                @if (request('status')) <span class="ml-1">· status: {{ request('status') }}</span> @endif
            </p>
        @endif
    </div>

    {{-- Tabel project --}}
    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Judul</th>
                        <th class="px-6 py-3">Kategori</th>
                        <th class="px-6 py-3">Technology</th>
                        <th class="px-6 py-3">Tanggal Project</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($projects as $project)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $project->title }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $project->category?->name ?? '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $project->technologies->pluck('name')->join(', ') ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $project->project_date?->format('d M Y') ?? '-' }}
                            </td>
                            <td class="px-6 py-4">
                                <span class="rounded-full px-2 py-1 text-xs font-semibold {{ $project->status === 'published' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-600' }}">
                                    {{ $project->status === 'published' ? 'Published' : 'Draft' }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex flex-wrap items-center justify-end gap-3">
                                    <a href="{{ route('post.projects.show', $project) }}" class="text-blue-600 hover:underline">
                                        Detail
                                    </a>
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
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-10 text-center text-gray-500">
                                <p class="text-base font-medium">Tidak ada project yang cocok.</p>
                                <p class="mt-1 text-sm">Coba ubah kata kunci atau filter status.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Pagination --}}
    @if ($projects->total() > 0)
        <div class="mt-8">
            {{ $projects->links() }}
        </div>
    @endif

</div>
@endsection
