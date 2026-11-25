@extends('layouts.app')

@section('title', 'Messages - Portfolio')

@section('content')
<div class="mt-10">

    <h1 class="mb-8 text-3xl font-bold text-gray-900">Messages</h1>

    <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-left text-sm">
                <thead class="bg-gray-50 text-xs uppercase tracking-wider text-gray-500">
                    <tr>
                        <th class="px-6 py-3">Nama</th>
                        <th class="px-6 py-3">Email</th>
                        <th class="px-6 py-3">Subjek</th>
                        <th class="px-6 py-3">Waktu Kirim</th>
                        <th class="px-6 py-3">Status</th>
                        <th class="px-6 py-3 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($contacts as $contact)
                        <tr>
                            <td class="px-6 py-4 font-medium text-gray-900">
                                {{ $contact->name }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $contact->email }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $contact->subject ?: '-' }}
                            </td>
                            <td class="px-6 py-4 text-gray-600">
                                {{ $contact->created_at?->format('d M Y H:i') }}
                            </td>
                            <td class="px-6 py-4">
                                @if ($contact->is_read)
                                    <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">
                                        Sudah dibaca
                                    </span>
                                @else
                                    <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">
                                        Belum dibaca
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 text-right">
                                <a href="{{ route('post.contacts.show', $contact) }}" class="text-blue-600 hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                                Belum ada pesan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($contacts->total() > 0)
        <div class="mt-8">
            {{ $contacts->links() }}
        </div>
    @endif

</div>
@endsection
