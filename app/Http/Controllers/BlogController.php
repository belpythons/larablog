<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $articles = [
            [
                'judul' => 'Mengenal Laravel 11 untuk Pemula',
                'deskripsi' => 'Laravel adalah framework PHP modern yang sangat powerful untuk membangun web.',
                'image' => 'https://source.unsplash.com/600x400/?code,developer',
                'kategori' => 'Laravel',
                'tanggal' => '12 Januari 2025'
            ],
            [
                'judul' => 'Belajar UI/UX dengan Mudah',
                'deskripsi' => 'UI/UX adalah aspek penting dalam pengembangan aplikasi modern.',
                'image' => 'https://source.unsplash.com/600x400/?design,uiux',
                'kategori' => 'UI/UX',
                'tanggal' => '15 Januari 2025'
            ],
            [
                'judul' => 'Bootstrap 5 Tips & Tricks',
                'deskripsi' => 'Cara membuat tampilan modern dan responsif dengan Bootstrap 5.',
                'image' => 'https://source.unsplash.com/600x400/?bootstrap,css',
                'kategori' => 'Bootstrap',
                'tanggal' => '18 Januari 2025'
            ]
        ];

        return view('blog', compact('articles'));
    }
}
