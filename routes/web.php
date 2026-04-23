<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Mock routes for flat-file blog
Route::get('/docs', function () { return 'Docs Index'; })->name('blog.index');
Route::get('/changelog/{version}', function ($version) { return "Changelog $version"; })->name('docs.changelog');
Route::get('/docs/{version}/{category}/{slug}', function ($version, $category, $slug) { return "Docs $version $category $slug"; })->name('docs.show');

// Flat-file blog routes will be added here
