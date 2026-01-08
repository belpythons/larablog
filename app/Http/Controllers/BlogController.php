<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        $posts = Post::with(['techStacks', 'author'])
            ->published()
            ->latest('published_at')
            ->paginate(9);

        return view('blog', compact('posts'));
    }
}
