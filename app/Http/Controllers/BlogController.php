<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\TechStack;
use App\Models\Version;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Cache;

class BlogController extends Controller
{
    public function index(): View
    {
        // Optimized query with specific columns and eager loading
        $posts = Post::query()
            ->select(['id', 'title', 'slug', 'excerpt', 'content_theory', 'pillar', 'user_id', 'component_id', 'published_at'])
            ->with([
                'author:id,name',
                'techStacks:id,name',
            ])
            ->published()
            ->latest('published_at')
            ->paginate(12);

        // Cache stats for 1 hour to avoid N+1 queries in view
        $stats = Cache::remember('blog.stats', 3600, fn() => [
            'tech_stacks_count' => TechStack::count(),
            'versions_count' => Version::stable()->count(),
        ]);

        return view('blog', [
            'posts' => $posts,
            'stats' => $stats,
        ]);
    }

    /**
     * Display the changelog for a specific version (Living Documentation).
     */
    public function changelog(string $versionSlug): View
    {
        $version = Version::where('slug', $versionSlug)->firstOrFail();
        $versions = Version::stable()->orderByDesc('slug')->get(['id', 'name', 'slug']);

        return view('changelog', [
            'version' => $version,
            'versions' => $versions,
            'changelog' => $version->changelog,
        ]);
    }
}
