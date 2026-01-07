<?php

namespace Database\Seeders;

use App\Enums\PillarType;
use App\Models\Component;
use App\Models\Post;
use App\Models\TechStack;
use App\Models\Version;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Base User
        $user = User::firstOrCreate(
            ['email' => 'admin@larablog.com'],
            ['name' => 'Admin User', 'password' => Hash::make('password')]
        );

        // 2. Metadata (Static Data)
        $versions = [
            'v10.x' => Version::firstOrCreate(['slug' => 'v10.x'], ['name' => 'v10.x (Archived)']),
            'v11.x' => Version::firstOrCreate(['slug' => 'v11.x'], ['name' => 'v11.x (Stable)']),
        ];

        $stacks = [
            'laravel' => TechStack::firstOrCreate(['slug' => 'laravel'], ['name' => 'Laravel', 'type' => 'framework']),
            'tailwind' => TechStack::firstOrCreate(['slug' => 'tailwindcss'], ['name' => 'TailwindCSS', 'type' => 'library']),
            'livewire' => TechStack::firstOrCreate(['slug' => 'livewire'], ['name' => 'Livewire', 'type' => 'library']),
            'filament' => TechStack::firstOrCreate(['slug' => 'filament'], ['name' => 'Filament', 'type' => 'library']), // 'tool' is not in enum, using library
            'inertia' => TechStack::firstOrCreate(['slug' => 'inertia'], ['name' => 'Inertia.js', 'type' => 'library']),
        ];

        // 3. Hero Posts (The Story)

        // Post A: Ecosystem (Livewire vs Inertia)
        $postA = Post::create([
            'user_id' => $user->id,
            'title' => 'Livewire vs Inertia: Choosing Your Stack',
            'slug' => 'livewire-vs-inertia',
            'pillar' => PillarType::Ecosystem,
            'excerpt' => 'A deep dive into the server-side vs client-side rendering debate.',
            'content_theory' => "### The Philosophy\n\n**Livewire** keeps you in PHP. It's perfect for developers who want interactivity without the complexity of a JS build step.\n\n**Inertia** acts as a bridge between Laravel and Vue/React. It allows you to build a classic SPA but with the routing simplicity of a monolith.",
            'content_technical' => "```bash\n# Livewire Installation\ncomposer require livewire/livewire\n\n# Inertia Installation\ncomposer require inertiajs/inertia-laravel\nnpm install @inertiajs/vue3\n```",
            'published_at' => now(),
        ]);
        $postA->techStacks()->sync([$stacks['laravel']->id, $stacks['livewire']->id, $stacks['inertia']->id]);
        $postA->versions()->sync([$versions['v11.x']->id]);

        // Post B: Starter Kit (Breeze + Troubleshooting)
        $postB = Post::create([
            'user_id' => $user->id,
            'title' => 'Setting Up Laravel Breeze',
            'slug' => 'setting-up-breeze',
            'pillar' => PillarType::StarterKit,
            'excerpt' => 'Get started with authentication in minutes.',
            'content_theory' => "Laravel Breeze is a minimal, simple implementation of all of Laravel's authentication features.",
            'content_technical' => "```bash\ncomposer require laravel/breeze --dev\nphp artisan breeze:install\n\nphp artisan migrate\nnpm install\nnpm run dev\n```",
            'troubleshooting' => [
                [
                    'error_message' => "Route [login] not defined.",
                    'solution' => "This usually happens if routes are cached. Run `php artisan optimize:clear`."
                ]
            ],
            'published_at' => now(),
        ]);
        $postB->techStacks()->sync([$stacks['laravel']->id, $stacks['tailwind']->id]);
        $postB->versions()->sync([$versions['v11.x']->id]);

        // Post C: Bricks (Live Preview)
        $glassCard = Component::create([
            'name' => 'Glass Card',
            'class_name' => 'App\View\Components\GlassCard',
            'blade_snippet' => '<x-glass-card title="Hello World">Content</x-glass-card>',
            'preview_html' => '<script src="https://cdn.tailwindcss.com"></script><div class="p-10 bg-gradient-to-r from-purple-500 to-pink-500"><div class="bg-white/30 backdrop-blur-md p-6 rounded-xl border border-white/20 shadow-xl text-white"><h2 class="text-xl font-bold">Glassmorphism</h2><p>This is a live preview.</p></div></div>'
        ]);

        $postC = Post::create([
            'user_id' => $user->id,
            'title' => 'Glassmorphism Card',
            'slug' => 'glassmorphism-card',
            'pillar' => PillarType::Bricks,
            'excerpt' => 'Modern UI using backdrop-filter.',
            'content_theory' => "Glassmorphism establishes hierarchy through depth and transparency.",
            'content_technical' => "```css\n.glass {\n  backdrop-filter: blur(12px);\n  background: rgba(255, 255, 255, 0.3);\n}\n```",
            'component_id' => $glassCard->id,
            'published_at' => now(),
        ]);
        $postC->techStacks()->sync([$stacks['tailwind']->id]);
        $postC->versions()->sync([$versions['v11.x']->id]);
        // 4. Filler Data (15 Random Posts)
        Post::factory(15)->create([
            'user_id' => $user->id,
        ])->each(function ($post) use ($stacks, $versions) {
            // Attach random stack and version
            $post->techStacks()->attach($stacks['laravel']->id);
            $post->versions()->attach($versions['v11.x']->id);
        });
    }
}
