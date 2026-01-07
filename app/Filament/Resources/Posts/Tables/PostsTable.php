<?php

namespace App\Filament\Resources\Posts\Tables;

use App\Enums\PillarType;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Filters\SelectFilter;
use Illuminate\Database\Eloquent\Builder;

class PostsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query) {
                // OPTIMIZATION: Select only necessary columns to prevent loading heavy LONGTEXT fields
                // N+1 KILLER: Eager load relationships used in the table
                $query->select([
                    'id',
                    'title',
                    'slug',
                    'pillar',
                    'published_at',
                    'user_id',
                    'updated_at' // Needed for sorting usually
                ])->with(['author']);
            })
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->sortable()
                    ->limit(50),

                TextColumn::make('pillar')
                    ->badge()
                    ->sortable(),
                // Enum casting in model should handle color/label if using native Filament Enum support,
                // otherwise use ->formatStateUsing or similar if Model cast is string.
                // Ideally Model casts 'pillar' => PillarType::class

                TextColumn::make('author.name')
                    ->label('Author')
                    ->sortable(),

                TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(),

                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('pillar')
                    ->options(PillarType::class),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->bulkActions([
                // ...
            ]);
    }
}
