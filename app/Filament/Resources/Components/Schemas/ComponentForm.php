<?php

namespace App\Filament\Resources\Components\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class ComponentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->required(),
                TextInput::make('class_name')
                    ->required(),
                Textarea::make('blade_snippet')
                    ->required()
                    ->columnSpanFull(),
                Textarea::make('preview_html')
                    ->required()
                    ->columnSpanFull(),
            ]);
    }
}
