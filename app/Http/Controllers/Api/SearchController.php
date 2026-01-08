<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\TechStack;
use App\Models\Version;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request): JsonResponse
    {
        $query = $request->get('query', '');
        $versionSlug = $request->get('version');

        if (strlen($query) < 2) {
            return response()->json(['results' => []]);
        }

        // Resolve version (default to latest stable if not provided)
        $version = null;
        if ($versionSlug) {
            $version = Version::where('slug', $versionSlug)->stable()->first();
        }
        if (!$version) {
            $version = Version::latestStable()->first();
        }

        $results = [
            'guides' => [],
            'components' => [],
            'tech_stacks' => [],
        ];

        // Search Posts
        $postsQuery = Post::published()
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('excerpt', 'like', "%{$query}%");
            });

        // Apply version filter if available
        if ($version) {
            $postsQuery->forVersion($version);
        }

        $posts = $postsQuery->select(['id', 'title', 'slug', 'pillar', 'excerpt'])
            ->limit(10)
            ->get();

        foreach ($posts as $post) {
            $category = $post->pillar->value === 'bricks' ? 'components' : 'guides';
            $results[$category][] = [
                'id' => $post->id,
                'title' => $post->title,
                'excerpt' => \Illuminate\Support\Str::limit($post->excerpt ?? '', 80),
                'url' => route('docs.show', [
                    'version' => $version?->slug ?? 'v11.x',
                    'category' => $post->pillar->value,
                    'slug' => $post->slug,
                ]),
                'pillar' => $post->pillar->getLabel(),
            ];
        }

        // Search Tech Stacks
        $techStacks = TechStack::where('name', 'like', "%{$query}%")
            ->orWhere('slug', 'like', "%{$query}%")
            ->select(['id', 'name', 'slug', 'type'])
            ->limit(5)
            ->get();

        foreach ($techStacks as $stack) {
            $results['tech_stacks'][] = [
                'id' => $stack->id,
                'title' => $stack->name,
                'type' => ucfirst($stack->type),
                'url' => null, // Tech stacks don't have dedicated pages yet
            ];
        }

        return response()->json([
            'results' => $results,
            'version' => $version?->name,
        ]);
    }
}
