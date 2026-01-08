<?php

namespace Database\Seeders;

use App\Enums\PillarType;
use App\Models\Component;
use App\Models\Post;
use App\Models\TechStack;
use App\Models\User;
use App\Models\Version;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin user
        $user = User::firstOrCreate(
            ['email' => 'admin@larablog.com'],
            ['name' => 'LaraBlog Admin', 'password' => bcrypt('password')]
        );

        // Step A: Seed Tech Stacks
        $stacks = $this->seedTechStacks();

        // Step B: Seed Versions
        $versions = $this->seedVersions();

        // Step C: Seed Posts
        $this->seedPosts($user, $stacks, $versions);
    }

    protected function seedTechStacks(): array
    {
        $techStacks = [
            ['name' => 'Laravel', 'slug' => 'laravel', 'type' => 'framework', 'website_url' => 'https://laravel.com/docs/11.x'],
            ['name' => 'Livewire', 'slug' => 'livewire', 'type' => 'library', 'website_url' => 'https://livewire.laravel.com/docs'],
            ['name' => 'Inertia.js', 'slug' => 'inertiajs', 'type' => 'library', 'website_url' => 'https://inertiajs.com'],
            ['name' => 'Vue.js', 'slug' => 'vuejs', 'type' => 'library', 'website_url' => 'https://vuejs.org/guide'],
            ['name' => 'React', 'slug' => 'react', 'type' => 'library', 'website_url' => 'https://react.dev'],
            ['name' => 'Tailwind CSS', 'slug' => 'tailwindcss', 'type' => 'ui_kit', 'website_url' => 'https://tailwindcss.com/docs'],
            ['name' => 'Alpine.js', 'slug' => 'alpinejs', 'type' => 'library', 'website_url' => 'https://alpinejs.dev/start-here'],
            ['name' => 'Bootstrap', 'slug' => 'bootstrap', 'type' => 'ui_kit', 'website_url' => 'https://getbootstrap.com/docs'],
            ['name' => 'FilamentPHP', 'slug' => 'filament', 'type' => 'library', 'website_url' => 'https://filamentphp.com/docs'],
            ['name' => 'Spatie Permissions', 'slug' => 'spatie-permissions', 'type' => 'library', 'website_url' => 'https://spatie.be/docs/laravel-permission'],
            ['name' => 'Pest PHP', 'slug' => 'pest', 'type' => 'library', 'website_url' => 'https://pestphp.com/docs'],
        ];

        $result = [];
        foreach ($techStacks as $stack) {
            $result[$stack['slug']] = TechStack::updateOrCreate(
                ['slug' => $stack['slug']],
                $stack
            );
        }
        return $result;
    }

    protected function seedVersions(): array
    {
        return [
            'v10' => Version::updateOrCreate(['slug' => 'v10.x'], ['name' => 'v10.x (LTS)']),
            'v11' => Version::updateOrCreate(['slug' => 'v11.x'], ['name' => 'v11.x (Stable)']),
        ];
    }

    protected function seedPosts(User $user, array $stacks, array $versions): void
    {
        $posts = $this->getPostDefinitions();

        foreach ($posts as $postData) {
            $post = Post::updateOrCreate(
                ['slug' => $postData['slug']],
                [
                    'user_id' => $user->id,
                    'title' => $postData['title'],
                    'slug' => $postData['slug'],
                    'pillar' => $postData['pillar'],
                    'excerpt' => $postData['excerpt'],
                    'content_theory' => $postData['content_theory'],
                    'content_technical' => $postData['content_technical'],
                    'troubleshooting' => $postData['troubleshooting'],
                    'published_at' => now()->subDays(rand(1, 30)),
                    'component_id' => null,
                ]
            );

            // Attach versions
            $post->versions()->sync([$versions['v10']->id, $versions['v11']->id]);

            // Attach tech stacks
            $stackIds = collect($postData['stacks'])
                ->map(fn($slug) => $stacks[$slug]->id ?? null)
                ->filter()
                ->toArray();
            $post->techStacks()->sync($stackIds);

            // Handle Bricks: Create Component
            if ($postData['pillar'] === 'bricks' && isset($postData['component'])) {
                $component = Component::updateOrCreate(
                    ['name' => $postData['component']['name']],
                    $postData['component']
                );
                $post->update(['component_id' => $component->id]);
            }
        }
    }

    protected function getPostDefinitions(): array
    {
        return [
            // ========== ECOSYSTEM POSTS (8) ==========
            [
                'title' => 'Understanding Laravel Service Container',
                'slug' => 'laravel-service-container',
                'pillar' => 'ecosystem',
                'excerpt' => 'Master dependency injection and the IoC container in Laravel.',
                'stacks' => ['laravel'],
                'content_theory' => "## The Heart of Laravel\n\nThe Service Container is Laravel's powerful tool for managing class dependencies and performing dependency injection. It binds interfaces to implementations and resolves complex dependency graphs automatically.\n\nFor comprehensive details, please refer to the [Official Laravel Container Documentation](https://laravel.com/docs/11.x/container).",
                'content_technical' => "```php\n// Binding in a Service Provider\n\$this->app->bind(PaymentGateway::class, StripePaymentGateway::class);\n\n// Resolving from the container\n\$gateway = app(PaymentGateway::class);\n\n// Automatic injection in controllers\npublic function __construct(PaymentGateway \$gateway)\n{\n    \$this->gateway = \$gateway;\n}\n```",
                'troubleshooting' => [
                    ['error_message' => 'Target class [App\\Services\\MyService] does not exist.', 'solution' => 'Run `composer dump-autoload` and ensure the class file path matches the namespace.'],
                    ['error_message' => 'Unresolvable dependency resolving [Parameter #0].', 'solution' => 'Bind the interface to a concrete class in a Service Provider.'],
                ],
            ],
            [
                'title' => 'Livewire Form Objects: Clean Form Handling',
                'slug' => 'livewire-form-objects',
                'pillar' => 'ecosystem',
                'excerpt' => 'Organize your Livewire forms with dedicated Form Objects.',
                'stacks' => ['livewire', 'laravel'],
                'content_theory' => "## Why Form Objects?\n\nForm Objects in Livewire v3 help you organize form logic into dedicated classes, keeping your components lean and testable. They encapsulate validation rules, form data, and reset logic.\n\nFor comprehensive details, please refer to the [Official Livewire Form Objects Documentation](https://livewire.laravel.com/docs/forms).",
                'content_technical' => "```php\n// app/Livewire/Forms/ContactForm.php\nclass ContactForm extends Form\n{\n    #[Validate('required|min:3')]\n    public string \$name = '';\n\n    #[Validate('required|email')]\n    public string \$email = '';\n\n    public function submit()\n    {\n        \$this->validate();\n        Contact::create(\$this->all());\n        \$this->reset();\n    }\n}\n```",
                'troubleshooting' => [
                    ['error_message' => 'Property [$form] not found on component.', 'solution' => 'Initialize the form property: `public ContactForm $form;`'],
                    ['error_message' => 'Validation rules not applying.', 'solution' => 'Ensure you use the #[Validate] attribute on each property.'],
                ],
            ],
            [
                'title' => 'Inertia.js Shared Data: Global Props',
                'slug' => 'inertiajs-shared-data',
                'pillar' => 'ecosystem',
                'excerpt' => 'Share data globally across all Inertia pages.',
                'stacks' => ['inertiajs', 'laravel', 'vuejs'],
                'content_theory' => "## Sharing Data Globally\n\nInertia allows you to share data that should be available on every page, like the authenticated user or flash messages. This is done via middleware.\n\nFor comprehensive details, please refer to the [Official Inertia.js Shared Data Documentation](https://inertiajs.com/shared-data).",
                'content_technical' => "```php\n// app/Http/Middleware/HandleInertiaRequests.php\npublic function share(Request \$request): array\n{\n    return array_merge(parent::share(\$request), [\n        'auth' => [\n            'user' => \$request->user(),\n        ],\n        'flash' => [\n            'message' => session('message'),\n        ],\n    ]);\n}\n```",
                'troubleshooting' => [
                    ['error_message' => 'usePage() returns undefined in Vue component.', 'solution' => 'Import from @inertiajs/vue3: `import { usePage } from "@inertiajs/vue3"`'],
                    ['error_message' => 'Shared data not updating after navigation.', 'solution' => 'Ensure the data is evaluated lazily using a closure if it changes per request.'],
                ],
            ],
            [
                'title' => 'Filament Table Columns: Complete Guide',
                'slug' => 'filament-table-columns',
                'pillar' => 'ecosystem',
                'excerpt' => 'Master Filament table columns for powerful admin interfaces.',
                'stacks' => ['filament', 'laravel'],
                'content_theory' => "## Building Rich Tables\n\nFilament's Table Builder provides a fluent API for creating powerful, feature-rich tables. Columns can display text, badges, images, and even custom views.\n\nFor comprehensive details, please refer to the [Official Filament Table Columns Documentation](https://filamentphp.com/docs/tables/columns).",
                'content_technical' => "```php\nuse Filament\\Tables\\Columns\\TextColumn;\nuse Filament\\Tables\\Columns\\BadgeColumn;\n\npublic static function table(Table \$table): Table\n{\n    return \$table->columns([\n        TextColumn::make('name')->searchable()->sortable(),\n        TextColumn::make('email')->copyable(),\n        BadgeColumn::make('status')\n            ->colors([\n                'success' => 'active',\n                'danger' => 'inactive',\n            ]),\n        TextColumn::make('created_at')->dateTime('M d, Y'),\n    ]);\n}\n```",
                'troubleshooting' => [
                    ['error_message' => 'Column [relationship.field] not displaying.', 'solution' => 'Ensure the relationship is eager-loaded in ::getEloquentQuery().'],
                    ['error_message' => 'Badge color not applying.', 'solution' => 'Check that the value matches the key in the colors array exactly.'],
                ],
            ],
            [
                'title' => 'Alpine.js Reactivity Deep Dive',
                'slug' => 'alpinejs-reactivity',
                'pillar' => 'ecosystem',
                'excerpt' => 'Understand how Alpine.js manages reactive state.',
                'stacks' => ['alpinejs'],
                'content_theory' => "## Lightweight Reactivity\n\nAlpine.js uses JavaScript proxies to create reactive data. When you declare x-data, Alpine wraps your object to track changes and update the DOM automatically.\n\nFor comprehensive details, please refer to the [Official Alpine.js Reactivity Documentation](https://alpinejs.dev/essentials/state).",
                'content_technical' => "```html\n<div x-data=\"{ count: 0, get doubled() { return this.count * 2 } }\">\n    <button @click=\"count++\">Increment</button>\n    <p>Count: <span x-text=\"count\"></span></p>\n    <p>Doubled: <span x-text=\"doubled\"></span></p>\n</div>\n```",
                'troubleshooting' => [
                    ['error_message' => 'x-data not initializing.', 'solution' => 'Ensure Alpine is loaded before DOMContentLoaded. Use defer on the script tag.'],
                    ['error_message' => 'Nested component not reacting to parent changes.', 'solution' => 'Use $store or pass data via x-bind for cross-component reactivity.'],
                ],
            ],
            [
                'title' => 'Pest PHP: Modern Testing for Laravel',
                'slug' => 'pest-php-testing',
                'pillar' => 'ecosystem',
                'excerpt' => 'Write elegant tests with Pest PHP\'s expressive syntax.',
                'stacks' => ['pest', 'laravel'],
                'content_theory' => "## Testing Made Elegant\n\nPest is a testing framework with a focus on simplicity. It brings a beautiful, expressive syntax to PHP testing while being fully compatible with PHPUnit.\n\nFor comprehensive details, please refer to the [Official Pest PHP Documentation](https://pestphp.com/docs/writing-tests).",
                'content_technical' => "```php\nuse function Pest\\Laravel\\{get, post, actingAs};\n\nit('displays the dashboard for authenticated users', function () {\n    \$user = User::factory()->create();\n\n    actingAs(\$user)\n        ->get('/dashboard')\n        ->assertOk()\n        ->assertSee('Welcome back');\n});\n\nit('validates required fields', function () {\n    post('/contact', [])\n        ->assertSessionHasErrors(['name', 'email']);\n});\n```",
                'troubleshooting' => [
                    ['error_message' => 'it() function not found.', 'solution' => 'Run `./vendor/bin/pest --init` to initialize Pest in your project.'],
                    ['error_message' => 'Database not resetting between tests.', 'solution' => 'Add `uses(RefreshDatabase::class)` at the top of your test file.'],
                ],
            ],
            [
                'title' => 'Spatie Permissions: Role-Based Access Control',
                'slug' => 'spatie-permissions-rbac',
                'pillar' => 'ecosystem',
                'excerpt' => 'Implement roles and permissions in Laravel applications.',
                'stacks' => ['spatie-permissions', 'laravel'],
                'content_theory' => "## Managing Authorization\n\nSpatie Laravel-Permission provides a simple way to manage roles and permissions. It integrates seamlessly with Laravel's gate and policy system.\n\nFor comprehensive details, please refer to the [Official Spatie Permissions Documentation](https://spatie.be/docs/laravel-permission/v6/introduction).",
                'content_technical' => "```php\nuse Spatie\\Permission\\Models\\Role;\nuse Spatie\\Permission\\Models\\Permission;\n\n// Creating roles and permissions\n\$role = Role::create(['name' => 'admin']);\n\$permission = Permission::create(['name' => 'edit articles']);\n\n// Assigning to users\n\$user->assignRole('admin');\n\$user->givePermissionTo('edit articles');\n\n// Checking permissions\nif (\$user->can('edit articles')) {\n    // authorized\n}\n```",
                'troubleshooting' => [
                    ['error_message' => 'There is no permission named `X` for guard `web`.', 'solution' => 'Create the permission first: `Permission::create([\'name\' => \'X\']);`'],
                    ['error_message' => 'User does not have permission after assignment.', 'solution' => 'Clear the permission cache: `php artisan permission:cache-reset`'],
                ],
            ],
            [
                'title' => 'Vue 3 Composition API with Laravel',
                'slug' => 'vue3-composition-api',
                'pillar' => 'ecosystem',
                'excerpt' => 'Build reactive components using Vue 3 Composition API.',
                'stacks' => ['vuejs', 'laravel', 'inertiajs'],
                'content_theory' => "## The Modern Vue Way\n\nThe Composition API provides a set of additive, function-based APIs that allow flexible composition of component logic. It's especially powerful for complex components.\n\nFor comprehensive details, please refer to the [Official Vue 3 Composition API Documentation](https://vuejs.org/guide/extras/composition-api-faq.html).",
                'content_technical' => "```vue\n<script setup>\nimport { ref, computed, onMounted } from 'vue'\nimport { usePage } from '@inertiajs/vue3'\n\nconst count = ref(0)\nconst doubled = computed(() => count.value * 2)\nconst { props } = usePage()\n\nonMounted(() => {\n  console.log('User:', props.auth.user)\n})\n</script>\n\n<template>\n  <button @click=\"count++\">Count: {{ count }}</button>\n  <p>Doubled: {{ doubled }}</p>\n</template>\n```",
                'troubleshooting' => [
                    ['error_message' => 'ref is not defined.', 'solution' => 'Import ref from vue: `import { ref } from \'vue\'`'],
                    ['error_message' => 'Cannot read properties of undefined (reading \'value\').', 'solution' => 'Ensure you\'re accessing .value inside script setup, not in template.'],
                ],
            ],

            // ========== STARTER KIT POSTS (8) ==========
            [
                'title' => 'Setting Up Laravel Breeze with Vue',
                'slug' => 'laravel-breeze-vue',
                'pillar' => 'starter_kit',
                'excerpt' => 'Get started with Laravel Breeze and Vue.js SPA.',
                'stacks' => ['laravel', 'vuejs', 'inertiajs', 'tailwindcss'],
                'content_theory' => "## Breeze + Vue: The Perfect Starter\n\nLaravel Breeze provides a minimal, simple implementation of authentication features including login, registration, and password reset. With the Vue stack, you get a full SPA experience.\n\nFor comprehensive details, please refer to the [Official Laravel Breeze Documentation](https://laravel.com/docs/11.x/starter-kits#laravel-breeze).",
                'content_technical' => "```bash\n# Create new Laravel project\nlaravel new my-app\ncd my-app\n\n# Install Breeze with Vue + Inertia\ncomposer require laravel/breeze --dev\nphp artisan breeze:install vue\n\n# Install dependencies and build\nnpm install\nnpm run dev\n\n# Run migrations\nphp artisan migrate\n```",
                'troubleshooting' => [
                    ['error_message' => 'Route [login] not defined.', 'solution' => 'Clear route cache: `php artisan route:clear` and ensure Breeze routes are published.'],
                    ['error_message' => 'Vite manifest not found.', 'solution' => 'Run `npm run build` or ensure `npm run dev` is running for development.'],
                ],
            ],
            [
                'title' => 'Laravel Breeze with React & TypeScript',
                'slug' => 'laravel-breeze-react-typescript',
                'pillar' => 'starter_kit',
                'excerpt' => 'Build type-safe React applications with Laravel.',
                'stacks' => ['laravel', 'react', 'inertiajs', 'tailwindcss'],
                'content_theory' => "## React + TypeScript Stack\n\nFor developers who prefer React, Breeze offers a React stack with optional TypeScript support. This combination provides excellent type safety and developer experience.\n\nFor comprehensive details, please refer to the [Official Laravel Breeze Documentation](https://laravel.com/docs/11.x/starter-kits#breeze-and-inertia).",
                'content_technical' => "```bash\n# Install Breeze with React and TypeScript\nphp artisan breeze:install react --typescript\n\n# Your components will be in resources/js/Pages\n# Types are auto-generated in resources/js/types\n\nnpm install\nnpm run dev\n```\n\n```tsx\n// resources/js/Pages/Dashboard.tsx\nimport AuthenticatedLayout from '@/Layouts/AuthenticatedLayout';\nimport { PageProps } from '@/types';\n\nexport default function Dashboard({ auth }: PageProps) {\n    return (\n        <AuthenticatedLayout user={auth.user}>\n            <h1>Welcome, {auth.user.name}!</h1>\n        </AuthenticatedLayout>\n    );\n}\n```",
                'troubleshooting' => [
                    ['error_message' => 'Cannot find module \'@/types\'.', 'solution' => 'Ensure tsconfig.json has path aliases configured correctly.'],
                    ['error_message' => 'Property does not exist on type PageProps.', 'solution' => 'Update resources/js/types/index.d.ts with your custom props.'],
                ],
            ],
            [
                'title' => 'Livewire Volt: Single-File Components',
                'slug' => 'livewire-volt',
                'pillar' => 'starter_kit',
                'excerpt' => 'Write Livewire components in a single Blade file.',
                'stacks' => ['livewire', 'laravel'],
                'content_theory' => "## Volt: The Future of Livewire\n\nVolt allows you to write your Livewire component logic directly in your Blade files, similar to Vue's single-file components. It's perfect for rapid development.\n\nFor comprehensive details, please refer to the [Official Livewire Volt Documentation](https://livewire.laravel.com/docs/volt).",
                'content_technical' => "```php\n<?php\n// resources/views/livewire/counter.blade.php\n\nuse function Livewire\\Volt\\{state};\n\nstate(['count' => 0]);\n\n\$increment = fn () => \$this->count++;\n?>\n\n<div>\n    <h1>{{ \$count }}</h1>\n    <button wire:click=\"increment\">+</button>\n</div>\n```",
                'troubleshooting' => [
                    ['error_message' => 'Call to undefined function Livewire\\Volt\\state().', 'solution' => 'Install Volt: `composer require livewire/volt` and register the service provider.'],
                    ['error_message' => 'Component not found.', 'solution' => 'Ensure your Volt components are in resources/views/livewire directory.'],
                ],
            ],
            [
                'title' => 'Filament Admin Panel Setup',
                'slug' => 'filament-admin-setup',
                'pillar' => 'starter_kit',
                'excerpt' => 'Install and configure FilamentPHP for your Laravel app.',
                'stacks' => ['filament', 'laravel', 'tailwindcss'],
                'content_theory' => "## The Ultimate Admin Panel\n\nFilament is a collection of beautiful full-stack components for Laravel. The admin panel is its flagship product, providing resources, forms, tables, and widgets out of the box.\n\nFor comprehensive details, please refer to the [Official Filament Installation Documentation](https://filamentphp.com/docs/panels/installation).",
                'content_technical' => "```bash\n# Install Filament\ncomposer require filament/filament\n\n# Install the panel\nphp artisan filament:install --panels\n\n# Create an admin user\nphp artisan make:filament-user\n\n# Generate a resource\nphp artisan make:filament-resource Post --generate\n```\n\n```php\n// Access panel at /admin\n// Customize in app/Providers/Filament/AdminPanelProvider.php\n```",
                'troubleshooting' => [
                    ['error_message' => 'Class \"Filament\\...\" not found.', 'solution' => 'Run `composer dump-autoload` and clear caches.'],
                    ['error_message' => 'Admin panel shows blank page.', 'solution' => 'Run `php artisan filament:assets` to publish assets.'],
                ],
            ],
            [
                'title' => 'Jetstream with Livewire Teams',
                'slug' => 'jetstream-livewire-teams',
                'pillar' => 'starter_kit',
                'excerpt' => 'Build multi-tenant apps with Laravel Jetstream.',
                'stacks' => ['laravel', 'livewire', 'tailwindcss'],
                'content_theory' => "## Enterprise-Ready Authentication\n\nJetstream provides robust authentication features including two-factor auth, session management, API tokens, and optional team management for multi-tenant applications.\n\nFor comprehensive details, please refer to the [Official Laravel Jetstream Documentation](https://jetstream.laravel.com/introduction.html).",
                'content_technical' => "```bash\n# Install Jetstream with Livewire and Teams\ncomposer require laravel/jetstream\nphp artisan jetstream:install livewire --teams\n\nnpm install && npm run build\nphp artisan migrate\n```\n\n```php\n// Access current team\n\$user->currentTeam;\n\n// Check team permissions\n\$user->hasTeamPermission(\$team, 'create');\n\n// Switch teams\n\$user->switchTeam(\$team);\n```",
                'troubleshooting' => [
                    ['error_message' => 'team_user table not found.', 'solution' => 'Ensure you ran migrations after installing with --teams flag.'],
                    ['error_message' => 'Cannot switch to team.', 'solution' => 'Verify the user belongs to the team: `$user->belongsToTeam($team)`'],
                ],
            ],
            [
                'title' => 'Laravel Sail: Docker Development',
                'slug' => 'laravel-sail-docker',
                'pillar' => 'starter_kit',
                'excerpt' => 'Set up a Docker development environment with Sail.',
                'stacks' => ['laravel'],
                'content_theory' => "## Docker Made Simple\n\nLaravel Sail is a light-weight command-line interface for interacting with Laravel's default Docker development environment. It requires no prior Docker experience.\n\nFor comprehensive details, please refer to the [Official Laravel Sail Documentation](https://laravel.com/docs/11.x/sail).",
                'content_technical' => "```bash\n# Install Sail in existing project\ncomposer require laravel/sail --dev\nphp artisan sail:install\n\n# Start the containers\n./vendor/bin/sail up -d\n\n# Run artisan commands\n./vendor/bin/sail artisan migrate\n\n# Run npm commands\n./vendor/bin/sail npm install\n./vendor/bin/sail npm run dev\n\n# Stop containers\n./vendor/bin/sail down\n```",
                'troubleshooting' => [
                    ['error_message' => 'Port 80 is already in use.', 'solution' => 'Change APP_PORT in .env or stop the conflicting service.'],
                    ['error_message' => 'sail: command not found.', 'solution' => 'Add alias: `alias sail=\'./vendor/bin/sail\'` to your shell profile.'],
                ],
            ],
            [
                'title' => 'API Development with Laravel Sanctum',
                'slug' => 'laravel-sanctum-api',
                'pillar' => 'starter_kit',
                'excerpt' => 'Build secure APIs with token-based authentication.',
                'stacks' => ['laravel'],
                'content_theory' => "## Simple API Authentication\n\nSanctum provides a lightweight authentication system for SPAs, mobile applications, and simple token-based APIs. It's the recommended way to authenticate APIs in Laravel.\n\nFor comprehensive details, please refer to the [Official Laravel Sanctum Documentation](https://laravel.com/docs/11.x/sanctum).",
                'content_technical' => "```php\n// routes/api.php\nRoute::post('/tokens/create', function (Request \$request) {\n    \$token = \$request->user()->createToken(\$request->token_name);\n    return ['token' => \$token->plainTextToken];\n});\n\n// Protecting routes\nRoute::middleware('auth:sanctum')->get('/user', function (Request \$request) {\n    return \$request->user();\n});\n\n// Using token in requests\n// Authorization: Bearer <token>\n```",
                'troubleshooting' => [
                    ['error_message' => 'Unauthenticated on API routes.', 'solution' => 'Ensure you\'re passing the token in the Authorization header.'],
                    ['error_message' => 'CSRF token mismatch.', 'solution' => 'For SPAs, call /sanctum/csrf-cookie endpoint first.'],
                ],
            ],
            [
                'title' => 'Real-time with Laravel Reverb',
                'slug' => 'laravel-reverb-websockets',
                'pillar' => 'starter_kit',
                'excerpt' => 'Add real-time features with Laravel\'s WebSocket server.',
                'stacks' => ['laravel'],
                'content_theory' => "## Native WebSockets\n\nLaravel Reverb is a first-party WebSocket server that brings real-time communication to your Laravel applications without external dependencies like Pusher.\n\nFor comprehensive details, please refer to the [Official Laravel Reverb Documentation](https://laravel.com/docs/11.x/reverb).",
                'content_technical' => "```bash\n# Install Reverb\nphp artisan install:broadcasting\n\n# Start the WebSocket server\nphp artisan reverb:start\n```\n\n```php\n// Broadcasting an event\nevent(new OrderShipped(\$order));\n\n// In your event class\npublic function broadcastOn(): array\n{\n    return [new PrivateChannel('orders.'.\$this->order->user_id)];\n}\n```",
                'troubleshooting' => [
                    ['error_message' => 'WebSocket connection failed.', 'solution' => 'Ensure Reverb is running and VITE_REVERB_* env variables are set.'],
                    ['error_message' => 'Broadcast driver not configured.', 'solution' => 'Set BROADCAST_DRIVER=reverb in your .env file.'],
                ],
            ],

            // ========== BRICKS POSTS (9) ==========
            [
                'title' => 'Tailwind Grid Layouts Masterclass',
                'slug' => 'tailwind-grid-layouts',
                'pillar' => 'bricks',
                'excerpt' => 'Build responsive grid layouts with Tailwind CSS.',
                'stacks' => ['tailwindcss'],
                'content_theory' => "## CSS Grid with Tailwind\n\nTailwind's grid utilities make it easy to create complex, responsive grid layouts without writing custom CSS. Master grid-cols, gap, and responsive variants.\n\nFor comprehensive details, please refer to the [Official Tailwind CSS Grid Documentation](https://tailwindcss.com/docs/grid-template-columns).",
                'content_technical' => "```html\n<div class=\"grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6\">\n    <div class=\"bg-white p-6 rounded-lg shadow\">Card 1</div>\n    <div class=\"bg-white p-6 rounded-lg shadow\">Card 2</div>\n    <div class=\"bg-white p-6 rounded-lg shadow md:col-span-2\">Wide Card</div>\n    <div class=\"bg-white p-6 rounded-lg shadow\">Card 4</div>\n</div>\n```",
                'troubleshooting' => [
                    ['error_message' => 'Grid not responsive.', 'solution' => 'Use breakpoint prefixes: grid-cols-1 md:grid-cols-2 lg:grid-cols-3'],
                    ['error_message' => 'Items not spanning correctly.', 'solution' => 'Use col-span-X on child elements, not the grid container.'],
                ],
                'component' => [
                    'name' => 'Responsive Grid',
                    'class_name' => 'x-grid-layout',
                    'blade_snippet' => '<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    {{ $slot }}
</div>',
                    'preview_html' => '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:1rem;padding:1rem;"><div style="background:#e5e7eb;padding:1rem;border-radius:0.5rem;">Card 1</div><div style="background:#e5e7eb;padding:1rem;border-radius:0.5rem;">Card 2</div><div style="background:#e5e7eb;padding:1rem;border-radius:0.5rem;">Card 3</div><div style="background:#e5e7eb;padding:1rem;border-radius:0.5rem;">Card 4</div></div>',
                ],
            ],
            [
                'title' => 'Glassmorphism Card Component',
                'slug' => 'glassmorphism-card',
                'pillar' => 'bricks',
                'excerpt' => 'Create beautiful frosted glass UI effects.',
                'stacks' => ['tailwindcss'],
                'content_theory' => "## The Glass Effect\n\nGlassmorphism creates a frosted glass aesthetic using backdrop-blur and semi-transparent backgrounds. It adds depth and dimension to your interfaces.\n\nFor comprehensive details, please refer to the [Official Tailwind CSS Backdrop Blur Documentation](https://tailwindcss.com/docs/backdrop-blur).",
                'content_technical' => "```html\n<div class=\"relative\">\n    <div class=\"absolute inset-0 bg-gradient-to-r from-purple-500 to-pink-500 rounded-xl\"></div>\n    <div class=\"relative bg-white/20 backdrop-blur-lg border border-white/30 rounded-xl p-6 text-white\">\n        <h3 class=\"text-xl font-bold\">Glass Card</h3>\n        <p class=\"opacity-80\">Beautiful frosted glass effect</p>\n    </div>\n</div>\n```",
                'troubleshooting' => [
                    ['error_message' => 'Blur effect not visible.', 'solution' => 'Ensure there\'s content or color behind the element to blur.'],
                    ['error_message' => 'Performance issues.', 'solution' => 'Use backdrop-blur sparingly; it\'s GPU-intensive.'],
                ],
                'component' => [
                    'name' => 'Glass Card',
                    'class_name' => 'x-glass-card',
                    'blade_snippet' => '<div class="bg-white/20 backdrop-blur-lg border border-white/30 rounded-xl p-6">
    {{ $slot }}
</div>',
                    'preview_html' => '<div style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);padding:2rem;border-radius:1rem;"><div style="background:rgba(255,255,255,0.2);backdrop-filter:blur(10px);border:1px solid rgba(255,255,255,0.3);border-radius:0.75rem;padding:1.5rem;color:white;"><h3 style="font-weight:bold;font-size:1.25rem;">Glass Card</h3><p style="opacity:0.8;">Beautiful frosted glass effect</p></div></div>',
                ],
            ],
            [
                'title' => 'Animated Button Hover Effects',
                'slug' => 'animated-button-hover',
                'pillar' => 'bricks',
                'excerpt' => 'Create engaging button animations with Tailwind.',
                'stacks' => ['tailwindcss'],
                'content_theory' => "## Micro-Interactions\n\nButton hover effects provide visual feedback and improve user experience. Tailwind's transition utilities make animations smooth and performant.\n\nFor comprehensive details, please refer to the [Official Tailwind CSS Transition Documentation](https://tailwindcss.com/docs/transition-property).",
                'content_technical' => "```html\n<!-- Scale on hover -->\n<button class=\"px-6 py-3 bg-blue-600 text-white rounded-lg \n               transition-transform duration-200 hover:scale-105 \n               active:scale-95\">\n    Click Me\n</button>\n\n<!-- Gradient shift -->\n<button class=\"px-6 py-3 bg-gradient-to-r from-purple-600 to-pink-600 \n               text-white rounded-lg transition-all duration-300 \n               hover:from-pink-600 hover:to-purple-600\">\n    Gradient Shift\n</button>\n```",
                'troubleshooting' => [
                    ['error_message' => 'Animation feels jerky.', 'solution' => 'Use transitions on transform/opacity, not width/height.'],
                    ['error_message' => 'Hover not working on mobile.', 'solution' => 'Use @media (hover: hover) or focus states as fallback.'],
                ],
                'component' => [
                    'name' => 'Animated Button',
                    'class_name' => 'x-button-animated',
                    'blade_snippet' => '<button {{ $attributes->merge(["class" => "px-6 py-3 bg-blue-600 text-white rounded-lg transition-all duration-200 hover:scale-105 hover:shadow-lg active:scale-95"]) }}>
    {{ $slot }}
</button>',
                    'preview_html' => '<div style="padding:2rem;background:#f3f4f6;"><button style="padding:0.75rem 1.5rem;background:linear-gradient(to right,#2563eb,#7c3aed);color:white;border-radius:0.5rem;border:none;cursor:pointer;font-weight:500;box-shadow:0 4px 6px rgba(0,0,0,0.1);">Hover Me</button></div>',
                ],
            ],
            [
                'title' => 'Alpine.js Dropdown Menu',
                'slug' => 'alpinejs-dropdown-menu',
                'pillar' => 'bricks',
                'excerpt' => 'Build accessible dropdown menus with Alpine.js.',
                'stacks' => ['alpinejs', 'tailwindcss'],
                'content_theory' => "## Accessible Dropdowns\n\nDropdown menus need proper focus management and keyboard navigation. Alpine.js makes this easy with directives like x-show, x-transition, and @click.away.\n\nFor comprehensive details, please refer to the [Official Alpine.js UI Components Documentation](https://alpinejs.dev/components#dropdown).",
                'content_technical' => "```html\n<div x-data=\"{ open: false }\" class=\"relative\">\n    <button @click=\"open = !open\" \n            class=\"px-4 py-2 bg-gray-800 text-white rounded-lg\">\n        Menu\n    </button>\n    <div x-show=\"open\" \n         @click.away=\"open = false\"\n         x-transition\n         class=\"absolute mt-2 w-48 bg-white rounded-lg shadow-lg py-2\">\n        <a href=\"#\" class=\"block px-4 py-2 hover:bg-gray-100\">Profile</a>\n        <a href=\"#\" class=\"block px-4 py-2 hover:bg-gray-100\">Settings</a>\n        <a href=\"#\" class=\"block px-4 py-2 hover:bg-gray-100\">Logout</a>\n    </div>\n</div>\n```",
                'troubleshooting' => [
                    ['error_message' => 'Dropdown closes immediately.', 'solution' => 'Use @click.stop on menu items or @click.away on the container.'],
                    ['error_message' => 'Dropdown appears behind other elements.', 'solution' => 'Add z-50 or higher z-index to the dropdown.'],
                ],
                'component' => [
                    'name' => 'Dropdown Menu',
                    'class_name' => 'x-dropdown',
                    'blade_snippet' => '<div x-data="{ open: false }" class="relative">
    <button @click="open = !open" {{ $trigger->attributes }}>
        {{ $trigger }}
    </button>
    <div x-show="open" @click.away="open = false" x-transition class="absolute mt-2 w-48 bg-white rounded-lg shadow-lg py-2 z-50">
        {{ $slot }}
    </div>
</div>',
                    'preview_html' => '<div style="padding:2rem;background:#f3f4f6;position:relative;min-height:200px;"><button style="padding:0.5rem 1rem;background:#1f2937;color:white;border-radius:0.5rem;border:none;">Menu ▼</button><div style="position:absolute;top:4rem;left:2rem;width:12rem;background:white;border-radius:0.5rem;box-shadow:0 10px 15px rgba(0,0,0,0.1);padding:0.5rem 0;"><a href="#" style="display:block;padding:0.5rem 1rem;color:#374151;text-decoration:none;">Profile</a><a href="#" style="display:block;padding:0.5rem 1rem;color:#374151;text-decoration:none;">Settings</a><a href="#" style="display:block;padding:0.5rem 1rem;color:#374151;text-decoration:none;">Logout</a></div></div>',
                ],
            ],
            [
                'title' => 'Alpine.js Modal Dialog',
                'slug' => 'alpinejs-modal-dialog',
                'pillar' => 'bricks',
                'excerpt' => 'Create accessible modal dialogs with Alpine.js.',
                'stacks' => ['alpinejs', 'tailwindcss'],
                'content_theory' => "## Accessible Modals\n\nModals should trap focus, be dismissible with ESC, and prevent body scroll. Alpine.js with x-trap and @keydown.escape makes this straightforward.\n\nFor comprehensive details, please refer to the [Official Alpine.js Focus Trap Documentation](https://alpinejs.dev/plugins/focus).",
                'content_technical' => "```html\n<div x-data=\"{ open: false }\">\n    <button @click=\"open = true\">Open Modal</button>\n    \n    <div x-show=\"open\" x-cloak\n         @keydown.escape.window=\"open = false\"\n         class=\"fixed inset-0 z-50 flex items-center justify-center\">\n        <!-- Backdrop -->\n        <div class=\"absolute inset-0 bg-black/50\" @click=\"open = false\"></div>\n        <!-- Modal -->\n        <div class=\"relative bg-white rounded-xl p-6 max-w-md w-full mx-4\"\n             x-transition>\n            <h2 class=\"text-xl font-bold\">Modal Title</h2>\n            <p class=\"mt-2 text-gray-600\">Modal content here.</p>\n            <button @click=\"open = false\" class=\"mt-4 px-4 py-2 bg-blue-600 text-white rounded\">\n                Close\n            </button>\n        </div>\n    </div>\n</div>\n```",
                'troubleshooting' => [
                    ['error_message' => 'Body still scrolls when modal is open.', 'solution' => 'Add x-on:open-modal.window=\"document.body.style.overflow = \'hidden\'\".'],
                    ['error_message' => 'ESC key not closing modal.', 'solution' => 'Use @keydown.escape.window, not just @keydown.escape.'],
                ],
                'component' => [
                    'name' => 'Modal Dialog',
                    'class_name' => 'x-modal',
                    'blade_snippet' => '<div x-data="{ open: false }" x-on:open-modal.window="open = true">
    <div x-show="open" x-cloak @keydown.escape.window="open = false" class="fixed inset-0 z-50 flex items-center justify-center">
        <div class="absolute inset-0 bg-black/50" @click="open = false"></div>
        <div class="relative bg-white rounded-xl p-6 max-w-md w-full mx-4" x-transition>
            {{ $slot }}
        </div>
    </div>
</div>',
                    'preview_html' => '<div style="padding:2rem;background:#374151;border-radius:0.5rem;"><div style="background:white;border-radius:0.75rem;padding:1.5rem;max-width:24rem;margin:0 auto;box-shadow:0 25px 50px rgba(0,0,0,0.25);"><h2 style="font-weight:bold;font-size:1.25rem;margin-bottom:0.5rem;">Modal Title</h2><p style="color:#6b7280;">This is the modal content. Click outside or press ESC to close.</p><button style="margin-top:1rem;padding:0.5rem 1rem;background:#2563eb;color:white;border:none;border-radius:0.375rem;">Close</button></div></div>',
                ],
            ],
            [
                'title' => 'Tailwind Badge Components',
                'slug' => 'tailwind-badge-components',
                'pillar' => 'bricks',
                'excerpt' => 'Create colorful status badges with Tailwind.',
                'stacks' => ['tailwindcss'],
                'content_theory' => "## Status Indicators\n\nBadges are compact elements that convey status, counts, or labels. They should be visually distinct but not overwhelming.\n\nFor comprehensive details, please refer to the [Official Tailwind CSS Documentation](https://tailwindcss.com/docs/utility-first).",
                'content_technical' => "```html\n<span class=\"px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800\">\n    Active\n</span>\n<span class=\"px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800\">\n    Pending\n</span>\n<span class=\"px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800\">\n    Inactive\n</span>\n<span class=\"px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800\">\n    New\n</span>\n```",
                'troubleshooting' => [
                    ['error_message' => 'Badge colors not showing.', 'solution' => 'Ensure Tailwind is configured to include the color classes in your config.'],
                    ['error_message' => 'Badge text too small.', 'solution' => 'Increase text size with text-sm instead of text-xs.'],
                ],
                'component' => [
                    'name' => 'Status Badge',
                    'class_name' => 'x-badge',
                    'blade_snippet' => '@props(["color" => "blue"])

@php
$colors = [
    "green" => "bg-green-100 text-green-800",
    "yellow" => "bg-yellow-100 text-yellow-800",
    "red" => "bg-red-100 text-red-800",
    "blue" => "bg-blue-100 text-blue-800",
];
@endphp

<span class="px-2 py-1 text-xs font-semibold rounded-full {{ $colors[$color] }}">
    {{ $slot }}
</span>',
                    'preview_html' => '<div style="padding:1rem;display:flex;gap:0.5rem;flex-wrap:wrap;"><span style="padding:0.25rem 0.5rem;font-size:0.75rem;font-weight:600;border-radius:9999px;background:#dcfce7;color:#166534;">Active</span><span style="padding:0.25rem 0.5rem;font-size:0.75rem;font-weight:600;border-radius:9999px;background:#fef9c3;color:#854d0e;">Pending</span><span style="padding:0.25rem 0.5rem;font-size:0.75rem;font-weight:600;border-radius:9999px;background:#fee2e2;color:#991b1b;">Inactive</span><span style="padding:0.25rem 0.5rem;font-size:0.75rem;font-weight:600;border-radius:9999px;background:#dbeafe;color:#1e40af;">New</span></div>',
                ],
            ],
            [
                'title' => 'Notification Toast Component',
                'slug' => 'notification-toast',
                'pillar' => 'bricks',
                'excerpt' => 'Create stack-able notification toasts.',
                'stacks' => ['alpinejs', 'tailwindcss'],
                'content_theory' => "## Non-Blocking Notifications\n\nToast notifications inform users of events without interrupting their workflow. They should be brief, dismissible, and positioned consistently.\n\nFor comprehensive details, please refer to the [Official Alpine.js Documentation](https://alpinejs.dev/start-here).",
                'content_technical' => "```html\n<div x-data=\"{ show: true }\" x-show=\"show\" x-transition\n     class=\"fixed bottom-4 right-4 bg-green-600 text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3\">\n    <span>✓</span>\n    <span>Successfully saved!</span>\n    <button @click=\"show = false\" class=\"ml-2\">×</button>\n</div>\n```\n\n```js\n// Auto-dismiss after 3 seconds\nsetTimeout(() => show = false, 3000)\n```",
                'troubleshooting' => [
                    ['error_message' => 'Toast not appearing on top.', 'solution' => 'Add z-[100] for highest stacking context.'],
                    ['error_message' => 'Multiple toasts overlap.', 'solution' => 'Use a stack system with dynamic bottom positioning.'],
                ],
                'component' => [
                    'name' => 'Toast Notification',
                    'class_name' => 'x-toast',
                    'blade_snippet' => '@props(["type" => "success", "message" => ""])

@php
$types = [
    "success" => "bg-green-600",
    "error" => "bg-red-600",
    "warning" => "bg-yellow-600",
    "info" => "bg-blue-600",
];
@endphp

<div x-data="{ show: true }" x-show="show" x-transition
     x-init="setTimeout(() => show = false, 5000)"
     class="fixed bottom-4 right-4 {{ $types[$type] }} text-white px-6 py-3 rounded-lg shadow-lg flex items-center gap-3 z-50">
    <span>{{ $message }}</span>
    <button @click="show = false">&times;</button>
</div>',
                    'preview_html' => '<div style="background:#10b981;color:white;padding:0.75rem 1.5rem;border-radius:0.5rem;box-shadow:0 10px 15px rgba(0,0,0,0.1);display:flex;align-items:center;gap:0.75rem;"><span>✓</span><span>Successfully saved!</span><button style="margin-left:0.5rem;background:none;border:none;color:white;cursor:pointer;font-size:1.25rem;">×</button></div>',
                ],
            ],
            [
                'title' => 'Responsive Navigation Bar',
                'slug' => 'responsive-navbar',
                'pillar' => 'bricks',
                'excerpt' => 'Build a mobile-friendly navigation bar.',
                'stacks' => ['alpinejs', 'tailwindcss'],
                'content_theory' => "## Mobile-First Navigation\n\nA responsive navbar collapses into a hamburger menu on mobile devices. Alpine.js handles the toggle state while Tailwind provides responsive utilities.\n\nFor comprehensive details, please refer to the [Official Tailwind CSS Responsive Design Documentation](https://tailwindcss.com/docs/responsive-design).",
                'content_technical' => "```html\n<nav class=\"bg-white shadow\" x-data=\"{ open: false }\">\n    <div class=\"max-w-7xl mx-auto px-4\">\n        <div class=\"flex justify-between h-16\">\n            <a href=\"/\" class=\"flex items-center font-bold text-xl\">Logo</a>\n            \n            <!-- Desktop Menu -->\n            <div class=\"hidden md:flex items-center space-x-8\">\n                <a href=\"#\" class=\"text-gray-700 hover:text-blue-600\">Home</a>\n                <a href=\"#\" class=\"text-gray-700 hover:text-blue-600\">About</a>\n                <a href=\"#\" class=\"text-gray-700 hover:text-blue-600\">Contact</a>\n            </div>\n            \n            <!-- Mobile Toggle -->\n            <button @click=\"open = !open\" class=\"md:hidden p-2\">\n                <svg class=\"w-6 h-6\" fill=\"none\" stroke=\"currentColor\" viewBox=\"0 0 24 24\">\n                    <path x-show=\"!open\" d=\"M4 6h16M4 12h16M4 18h16\"/>\n                    <path x-show=\"open\" d=\"M6 18L18 6M6 6l12 12\"/>\n                </svg>\n            </button>\n        </div>\n    </div>\n    \n    <!-- Mobile Menu -->\n    <div x-show=\"open\" class=\"md:hidden\">\n        <a href=\"#\" class=\"block px-4 py-2\">Home</a>\n        <a href=\"#\" class=\"block px-4 py-2\">About</a>\n        <a href=\"#\" class=\"block px-4 py-2\">Contact</a>\n    </div>\n</nav>\n```",
                'troubleshooting' => [
                    ['error_message' => 'Menu items visible on both mobile and desktop.', 'solution' => 'Use hidden md:flex for desktop only, md:hidden for mobile only.'],
                    ['error_message' => 'Hamburger icon not toggling.', 'solution' => 'Ensure SVG paths have correct x-show bindings.'],
                ],
                'component' => [
                    'name' => 'Responsive Navbar',
                    'class_name' => 'x-navbar',
                    'blade_snippet' => '<nav class="bg-white shadow" x-data="{ open: false }">
    <div class="max-w-7xl mx-auto px-4 flex justify-between h-16">
        {{ $brand }}
        <div class="hidden md:flex items-center space-x-8">{{ $slot }}</div>
        <button @click="open = !open" class="md:hidden p-2">☰</button>
    </div>
    <div x-show="open" class="md:hidden px-4 pb-4">{{ $mobile ?? $slot }}</div>
</nav>',
                    'preview_html' => '<nav style="background:white;box-shadow:0 1px 3px rgba(0,0,0,0.1);"><div style="max-width:80rem;margin:0 auto;padding:0 1rem;display:flex;justify-content:space-between;align-items:center;height:4rem;"><span style="font-weight:bold;font-size:1.25rem;">Logo</span><div style="display:flex;gap:2rem;"><a href="#" style="color:#374151;text-decoration:none;">Home</a><a href="#" style="color:#374151;text-decoration:none;">About</a><a href="#" style="color:#374151;text-decoration:none;">Contact</a></div></div></nav>',
                ],
            ],
            [
                'title' => 'Loading Spinner Animations',
                'slug' => 'loading-spinner',
                'pillar' => 'bricks',
                'excerpt' => 'Create CSS-only loading spinners.',
                'stacks' => ['tailwindcss'],
                'content_theory' => "## Loading States\n\nSpinners indicate ongoing processes. Tailwind's animate-spin utility makes it easy to create rotating indicators without custom CSS.\n\nFor comprehensive details, please refer to the [Official Tailwind CSS Animation Documentation](https://tailwindcss.com/docs/animation).",
                'content_technical' => "```html\n<!-- Simple Spinner -->\n<svg class=\"animate-spin h-8 w-8 text-blue-600\" fill=\"none\" viewBox=\"0 0 24 24\">\n    <circle class=\"opacity-25\" cx=\"12\" cy=\"12\" r=\"10\" stroke=\"currentColor\" stroke-width=\"4\"></circle>\n    <path class=\"opacity-75\" fill=\"currentColor\" d=\"M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z\"></path>\n</svg>\n\n<!-- Dots Animation -->\n<div class=\"flex space-x-1\">\n    <div class=\"w-2 h-2 bg-blue-600 rounded-full animate-bounce\"></div>\n    <div class=\"w-2 h-2 bg-blue-600 rounded-full animate-bounce\" style=\"animation-delay: 0.1s\"></div>\n    <div class=\"w-2 h-2 bg-blue-600 rounded-full animate-bounce\" style=\"animation-delay: 0.2s\"></div>\n</div>\n```",
                'troubleshooting' => [
                    ['error_message' => 'Spinner not animating.', 'solution' => 'Ensure Tailwind\'s animation utilities are included in your config.'],
                    ['error_message' => 'Animation too fast/slow.', 'solution' => 'Customize animation duration in tailwind.config.js extend.animation.'],
                ],
                'component' => [
                    'name' => 'Loading Spinner',
                    'class_name' => 'x-spinner',
                    'blade_snippet' => '@props(["size" => "8"])

<svg class="animate-spin h-{{ $size }} w-{{ $size }} text-current" fill="none" viewBox="0 0 24 24" {{ $attributes }}>
    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
</svg>',
                    'preview_html' => '<div style="padding:2rem;display:flex;gap:2rem;align-items:center;"><svg style="animation:spin 1s linear infinite;height:2rem;width:2rem;color:#2563eb;" fill="none" viewBox="0 0 24 24"><circle style="opacity:0.25;" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path style="opacity:0.75;" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg><style>@keyframes spin{to{transform:rotate(360deg)}}</style></div>',
                ],
            ],
        ];
    }
}
