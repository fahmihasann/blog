@extends('layouts.app')

@section('title', 'Education - Portfolio')

@section('content')
<div class="mt-10">
    <h1 class="text-4xl font-bold text-gray-900 mb-6">Riwayat Pendidikan</h1>
        
    <ul class="list-disc pl-5 space-y-3 text-gray-700 text-lg marker:text-blue-600">
        <li>
            <strong class="text-gray-900">Sekolah Vokasi Universitas Gadjah Mada</strong> <br>
            <span class="text-base text-gray-500">Teknologi Rekayasa Perangkat Lunak</span>
        </li>
        <li>
            <strong class="text-gray-900">SMA Negeri 1 Wonosari</strong> <br>
            <span class="text-base text-gray-500">IPA</span>
        </li>
    </ul>
</div>
@endsection