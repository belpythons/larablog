<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

// Langsung ke Landing Page Blog
Route::get('/', [BlogController::class, 'index'])->name('home');
Route::get('/belajar/{slug}', [BlogController::class, 'show'])->name('post.show');
