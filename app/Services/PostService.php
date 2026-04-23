<?php

namespace App\Services;

use Illuminate\Support\Facades\File;
use Spatie\YamlFrontMatter\YamlFrontMatter;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class PostService
{
    /**
     * Get all posts from markdown files.
     */
    public function getAllPosts(): Collection
    {
        return collect(File::files(resource_path('posts')))
            ->map(function ($file) {
                return $this->parsePost($file->getPathname());
            })
            ->sortBy([
                ['fase', 'asc'],
                ['urutan', 'asc']
            ])
            ->values();
    }

    /**
     * Get a single post by slug.
     */
    public function getPostBySlug(string $slug): ?object
    {
        return $this->getAllPosts()->firstWhere('slug', $slug);
    }

    /**
     * Parse a single markdown file into an object.
     */
    protected function parsePost(string $path): object
    {
        $document = YamlFrontMatter::parseFile($path);
        
        return (object) [
            'title' => $document->title,
            'description' => $document->description,
            'slug' => Str::slug($document->title),
            'fase' => $document->fase,
            'urutan' => $document->urutan,
            'content' => $document->body(),
            'content_theory' => $document->body(),
            'content_technical' => '',
            'troubleshooting' => [],
            'pillar' => (object) ['value' => 'basics'],
            'techStacks' => collect([]),
            'author' => (object) ['name' => 'Admin'],
            'published_at' => now(), // mock
            'excerpt' => $document->description,
        ];
    }
}
