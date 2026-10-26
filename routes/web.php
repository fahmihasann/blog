<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PostController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', fn() => view('home'))->name('home');
Route::get('/about', fn() => view('about'))->name('about');
Route::get('/education', fn() => view('education'))->name('education');

Route::resource('projects', ProjectController::class)->only(['index', 'show', 'create', 'store', 'edit', 'update', 'destroy']);

Route::get('/posts', [PostController::class, 'index']);