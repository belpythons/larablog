<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class PostController extends Controller
{
    public function show(string $version = null, string $category = null, string $slug = null)
    {
        // 1. Version Fallback Logic
        // If version is missing (e.g. accessed via direct link or search), redirect to latest version?
        // Or if URL is /docs/{slug} try to guess.
        // For now, let's strictly follow the route pattern: /docs/{version}/{category}/{slug}

        $versionModel = Version::where('slug', $version)->firstOrFail();

        // 2. Resolve Post
        $post = Post::where('slug', $slug)
            ->where('pillar', $category) // Mapping category to pillar? The prompt says "category" but DB has "pillar". 
            // "category" in URL = "pillar" in DB (ecosystem, starter_kit, bricks)
            ->whereHas('versions', function ($query) use ($versionModel) {
                $query->where('versions.id', $versionModel->id);
            })
            ->with(['techStacks', 'component', 'author'])
            ->firstOrFail();

        // 3. Eager load troubleshooting separately if it's a JSON field, it's already loaded.
        // If troubleshooting was a relationship, we'd load it. It's a JSON column, so it's fine.

        return view('posts.show', [
            'post' => $post,
            'currentVersion' => $versionModel,
            'versions' => Version::all(), // For switcher
        ]);
    }
}
