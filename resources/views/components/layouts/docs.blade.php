@props(['title' => 'Documentation', 'post' => null, 'sidebarData' => [], 'currentVersion' => null, 'versions' => []])

@php
    $metaDescription = $post?->excerpt ?? 'Laravel documentation and tutorials for developers.';
    $ogImage = null;

    if ($post && $post->techStacks->count() > 0) {
        $firstStack = $post->techStacks->first();
        if ($firstStack->icon_path) {
            $ogImage = asset($firstStack->icon_path);
        }
    }
    $ogImage = $ogImage ?? asset('images/og-default.png');
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- SEO Meta Tags -->
    <title>{{ $title }} - {{ config('app.name', 'LaraBlog') }}</title>
    <meta name="description" content="{{ \Illuminate\Support\Str::limit($metaDescription, 160) }}">

    <!-- Open Graph Tags -->
    <meta property="og:type" content="article">
    <meta property="og:title" content="{{ $title }}">
    <meta property="og:description" content="{{ \Illuminate\Support\Str::limit($metaDescription, 160) }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:url" content="{{ url()->current() }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Syntax Highlighting -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/github-dark.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
</head>

<body class="font-sans antialiased bg-gray-50" x-data="{ sidebarOpen: false }">

    <!-- Mobile Sidebar Overlay -->
    <div x-show="sidebarOpen" x-cloak @click="sidebarOpen = false"
        class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-40 lg:hidden"
        x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">
    </div>

    <!-- Mobile Sidebar -->
    <aside x-show="sidebarOpen" x-cloak class="fixed inset-y-0 left-0 w-72 bg-white shadow-2xl z-50 lg:hidden"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full">
        <div class="flex items-center justify-between p-4 border-b border-gray-100">
            <a href="{{ route('blog.index') }}" class="flex items-center gap-2 font-bold text-lg">
                <div
                    class="w-7 h-7 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center">
                    {{-- Heroicon: book-open --}}
                    <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <span>Lara<span class="gradient-text">Blog</span></span>
            </a>
            <button @click="sidebarOpen = false" class="p-2 rounded-lg hover:bg-gray-100 transition-colors">
                {{-- Heroicon: x-mark --}}
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
        <nav class="p-4 space-y-4 overflow-y-auto max-h-[calc(100vh-5rem)] scrollbar-thin">
            @include('partials.sidebar-nav', ['sidebarData' => $sidebarData, 'currentVersion' => $currentVersion, 'post' => $post])
        </nav>
    </aside>

    <!-- Top Navigation -->
    <nav class="fixed top-0 left-0 right-0 h-16 bg-white/80 backdrop-blur-lg border-b border-gray-100 z-30">
        <div class="h-full px-4 sm:px-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <!-- Mobile Menu Button -->
                <button @click="sidebarOpen = true"
                    class="lg:hidden p-2 -ml-2 rounded-lg hover:bg-gray-100 transition-colors">
                    {{-- Heroicon: bars-3 --}}
                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>

                <a href="{{ route('blog.index') }}" class="flex items-center gap-2 font-bold text-lg tracking-tight">
                    <div
                        class="w-8 h-8 rounded-lg bg-gradient-to-br from-blue-600 to-indigo-600 flex items-center justify-center">
                        {{-- Heroicon: book-open --}}
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <span class="hidden sm:inline">Lara<span class="gradient-text">Blog</span></span>
                </a>

                <!-- Version Switcher -->
                @if(isset($versions) && isset($currentVersion) && count($versions) > 0)
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" @click.away="open = false"
                            class="flex items-center gap-2 px-3 py-1.5 text-sm font-medium bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                            {{-- Heroicon: tag --}}
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z" />
                            </svg>
                            <span>{{ $currentVersion->name }}</span>
                            {{-- Heroicon: chevron-down --}}
                            <svg class="w-4 h-4 text-gray-400 transition-transform" :class="open ? 'rotate-180' : ''"
                                fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                            </svg>
                        </button>
                        <div x-show="open" x-cloak x-transition
                            class="absolute left-0 mt-2 w-44 bg-white rounded-xl shadow-xl border border-gray-100 py-2 z-50">
                            @foreach($versions as $v)
                                <a href="{{ route('docs.show', ['version' => $v->slug, 'category' => request()->route('category'), 'slug' => request()->route('slug')]) }}"
                                    class="flex items-center gap-2 px-4 py-2 text-sm transition-colors {{ $v->id === $currentVersion->id ? 'bg-blue-50 text-blue-700 font-medium' : 'text-gray-600 hover:bg-gray-50' }}">
                                    @if($v->id === $currentVersion->id)
                                        {{-- Heroicon: check --}}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                        </svg>
                                    @else
                                        <span class="w-4"></span>
                                    @endif
                                    {{ $v->name }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-3">
                <!-- Search Button -->
                <button @click="$dispatch('spotlight-open')"
                    class="flex items-center gap-2 px-3 py-1.5 text-sm text-gray-500 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors">
                    {{-- Heroicon: magnifying-glass --}}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <span class="hidden sm:inline">Search</span>
                    <kbd
                        class="hidden sm:inline px-1.5 py-0.5 text-xs font-mono bg-white border border-gray-200 rounded shadow-sm">⌘K</kbd>
                </button>

                <a href="{{ route('blog.index') }}"
                    class="hidden sm:flex items-center gap-1.5 text-sm text-gray-600 hover:text-gray-900 transition-colors">
                    {{-- Heroicon: home --}}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    Home
                </a>

                <a href="/admin"
                    class="flex items-center gap-1.5 text-sm text-gray-600 hover:text-gray-900 transition-colors">
                    {{-- Heroicon: cog-6-tooth --}}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.325.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.241-.438.613-.43.992a7.723 7.723 0 0 1 0 .255c-.008.378.137.75.43.991l1.004.827c.424.35.534.955.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.47 6.47 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.281c-.09.543-.56.94-1.11.94h-2.594c-.55 0-1.019-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.991a6.932 6.932 0 0 1 0-.255c.007-.38-.138-.751-.43-.992l-1.004-.827a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.086.22-.128.332-.183.582-.495.644-.869l.214-1.28Z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                    </svg>
                    <span class="hidden sm:inline">Admin</span>
                </a>
            </div>
        </div>
    </nav>

    <div class="flex pt-16">
        <!-- Desktop Sidebar -->
        <aside
            class="hidden lg:block fixed left-0 top-16 bottom-0 w-64 bg-white border-r border-gray-100 overflow-y-auto scrollbar-thin">
            <nav class="p-4 space-y-4">
                @include('partials.sidebar-nav', ['sidebarData' => $sidebarData, 'currentVersion' => $currentVersion, 'post' => $post])
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 lg:ml-64 min-h-[calc(100vh-4rem)]">
            {{ $slot }}
        </main>
    </div>

    <!-- Spotlight Search -->
    <x-spotlight-search :currentVersion="$currentVersion ?? null" />

    <script>
        document.addEventListener('DOMContentLoaded', () => hljs.highlightAll());
    </script>
</body>

</html>