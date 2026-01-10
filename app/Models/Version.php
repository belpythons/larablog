<?php

namespace App\Models;

use App\Enums\PillarType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

class Version extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    /**
     * Get the changelog for this version (all related posts).
     * Returns posts grouped by pillar type for organized changelog display.
     * 
     * @return Collection<string, Collection<int, Post>>
     */
    public function getChangelogAttribute(): Collection
    {
        return $this->posts()
            ->published()
            ->orderByDesc('published_at')
            ->get(['posts.id', 'posts.title', 'posts.slug', 'posts.pillar', 'posts.published_at', 'posts.excerpt'])
            ->groupBy(fn(Post $post) => $post->pillar->value);
    }

    /**
     * Get the release notes for this version (Ecosystem posts only).
     * 
     * @return Collection<int, Post>
     */
    public function getReleaseNotesAttribute(): Collection
    {
        return $this->posts()
            ->published()
            ->ofPillar(PillarType::Ecosystem)
            ->orderByDesc('published_at')
            ->get(['posts.id', 'posts.title', 'posts.slug', 'posts.published_at', 'posts.excerpt']);
    }

    /**
     * Scope to get only stable versions (exclude alpha, beta, dev, rc).
     */
    public function scopeStable(Builder $query): Builder
    {
        return $query->where(function ($q) {
            $q->where('name', 'not like', '%alpha%')
                ->where('name', 'not like', '%beta%')
                ->where('name', 'not like', '%dev%')
                ->where('name', 'not like', '%rc%');
        });
    }

    /**
     * Scope to get the latest stable version.
     */
    public function scopeLatestStable(Builder $query): Builder
    {
        // Assuming slug format is 'vXX.x' where higher number is newer
        return $query->stable()->orderByDesc('slug');
    }
}
