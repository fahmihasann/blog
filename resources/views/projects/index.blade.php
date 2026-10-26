@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')
<div class="mx-auto mt-10 max-w-7xl px-4 sm:px-6 lg:px-8">

    {{-- Judul halaman dan tombol tambah --}}
    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-3xl font-bold text-gray-900 sm:text-4xl">
            Project Portofolio
        </h1>

        <a
            href="{{ route('projects.create') }}"
            class="inline-block rounded-lg bg-black px-5 py-3 text-center text-white transition hover:bg-gray-800">
            Tambah Project
        </a>
    </div>

    {{-- Pesan sukses --}}
    @if (session('success'))
    <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
        {{ session('success') }}
    </div>
    @endif

    {{-- Pesan validasi jika ada --}}
    @if ($errors->any())
    <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4 text-red-700">
        <ul class="list-inside list-disc">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    {{-- Form pencarian dan pilihan jumlah data --}}
    <form
        action="{{ route('projects.index') }}"
        method="GET"
        class="mb-8 flex flex-col gap-4 rounded-xl border border-gray-200 bg-white p-5 shadow-sm sm:flex-row sm:flex-wrap sm:items-end">
        <div class="w-full sm:w-64">
            <label
                for="search"
                class="mb-2 block text-sm font-medium text-gray-700">
                Cari judul
            </label>

            <input
                type="text"
                name="search"
                id="search"
                value="{{ $search }}"
                placeholder="Masukkan judul proyek"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
        </div>

        <div class="w-full sm:w-44">
            <label
                for="per_page"
                class="mb-2 block text-sm font-medium text-gray-700">
                Data per halaman
            </label>

            <select
                name="per_page"
                id="per_page"
                class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-blue-500 focus:outline-none">
                <option value="5" {{ $perPage == 5 ? 'selected' : '' }}>
                    5 data
                </option>

                <option value="10" {{ $perPage == 10 ? 'selected' : '' }}>
                    10 data
                </option>

                <option value="25" {{ $perPage == 25 ? 'selected' : '' }}>
                    25 data
                </option>
            </select>
        </div>

        <div class="flex gap-2">
            <button
                type="submit"
                class="rounded-lg bg-blue-600 px-5 py-2 text-white transition hover:bg-blue-700">
                Cari
            </button>

            <a
                href="{{ route('projects.index') }}"
                class="rounded-lg bg-gray-200 px-5 py-2 text-gray-800 transition hover:bg-gray-300">
                Reset
            </a>
        </div>
    </form>

    {{-- Jumlah project --}}
    <div class="mb-4 text-sm text-gray-600">
        Ditemukan {{ $projects->total() }} project.
    </div>

    {{-- Grid kartu proyek --}}
    <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

        @forelse ($projects as $project)
        <div class="flex flex-col rounded-xl border border-gray-200 bg-white p-6 shadow-sm transition hover:shadow-md">

            <h2 class="mb-3 break-words text-xl font-bold text-gray-900">
                {{ $project->title }}
            </h2>

            <p class="mb-5 whitespace-pre-line break-words text-gray-600">
                {{ $project->description }}
            </p>

            {{-- Tombol aksi --}}
            <div class="mt-auto flex flex-wrap items-center gap-4 border-t border-gray-100 pt-4">

                <a
                    href="{{ route('projects.show', $project) }}"
                    class="text-blue-600 hover:underline">
                    Lihat Detail
                </a>

                <a
                    href="{{ route('projects.edit', $project) }}"
                    class="text-green-600 hover:underline">
                    Edit
                </a>

                <form
                    action="{{ route('projects.destroy', $project) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah kamu yakin ingin menghapus project ini?')">
                    @csrf
                    @method('DELETE')

                    <button
                        type="submit"
                        class="text-red-600 hover:text-red-800">
                        Delete
                    </button>
                </form>

            </div>
        </div>
        @empty
        <div class="rounded-xl border border-gray-200 bg-white p-8 text-center text-gray-500 md:col-span-2">
            <p class="text-lg font-medium">
                Tidak ada project yang ditemukan.
            </p>

            <p class="mt-2 text-sm">
                Coba gunakan kata kunci lain atau tekan Reset.
            </p>
        </div>
        @endforelse

    </div>

    {{-- Informasi pagination --}}
    @if ($projects->total() > 0)
    <div class="mt-8 text-sm leading-6 text-gray-600">
        Menampilkan {{ $projects->firstItem() }}–{{ $projects->lastItem() }}
        dari {{ $projects->total() }} project.
        <br>

        Halaman {{ $projects->currentPage() }}
        dari {{ $projects->lastPage() }}.
        <br>

        Data per halaman: {{ $projects->perPage() }}.
    </div>
    @endif

    {{-- Navigasi pagination --}}
    <div class="mt-5">
        {{ $projects->links() }}
    </div>

</div>
@endsection
