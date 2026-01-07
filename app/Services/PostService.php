<?php

namespace App\Services;

use App\Models\Post;
use Illuminate\Support\Str;

class PostService
{
    /**
     * Create a new post with related data sync.
     */
    public function createPost(array $data): Post
    {
        $postData = $this->preparePostData($data);

        $post = Post::create($postData);

        $this->syncRelationships($post, $data);

        return $post;
    }

    /**
     * Update existing post.
     */
    public function updatePost(Post $post, array $data): Post
    {
        $postData = $this->preparePostData($data);

        $post->update($postData);

        $this->syncRelationships($post, $data);

        return $post;
    }

    protected function preparePostData(array $data): array
    {
        // Calculate read time or other derived data here if needed
        return [
            'title' => $data['title'],
            'slug' => $data['slug'] ?? Str::slug($data['title']),
            'pillar' => $data['pillar'],
            'excerpt' => $data['excerpt'],
            'content_theory' => $data['content_theory'],
            'content_technical' => $data['content_technical'],
            'troubleshooting' => $data['troubleshooting'] ?? null,
            'published_at' => $data['published_at'],
            'user_id' => $data['user_id'],
            'component_id' => $data['component_id'] ?? null,
        ];
    }

    protected function syncRelationships(Post $post, array $data): void
    {
        if (isset($data['techStacks'])) {
            $post->techStacks()->sync($data['techStacks']);
        }

        if (isset($data['versions'])) {
            $post->versions()->sync($data['versions']);
        }
    }
}
