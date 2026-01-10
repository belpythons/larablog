<?php

namespace App\Filament\Widgets;

use App\Models\Post;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class LatestPostsWidget extends BaseWidget
{
    protected static ?int $sort = 3;
    protected int|string|array $columnSpan = 'full';

    public function getHeading(): ?string
    {
        return 'Latest Articles';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Post::query()
                    ->with(['author', 'techStacks'])
                    ->latest('published_at')
                    ->limit(5)
            )
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->limit(50)
                    ->searchable()
                    ->url(fn(Post $record) => route('filament.admin.resources.posts.edit', $record)),

                Tables\Columns\TextColumn::make('pillar')
                    ->badge(),

                Tables\Columns\TextColumn::make('author.name')
                    ->label('Author'),

                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime('M d, Y')
                    ->sortable(),
            ])
            ->paginated(false);
    }
}
