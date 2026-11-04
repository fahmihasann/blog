@extends('layouts.app')

@section('title', 'Profile Saya')

@section('content')

<div class="py-10">
    <div class="max-w-3xl mx-auto">

        {{-- Judul halaman --}}
        <div class="mb-8">
            <p class="text-sm font-medium text-gray-500 mb-2">
                Akun Pengguna
            </p>

            <h1 class="text-3xl font-bold text-gray-900">
                Profile Saya
            </h1>

            <p class="text-gray-500 mt-2">
                Informasi akun yang sedang kamu gunakan.
            </p>
        </div>

        {{-- Kartu profil --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            <div class="px-6 py-5 border-b border-gray-200">
                <h2 class="text-lg font-semibold text-gray-900">
                    Informasi Pengguna
                </h2>
            </div>

            <div class="p-6 space-y-6">

                {{-- Nama --}}
                <div>
                    <p class="text-sm text-gray-500 mb-1">Nama Lengkap</p>
                    <p class="text-base font-semibold text-gray-900">
                        {{ auth()->user()->name }}
                    </p>
                </div>

                {{-- Email --}}
                <div>
                    <p class="text-sm text-gray-500 mb-1">Email</p>
                    <p class="text-base font-semibold text-gray-900">
                        {{ auth()->user()->email }}
                    </p>
                </div>

                {{-- Role --}}
                <div>
                    <p class="text-sm text-gray-500 mb-1">Role Pengguna</p>

                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        {{ auth()->user()->role === 'admin'
                            ? 'bg-green-100 text-green-700'
                            : 'bg-gray-100 text-gray-700' }}">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                </div>

            </div>

        </div>

    </div>
</div>

@endsection