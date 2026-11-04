<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

// Halaman publik
Route::get('/', fn () => view('home'))->name('home');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/education', fn () => view('education'))->name('education');

// Dashboard pengguna
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route khusus pengguna yang sudah login
Route::middleware('auth')->group(function () {

    // Pengaturan profil bawaan Laravel Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    // Manajemen project
    Route::resource('projects', ProjectController::class)
        ->only([
            'index',
            'show',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
        ]);

    // Halaman profil pengguna
    Route::get('/post/profile-saya', function () {
        return view('post.profile-saya');
    })->name('post.profile-saya');

    // Route khusus admin
    Route::middleware('admin')->group(function () {

        Route::get('/admin/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

    });

});

// Route autentikasi Laravel Breeze
require __DIR__ . '/auth.php';