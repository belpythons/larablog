<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LaraBlog // Developer Documentation Hub</title>
    <meta name="description"
        content="Neo-Brutalist developer documentation. Explore guides, starter kits, and UI components.">

    {{-- JetBrains Mono - Brutalist Identity --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-mono bg-white text-black min-h-screen" x-data>

    {{-- Page Loading Bar --}}
    <x-page-loading />

    {{-- Spotlight Search Component --}}
    <x-spotlight-search />

    {{-- Floating Action Buttons (Mobile) --}}
    <div class="fixed bottom-6 right-6 lg:hidden z-50 flex flex-col gap-3">
        {{-- Menu Button --}}
        <button @click="$dispatch('toggle-mobile-menu')" class="w-14 h-14 bg-white border-2 border-black shadow-brutal flex items-center justify-center
                   hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none
                   active:translate-x-1 active:translate-y-1
                   transition-all duration-150" aria-label="Open Menu">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
            </svg>
        </button>

        {{-- Search Button --}}
        <button @click="$dispatch('toggle-spotlight')" class="w-14 h-14 bg-black text-white shadow-brutal flex items-center justify-center
                   hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none
                   active:translate-x-1 active:translate-y-1
                   transition-all duration-150" aria-label="Open Search">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
            </svg>
        </button>
    </div>

    {{-- Minimal Header --}}
    <header class="border-b-2 border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Logo --}}
                <a href="{{ route('blog.index') }}" wire:navigate class="flex items-center gap-3 group">
                    <div class="w-10 h-10 bg-black flex items-center justify-center">
                        <span class="text-white font-bold text-lg">L</span>
                    </div>
                    <span class="font-bold text-xl tracking-tight">
                        LARA<span class="bg-brutal-yellow px-1">BLOG</span>
                    </span>
                </a>

                {{-- Actions --}}
                <div class="flex items-center gap-3">
                    {{-- Search Trigger (Desktop) --}}
                    <button @click="$dispatch('toggle-spotlight')" class="hidden lg:flex items-center gap-2 px-4 py-2 
                               border-2 border-black bg-white shadow-brutal-sm
                               hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none
                               transition-all duration-150 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        <span>SEARCH</span>
                        <kbd class="px-1.5 py-0.5 bg-gray-100 border border-gray-300 text-xs">⌘K</kbd>
                    </button>

                    {{-- Admin Link --}}
                    <a href="/admin" wire:navigate class="px-4 py-2 border-2 border-black bg-black text-white
                               shadow-brutal-sm hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none
                               transition-all duration-150 text-sm font-bold">
                        ADMIN
                    </a>
                </div>
            </div>
        </div>
    </header>

    {{-- Hero Section --}}
    <section class="py-16 lg:py-24 border-b-2 border-black">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <p class="text-sm uppercase tracking-widest text-gray-500 mb-4">// DEVELOPER_DOCS</p>
                <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight leading-tight mb-6">
                    Build better with
                    <span class="bg-brutal-yellow px-2 inline-block -rotate-1">Laravel</span>
                </h1>
                <p class="text-lg sm:text-xl text-gray-600 mb-8 leading-relaxed">
                    Curated documentation, starter kits, and reusable components.
                    No fluff, just code.
                </p>

                <div class="flex flex-wrap gap-4">
                    <a href="#posts" class="btn-brutal-primary">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                        BROWSE DOCS
                    </a>
                    <button @click="$dispatch('toggle-spotlight')" class="btn-brutal">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                        QUICK SEARCH
                    </button>
                </div>
            </div>
        </div>
    </section>

    {{-- Stats Bar --}}
    <section class="py-6 border-b-2 border-black bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap justify-between gap-6 text-center sm:text-left">
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-bold">{{ $posts->total() }}</span>
                    <span class="text-xs uppercase tracking-widest text-gray-500">// DOCS</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-bold">3</span>
                    <span class="text-xs uppercase tracking-widest text-gray-500">// PILLARS</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-bold">{{ $stats['tech_stacks_count'] }}</span>
                    <span class="text-xs uppercase tracking-widest text-gray-500">// STACKS</span>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-3xl font-bold">{{ $stats['versions_count'] }}</span>
                    <span class="text-xs uppercase tracking-widest text-gray-500">// VERSIONS</span>
                </div>
            </div>
        </div>
    </section>

    {{-- Uniform Grid Posts --}}
    <section id="posts" class="py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-12">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold">// LATEST_DOCS</h2>
                    <p class="text-gray-500 mt-1 text-sm">Curated guides & tutorials</p>
                </div>
            </div>

            @if($posts->count() > 0)
                {{-- Uniform 3-Column Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 lg:gap-10">
                    @foreach($posts as $post)
                        @php
                            // Accent colors by pillar type
                            $pillarColors = [
                                'ecosystem' => 'border-l-brutal-blue',
                                'starter_kit' => 'border-l-brutal-green',
                                'bricks' => 'border-l-brutal-orange',
                            ];
                            $borderAccent = $pillarColors[$post->pillar->value] ?? 'border-l-brutal-yellow';
                        @endphp

                        {{-- Post Card - Uniform Height --}}
                        <article class="group h-full">
                            <a href="{{ route('docs.show', ['version' => 'v11.x', 'category' => $post->pillar->value, 'slug' => $post->slug]) }}"
                               wire:navigate 
                               class="card-brutal flex flex-col h-full bg-white border-l-4 {{ $borderAccent }} 
                                      hover:translate-x-1 hover:translate-y-1 hover:shadow-none
                                      transition-all duration-150">
                                
                                <div class="p-6 flex flex-col h-full">
                                    {{-- Pillar Badge --}}
                                    <div class="text-xs uppercase tracking-widest text-gray-500 mb-3">
                                        // {{ strtoupper(str_replace('_', ' ', $post->pillar->value)) }}
                                    </div>

                                    {{-- Title --}}
                                    <h3 class="text-lg font-bold text-black group-hover:underline decoration-2 underline-offset-4 mb-3 leading-tight">
                                        {{ $post->title }}
                                    </h3>

                                    {{-- Excerpt - Flex-1 to push footer down --}}
                                    <p class="text-sm text-gray-600 line-clamp-3 flex-1 leading-relaxed mb-4">
                                        {{ $post->excerpt ?? Str::limit(strip_tags($post->content_theory), 120) }}
                                    </p>

                                    {{-- Tech Stacks --}}
                                    @if($post->techStacks->count() > 0)
                                        <div class="flex flex-wrap gap-1.5 mb-4">
                                            @foreach($post->techStacks->take(3) as $stack)
                                                <span class="badge-brutal-sm">
                                                    {{ $stack->name }}
                                                </span>
                                            @endforeach
                                            @if($post->techStacks->count() > 3)
                                                <span class="badge-brutal-sm bg-gray-100">
                                                    +{{ $post->techStacks->count() - 3 }}
                                                </span>
                                            @endif
                                        </div>
                                    @endif

                                    {{-- Meta Footer - Always at bottom --}}
                                    <div class="mt-auto pt-4 border-t-2 border-black/10 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <span class="text-xs text-gray-500">
                                                {{ $post->published_at?->format('M d, Y') }}
                                            </span>
                                            @if($post->author)
                                                <span class="text-xs text-gray-400">•</span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $post->author->name }}
                                                </span>
                                            @endif
                                        </div>
                                        <span class="text-xs font-bold group-hover:translate-x-1 transition-transform flex items-center gap-1">
                                            READ
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                            </svg>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </article>
                    @endforeach
                </div>

                {{-- Tech Stack Widget - Moved to bottom as separate section --}}
                <div class="mt-16 pt-12 border-t-2 border-black">
                    <div class="flex items-center justify-between mb-8">
                        <div>
                            <h3 class="text-xl font-bold">// TECH_STACK</h3>
                            <p class="text-gray-500 mt-1 text-sm">Technologies covered in our docs</p>
                        </div>
                    </div>
                    <div class="flex flex-wrap gap-3">
                        @foreach(\App\Models\TechStack::all() as $stack)
                            <span class="px-4 py-2 bg-black text-white border-2 border-black text-sm font-medium
                                        hover:bg-white hover:text-black transition-colors duration-150">
                                {{ $stack->name }}
                            </span>
                        @endforeach
                    </div>
                </div>

                {{-- Pagination --}}
                @if($posts->hasPages())
                    <div class="mt-16 flex justify-center">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                <div class="card-brutal-static text-center py-16 px-8">
                    <div class="text-6xl mb-4">📄</div>
                    <h3 class="text-xl font-bold mb-2">// NO_DOCS_FOUND</h3>
                    <p class="text-gray-500">Check back soon for new documentation.</p>
                </div>
            @endif
        </div>
    </section>

    {{-- Mobile Menu Overlay --}}
    <x-mobile-menu-brutal />

    {{-- Fat Footer --}}
    <x-footer-brutal />

    @livewireScripts
    @stack('scripts')
</body>

</html>