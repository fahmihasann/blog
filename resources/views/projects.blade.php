@extends('layouts.app')

@section('title', 'Projects - Portfolio')

@section('content')
    <div class="mt-10">
        <h1 class="text-4xl font-bold text-gray-900 mb-8">Project Portofolio</h1>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                <img src="https://images.unsplash.com/photo-1555099962-4199c345e5dd?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Proyek 1" 
                     class="w-full h-52 object-cover border-b border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Proyek Website</h3>
                    <p class="text-gray-600 text-sm">
                        Website sederhana dengan tampilan bersih dan mudah digunakan.
                    </p>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-gray-200 overflow-hidden shadow-sm hover:shadow-md transition duration-300">
                <img src="https://images.unsplash.com/photo-1542831371-29b0f74f9713?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" 
                     alt="Proyek 2" 
                     class="w-full h-52 object-cover border-b border-gray-100">
                <div class="p-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-2">Proyek Aplikasi</h3>
                    <p class="text-gray-600 text-sm">
                        Aplikasi sederhana yang berfokus pada pengalaman pengguna.
                    </p>
                </div>
            </div>

        </div>
    </div>
@endsection