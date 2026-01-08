<?php

namespace App\Http\Controllers;

use App\Enums\PillarType;
use App\Models\Post;
use App\Models\TechStack;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    public function show(string $version, string $category, string $slug)
    {
        // 1. Resolve Version
        $versionModel = Version::where('slug', $version)->stable()->first();

        if (!$versionModel) {
            // Fallback to latest stable version if the requested one doesn't exist or isn't stable
            $latestStable = Version::latestStable()->first();

            if (!$latestStable) {
                abort(404, 'No stable version available.');
            }

            // Redirect to the same post but with the latest stable version
            return redirect()->route('docs.show', [
                'version' => $latestStable->slug,
                'category' => $category,
                'slug' => $slug,
            ]);
        }

        // 2. Fetch Post
        $post = Post::with(['versions', 'techStacks', 'component', 'author'])
            ->published()
            ->where('slug', $slug)
            ->ofPillar($category)
            ->forVersion($versionModel)
            ->firstOrFail();

        // 3. Build Sidebar Data (Grouped by Tech Stack for current version)
        $sidebarData = $this->getSidebarData($versionModel);

        // 4. Get all versions for switcher
        $allVersions = Version::stable()->orderByDesc('slug')->get();

        return view('posts.show', [
            'post' => $post,
            'currentVersion' => $versionModel,
            'versions' => $allVersions,
            'sidebarData' => $sidebarData,
        ]);
    }

    /**
     * Get sidebar navigation grouped by TechStack.
     * Cached for 5 minutes per version.
     */
    protected function getSidebarData(Version $version): array
    {
        $cacheKey = "sidebar_v{$version->id}";

        return Cache::remember($cacheKey, now()->addMinutes(5), function () use ($version) {
            // Get all published posts for this version with their tech stacks
            $posts = Post::published()
                ->forVersion($version)
                ->with('techStacks:id,name,slug,icon_path')
                ->select(['id', 'title', 'slug', 'pillar'])
                ->get();

            // Group posts by their first tech stack
            $grouped = [];
            foreach ($posts as $post) {
                $stack = $post->techStacks->first();
                if (!$stack)
                    continue;

                $key = $stack->slug;
                if (!isset($grouped[$key])) {
                    $grouped[$key] = [
                        'name' => $stack->name,
                        'slug' => $stack->slug,
                        'icon_path' => $stack->icon_path,
                        'posts' => [],
                    ];
                }
                $grouped[$key]['posts'][] = [
                    'title' => $post->title,
                    'slug' => $post->slug,
                    'pillar' => $post->pillar->value,
                ];
            }

            return array_values($grouped);
        });
    }
}
