<?php

namespace App\Models;

use App\Enums\PillarType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'troubleshooting' => 'array',
        'published_at' => 'datetime',
        'pillar' => PillarType::class,
    ];

    // =========== RELATIONSHIPS ===========

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function component(): BelongsTo
    {
        return $this->belongsTo(Component::class);
    }

    public function techStacks(): BelongsToMany
    {
        return $this->belongsToMany(TechStack::class);
    }

    public function versions(): BelongsToMany
    {
        return $this->belongsToMany(Version::class);
    }

    // =========== SCOPES ===========

    /**
     * Scope to get only published posts.
     */
    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    /**
     * Scope to filter posts by pillar type.
     */
    public function scopeOfPillar(Builder $query, string|PillarType $pillar): Builder
    {
        $value = $pillar instanceof PillarType ? $pillar->value : $pillar;
        return $query->where('pillar', $value);
    }

    /**
     * Scope to filter posts by a specific version.
     */
    public function scopeForVersion(Builder $query, Version $version): Builder
    {
        return $query->whereHas('versions', fn($q) => $q->where('versions.id', $version->id));
    }
}
