<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectGalleryController;
use App\Http\Controllers\SkillController;
use Illuminate\Support\Facades\Route;

// Halaman publik
Route::get('/', fn () => view('home'))->name('home');
Route::get('/about', fn () => view('about'))->name('about');
Route::get('/education', fn () => view('education'))->name('education');

// Halaman publik project
Route::get('/projects', [PortfolioController::class, 'projects'])->name('projects');
Route::get('/projects/{project}', [PortfolioController::class, 'show'])->name('projects.show');

// Dashboard admin
Route::prefix('post')->name('post.')->middleware('auth')->group(function () {
    Route::resource('dashboard', DashboardController::class);
    Route::resource('projects', ProjectController::class);

    // Gallery project
    Route::post('projects/{project}/images', [ProjectGalleryController::class, 'store'])
        ->name('projects.images.store');
    Route::put('projects/{project}/images/{image}', [ProjectGalleryController::class, 'update'])
        ->name('projects.images.update');
    Route::delete('projects/{project}/images/{image}', [ProjectGalleryController::class, 'destroy'])
        ->name('projects.images.destroy');

    // Skill
    Route::resource('skills', SkillController::class)->only(['index', 'edit', 'update']);
});

// Dashboard pengguna
// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route khusus pengguna yang sudah login
Route::middleware('auth')->group(function () {

    // Pengaturan profil bawaan Laravel Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

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
