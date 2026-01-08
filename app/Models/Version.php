<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Version extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
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
