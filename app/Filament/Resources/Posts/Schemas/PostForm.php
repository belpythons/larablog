<?php

namespace App\Filament\Resources\Posts\Schemas;

use Filament\Schemas\Components\Tabs;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Group;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
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
                        Tabs\Tab::make('Content')
                            ->icon('heroicon-o-document-text')
                            ->schema([
                                TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->afterStateUpdated(function ($set, $state) {
                                        $set('slug', Str::slug($state));
                                        // Auto-populate SEO title if empty
                                        $set('meta_title', $state);
                                    }),

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
                                    ->headerActions([
                                        \Filament\Forms\Components\Actions\Action::make('generate_summary')
                                            ->icon('heroicon-m-sparkles')
                                            ->label('Magic Summary')
                                            ->color('primary')
                                            ->action(function ($get, $set) {
                                                // Placeholder for AI integration
                                                // In production, this would call OpenAI/Anthropic API
                                                $content = strip_tags($get('content_theory'));
                                                $summary = Str::limit($content, 160);
                                                $set('meta_description', $summary);

                                                \Filament\Notifications\Notification::make()
                                                    ->title('AI Summary Generated')
                                                    ->success()
                                                    ->send();
                                            }),
                                    ])
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
                        Tabs\Tab::make('Troubleshooting')
                            ->icon('heroicon-o-exclamation-triangle')
                            ->schema([
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
                            ->icon('heroicon-o-cube')
                            ->visible(fn($get) => $get('pillar') === 'bricks')
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

                        // Tab 4: SEO
                        Tabs\Tab::make('SEO')
                            ->icon('heroicon-o-magnifying-glass')
                            ->schema([
                                Section::make('Search Engine Optimization')
                                    ->description('Configure meta tags for better search visibility')
                                    ->schema([
                                        TextInput::make('meta_title')
                                            ->label('Meta Title')
                                            ->maxLength(60)
                                            ->characterLimit(60)
                                            ->helperText('Recommended: 50-60 characters. Shows green if optimal.'),

                                        Textarea::make('meta_description')
                                            ->label('Meta Description')
                                            ->maxLength(160)
                                            ->characterLimit(160)
                                            ->rows(3)
                                            ->helperText('Recommended: 150-160 characters. Key for CTR.'),

                                        TextInput::make('canonical_url')
                                            ->label('Canonical URL')
                                            ->url()
                                            ->helperText('Leave empty to use default URL'),
                                    ]),

                                Section::make('Social Media')
                                    ->description('Open Graph image for social sharing')
                                    ->collapsed()
                                    ->schema([
                                        FileUpload::make('og_image')
                                            ->label('OG Image')
                                            ->image()
                                            ->directory('og-images')
                                            ->helperText('Recommended: 1200x630 pixels'),
                                    ]),
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

                                Select::make('user_id')
                                    ->label('Author')
                                    ->relationship('author', 'name')
                                    ->searchable()
                                    ->required()
                                    ->default(fn() => auth()->id()),
                            ])
                    ])->columnSpan(1),
            ])->columns(3);
    }
}
