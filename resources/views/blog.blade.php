<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LaraBlog - Laravel Documentation Hub</title>
    <meta name="description"
        content="Your gateway to the Laravel ecosystem. Explore documentation, tutorials, and UI components.">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans bg-gradient-to-br from-slate-50 via-white to-blue-50 min-h-screen">

    <!-- Navigation -->
    <nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-lg border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">
                    <a href="{{ route('blog.index') }}"
                        class="flex items-center gap-2 font-bold text-xl tracking-tight">
                        <div
                            class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center">
                            {{-- Heroicon: book-open --}}
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                        </div>
                        <span>Lara<span class="gradient-text">Blog</span></span>
                    </a>
                </div>

                <div class="flex items-center gap-4">
                    <a href="/admin"
                        class="text-gray-600 hover:text-gray-900 transition-colors flex items-center gap-1.5">
                        {{-- Heroicon: cog-6-tooth --}}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                        </svg>
                        <span class="hidden sm:inline">Admin</span>
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <header class="relative overflow-hidden py-16 lg:py-24">
        <div class="absolute inset-0 -z-10">
            <div class="absolute top-0 -left-48 w-96 h-96 bg-blue-200 rounded-full opacity-30 blur-3xl"></div>
            <div class="absolute bottom-0 right-0 w-80 h-80 bg-purple-200 rounded-full opacity-30 blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight mb-6 animate-fade-in">
                <span class="gradient-text">Laravel</span> Documentation Hub
            </h1>
            <p class="max-w-2xl mx-auto text-lg sm:text-xl text-gray-600 mb-8 animate-slide-up"
                style="animation-delay: 0.2s;">
                Your gateway to the Laravel ecosystem. Explore in-depth guides, starter kits, and reusable UI
                components.
            </p>

            <div class="flex flex-wrap justify-center gap-4 animate-slide-up" style="animation-delay: 0.4s;">
                <a href="#posts"
                    class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-white rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 shadow-lg shadow-blue-500/30 transform transition-all duration-200 hover:-translate-y-0.5 hover:shadow-xl">
                    {{-- Heroicon: book-open --}}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                    Browse Guides
                </a>
                <a href="/admin"
                    class="inline-flex items-center gap-2 px-6 py-3 font-semibold text-gray-700 bg-white rounded-xl border-2 border-gray-200 shadow-sm transition-all duration-200 hover:border-gray-300 hover:shadow-md hover:-translate-y-0.5">
                    {{-- Heroicon: pencil-square --}}
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                    </svg>
                    Manage Content
                </a>
            </div>
        </div>
    </header>

    <!-- Stats Section -->
    <section class="py-12 border-y border-gray-100 bg-white/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
                <div>
                    <div class="text-3xl font-bold gradient-text">{{ $posts->total() }}</div>
                    <div class="text-sm text-gray-500 mt-1">Documentation Articles</div>
                </div>
                <div>
                    <div class="text-3xl font-bold gradient-text">3</div>
                    <div class="text-sm text-gray-500 mt-1">Content Pillars</div>
                </div>
                <div>
                    <div class="text-3xl font-bold gradient-text">{{ \App\Models\TechStack::count() }}</div>
                    <div class="text-sm text-gray-500 mt-1">Tech Stacks</div>
                </div>
                <div>
                    <div class="text-3xl font-bold gradient-text">2</div>
                    <div class="text-sm text-gray-500 mt-1">Laravel Versions</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Posts Grid -->
    <section id="posts" class="py-16 lg:py-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex items-center justify-between mb-10">
                <div>
                    <h2 class="text-2xl sm:text-3xl font-bold text-gray-900">Latest Documentation</h2>
                    <p class="text-gray-500 mt-1">Explore our curated guides and tutorials</p>
                </div>
            </div>

            @if($posts->count() > 0)
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 stagger-children"
                    x-data="{ loaded: false }" x-init="setTimeout(() => loaded = true, 100)">
                    @foreach($posts as $post)
                        <article class="group card card-hover overflow-hidden flex flex-col"
                            :class="loaded ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'"
                            style="transition: all 0.5s ease {{ $loop->index * 0.1 }}s;">

                            <!-- Card Header with Pillar Badge -->
                            <div class="px-6 pt-6">
                                <div class="flex items-center gap-2 mb-3">
                                    @php
                                        $pillarColors = [
                                            'ecosystem' => 'bg-blue-100 text-blue-700 ring-blue-600/20',
                                            'starter_kit' => 'bg-emerald-100 text-emerald-700 ring-emerald-600/20',
                                            'bricks' => 'bg-amber-100 text-amber-700 ring-amber-600/20',
                                        ];
                                        $pillarIcons = [
                                            'ecosystem' => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418"/>',
                                            'starter_kit' => '<path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 18.75l-.813-2.846a4.5 4.5 0 0 0-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 0 0 3.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 0 0 3.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 0 0-3.09 3.09ZM18.259 8.715 18 9.75l-.259-1.035a3.375 3.375 0 0 0-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 0 0 2.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 0 0 2.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 0 0-2.456 2.456ZM16.894 20.567 16.5 21.75l-.394-1.183a2.25 2.25 0 0 0-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 0 0 1.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 0 0 1.423 1.423l1.183.394-1.183.394a2.25 2.25 0 0 0-1.423 1.423Z"/>',
                                            'bricks' => '<path stroke-linecap="round" stroke-linejoin="round" d="M6.429 9.75 2.25 12l4.179 2.25m0-4.5 5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0 4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0-5.571 3-5.571-3"/>',
                                        ];
                                    @endphp
                                    <span
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-semibold ring-1 ring-inset {{ $pillarColors[$post->pillar->value] ?? 'bg-gray-100 text-gray-700' }}">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            {!! $pillarIcons[$post->pillar->value] ?? '' !!}
                                        </svg>
                                        {{ $post->pillar->getLabel() }}
                                    </span>
                                </div>

                                <h3
                                    class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors line-clamp-2 mb-2">
                                    {{ $post->title }}
                                </h3>

                                <p class="text-gray-500 text-sm line-clamp-2 mb-4">
                                    {{ $post->excerpt ?? \Illuminate\Support\Str::limit(strip_tags($post->content_theory), 100) }}
                                </p>
                            </div>

                            <!-- Card Footer -->
                            <div class="mt-auto px-6 pb-6">
                                <!-- Tech Stacks -->
                                <div class="flex flex-wrap gap-1.5 mb-4">
                                    @foreach($post->techStacks->take(3) as $stack)
                                        <span class="px-2 py-0.5 text-xs font-medium bg-gray-100 text-gray-600 rounded-md">
                                            {{ $stack->name }}
                                        </span>
                                    @endforeach
                                </div>

                                <!-- Meta Info -->
                                <div
                                    class="flex items-center justify-between text-xs text-gray-400 pt-4 border-t border-gray-100">
                                    <div class="flex items-center gap-3">
                                        <span class="flex items-center gap-1">
                                            {{-- Heroicon: user --}}
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                            </svg>
                                            {{ $post->author?->name ?? 'LaraBlog' }}
                                        </span>
                                        <span class="flex items-center gap-1">
                                            {{-- Heroicon: calendar --}}
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="1.5"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            {{ $post->published_at?->format('M d, Y') }}
                                        </span>
                                    </div>

                                    <a href="{{ route('docs.show', ['version' => 'v11.x', 'category' => $post->pillar->value, 'slug' => $post->slug]) }}"
                                        class="inline-flex items-center gap-1 text-blue-600 font-medium hover:text-blue-700 transition-colors group/link">
                                        Read
                                        {{-- Heroicon: arrow-right --}}
                                        <svg class="w-4 h-4 transition-transform group-hover/link:translate-x-0.5" fill="none"
                                            stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </article>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($posts->hasPages())
                    <div class="mt-12 flex justify-center">
                        {{ $posts->links() }}
                    </div>
                @endif
            @else
                <div class="text-center py-16">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-gray-100 flex items-center justify-center">
                        {{-- Heroicon: document-text --}}
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No articles yet</h3>
                    <p class="text-gray-500">Check back soon for new documentation.</p>
                </div>
            @endif
        </div>
    </section>

    <!-- Footer -->
    <footer class="py-8 border-t border-gray-100 bg-white/50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-gray-500">
            <p>Built with ❤️ using Laravel, Tailwind CSS & FilamentPHP</p>
        </div>
    </footer>

</body>

</html>