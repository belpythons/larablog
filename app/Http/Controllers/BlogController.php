<?php

namespace App\Http\Controllers;

use Illuminate\Contracts\View\View;
use App\Services\PostService;

class BlogController extends Controller
{
    protected PostService $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }

    public function index(): View
    {
        $posts = $this->postService->getAllPosts();

        $stats = [
            'tech_stacks_count' => 0,
            'versions_count' => 0,
        ];

        return view('blog', [
            'posts' => $posts,
            'stats' => $stats,
        ]);
    }

    public function show(string $slug): View
    {
        $post = $this->postService->getPostBySlug($slug);

        if (!$post) {
            abort(404);
        }

        return view('posts.show', [
            'post' => $post,
            'currentVersion' => (object) ['name' => 'v11.x', 'slug' => 'v11-x'],
            'versions' => collect([(object) ['name' => 'v11.x', 'slug' => 'v11-x']]),
            'sidebarData' => collect([])
        ]);
    }
}
