@extends('layouts.app')

@section('title', 'Kelola Skill - Portfolio')

@section('content')
<div class="mt-10">

    <h1 class="mb-8 text-3xl font-bold text-gray-900">Kelola Skill</h1>

    @if (session('success'))
        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <table class="min-w-full text-left text-sm">
            <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="px-6 py-3">Nama</th>
                    <th class="px-6 py-3">Kategori</th>
                    <th class="px-6 py-3">Level</th>
                    <th class="px-6 py-3 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($skills as $skill)
                    <tr>
                        <td class="px-6 py-4 font-medium text-gray-900">{{ $skill->name }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ $skill->category?->name ?? '-' }}</td>
                        <td class="px-6 py-4 text-gray-600">{{ ucfirst($skill->level) }}</td>
                        <td class="px-6 py-4 text-right">
                            <a href="{{ route('post.skills.edit', $skill) }}" class="text-green-600 hover:underline">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Belum ada skill.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

</div>
@endsection
