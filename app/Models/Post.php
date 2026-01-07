<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use App\Enums\PillarType;

class Post extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'troubleshooting' => 'array',
        'published_at' => 'datetime',
        'pillar' => PillarType::class,
    ];

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
}
