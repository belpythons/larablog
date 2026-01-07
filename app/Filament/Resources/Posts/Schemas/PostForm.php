<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PostForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Tabs::make('Post Editor')
                    ->tabs([
                        // Tab 1: Content
                        Tabs\Tab::make('Content')->schema([
                            TextInput::make('title')
                                ->required()
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(Set $set, $state) => $set('slug', Str::slug($state))),

                            TextInput::make('slug')
                                ->required()
                                ->unique(ignoreRecord: true),

                            Select::make('pillar')
                                ->options([
                                    'ecosystem' => 'Ecosystem (Decision Making)',
                                    'starter_kit' => 'Starter Kit (How-to)',
                                    'bricks' => 'The Bricks (Components)',
                                ])
                                ->required()
                                ->live(),

                            // Split View Logic
                            Section::make('Theory (The Why)')
                                ->description('Conceptual documentation, pros/cons, decision matrices')
                                ->schema([
                                    RichEditor::make('content_theory')
                                        ->toolbarButtons(['bold', 'italic', 'link', 'bulletList', 'orderedList', 'h2', 'h3', 'blockquote', 'codeBlock']),
                                ]),

                            Section::make('Technical (The How)')
                                ->description('Code blocks, terminal commands, installation steps')
                                ->schema([
                                    MarkdownEditor::make('content_technical'),
                                ]),
                        ]),

                        // Tab 2: Troubleshooting
                        Tabs\Tab::make('Troubleshooting')->schema([
                            Repeater::make('troubleshooting')
                                ->schema([
                                    TextInput::make('error_message')
                                        ->label('Error Message / Symptom')
                                        ->required(),
                                    Textarea::make('solution')
                                        ->label('Solution / Context')
                                        ->required()
                                        ->rows(3),
                                ])
                                ->columns(2)
                                ->addActionLabel('Add Error Scenario')
                        ]),

                        // Tab 3: Bricks (Conditional)
                        Tabs\Tab::make('Bricks')
                            ->visible(fn(Get $get) => $get('pillar') === 'bricks')
                            ->schema([
                                Select::make('component_id')
                                    ->label('Linked Component')
                                    ->relationship('component', 'name')
                                    ->createOptionForm([
                                        TextInput::make('name')->required(),
                                        TextInput::make('class_name')->placeholder('App\View\Components\Alert'),
                                        Textarea::make('blade_snippet')->rows(5),
                                        Textarea::make('preview_html')->rows(5),
                                    ])
                                    ->searchable()
                                    ->preload(),
                            ]),
                    ])->columnSpan(2),

                // Sidebar
                Group::make()
                    ->schema([
                        Section::make('Publishing')
                            ->schema([
                                DateTimePicker::make('published_at'),

                                CheckboxList::make('techStacks')
                                    ->relationship('techStacks', 'name')
                                    ->columns(1),

                                CheckboxList::make('versions')
                                    ->relationship('versions', 'name')
                                    ->columns(1),

                                // Hidden User ID (auto-assign in Controller/Observer usually, but valid here if managed)
                                Select::make('user_id')
                                    ->relationship('author', 'name')
                                    ->searchable()
                                    ->required()
                                    ->default(fn() => auth()->id()),
                            ])
                    ])->columnSpan(1),
            ])->columns(3);
    }
}
