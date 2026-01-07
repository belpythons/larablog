<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BlogController;

Route::get('/', function () {
    return redirect('/blog');
});

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');

// Documentation Routes
Route::prefix('docs')->group(function () {
    // Redirect /docs to latest version or landing? For now, redirect to blog or specific page
    Route::get('/', function () {
        return redirect()->route('blog.index');
    });

    Route::get('/{version}/{category}/{slug}', [PostController::class, 'show'])
        ->where([
            'version' => 'v[0-9]+(\.x)?', // Regex constraint for version structure if needed
            'category' => 'ecosystem|starter_kit|bricks', // Enforce pillar types
        ])
        ->name('docs.show');
});
