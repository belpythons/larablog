<?php

namespace App\Filament\Resources\TechStacks\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class TechStackForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required()
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn($state, callable $set) => $set('slug', \Illuminate\Support\Str::slug($state))),

                TextInput::make('slug')
                    ->required()
                    ->unique(ignoreRecord: true),

                Select::make('type')
                    ->options([
                        'server' => 'Server',
                        'library' => 'Library',
                        'framework' => 'Framework',
                        'ui_kit' => 'UI Kit',
                    ])
                    ->required(),

                TextInput::make('website_url')
                    ->url()
                    ->prefixIcon('heroicon-m-globe-alt'),

                TextInput::make('icon_path'),
            ]);
    }
}
