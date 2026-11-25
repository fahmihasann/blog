@extends('layouts.app')

@section('title', 'Detail Pesan - Portfolio')

@section('content')
<div class="mt-10">

    <div class="mb-8 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Detail Pesan</h1>

        <a href="{{ route('post.contacts.index') }}"
           class="inline-block rounded-lg bg-gray-200 px-5 py-3 text-center text-sm text-gray-800 transition hover:bg-gray-300">
            Kembali ke Messages
        </a>
    </div>

    <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
        <div class="mb-6 flex flex-col gap-3 border-b border-gray-100 pb-6 sm:flex-row sm:items-start sm:justify-between">
            <div>
                <h2 class="text-xl font-semibold text-gray-900">{{ $contact->subject ?: '(Tanpa subjek)' }}</h2>
                <p class="mt-1 text-sm text-gray-600">
                    Dari <span class="font-medium text-gray-900">{{ $contact->name }}</span>
                    &middot; {{ $contact->email }}
                </p>
                <p class="mt-1 text-sm text-gray-500">
                    Dikirim {{ $contact->created_at?->format('d M Y H:i') }}
                </p>
            </div>

            @if ($contact->is_read)
                <span class="rounded-full bg-emerald-100 px-2 py-1 text-xs font-semibold text-emerald-700">
                    Sudah dibaca
                </span>
            @else
                <span class="rounded-full bg-amber-100 px-2 py-1 text-xs font-semibold text-amber-700">
                    Belum dibaca
                </span>
            @endif
        </div>

        <div class="whitespace-pre-line text-gray-700">{{ $contact->message }}</div>
    </div>

</div>
@endsection
