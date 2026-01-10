@props([
    'title' => 'Documentation',
    'post' => null,
    'sidebarData' => [],
    'currentVersion' => null,
    'versions' => [],
])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }} // LaraBlog</title>
    <meta name="description" content="{{ $post?->excerpt ?? 'Developer Documentation' }}">

    {{-- JetBrains Mono - Brutalist Identity --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-mono bg-white text-black min-h-screen" x-data="{ sidebarOpen: false }">
    
    {{-- Page Loading Bar --}}
    <x-page-loading />

    {{-- Spotlight Search --}}
    <x-spotlight-search />

    {{-- Mobile Sidebar Overlay --}}
    <div x-show="sidebarOpen" x-cloak
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[100] lg:hidden">
        
        {{-- Backdrop --}}
        <div class="absolute inset-0 bg-black/50" @click="sidebarOpen = false"></div>
        
        {{-- Sidebar Content --}}
        <div class="absolute left-0 top-0 bottom-0 w-72 bg-white border-r-2 border-black overflow-y-auto"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="-translate-x-full"
             x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in duration-150"
             x-transition:leave-start="translate-x-0"
             x-transition:leave-end="-translate-x-full">
            
            {{-- Sidebar Header --}}
            <div class="flex items-center justify-between p-4 border-b-2 border-black">
                <span class="font-bold">LARA<span class="bg-brutal-yellow px-1">BLOG</span></span>
                <button @click="sidebarOpen = false" class="p-2 hover:bg-gray-100">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
            
            {{-- Navigation --}}
            <nav class="p-4 space-y-4">
                @foreach($sidebarData as $stack)
                    <div>
                        <h4 class="font-mono text-xs uppercase tracking-widest text-gray-400 mb-2">
                            // {{ strtoupper($stack['name'] ?? 'UNKNOWN') }}
                        </h4>
                        <ul class="space-y-1">
                            @foreach($stack['posts'] ?? [] as $item)
                                @php
                                    $itemUrl = route('docs.show', [
                                        'version' => $currentVersion?->slug ?? 'v11.x',
                                        'category' => $item['pillar'] ?? 'ecosystem',
                                        'slug' => $item['slug'] ?? ''
                                    ]);
                                @endphp
                                <li>
                                    <a href="{{ $itemUrl }}" wire:navigate
                                       class="block py-2 px-3 text-sm hover:bg-brutal-yellow transition-colors
                                              {{ ($post?->slug ?? '') === ($item['slug'] ?? '') ? 'bg-brutal-yellow font-bold' : '' }}">
                                        {{ $item['title'] ?? 'Untitled' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>
        </div>
    </div>

    {{-- Header --}}
    <header class="border-b-2 border-black sticky top-0 z-50 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                {{-- Left: Menu + Logo --}}
                <div class="flex items-center gap-4">
                    {{-- Mobile Menu Button --}}
                    <button @click="sidebarOpen = true" class="lg:hidden p-2 hover:bg-gray-100">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"/>
                        </svg>
                    </button>
                    
                    {{-- Logo --}}
                    <a href="{{ route('blog.index') }}" wire:navigate class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-black flex items-center justify-center">
                            <span class="text-white font-bold text-lg">L</span>
                        </div>
                        <span class="font-bold text-xl hidden sm:block">LARA<span class="bg-brutal-yellow px-1">BLOG</span></span>
                    </a>
                </div>

                {{-- Right: Version + Search --}}
                <div class="flex items-center gap-3">
                    {{-- Version Selector - Links to changelog --}}
                    @if($versions->count() > 0)
                        <select
                            class="font-mono text-sm border-2 border-black px-3 py-2 bg-white focus:outline-none focus:shadow-brutal-sm cursor-pointer hidden sm:block"
                            onchange="window.location.href = this.value">
                            @foreach($versions as $v)
                                <option value="{{ route('docs.changelog', $v->slug) }}" {{ ($currentVersion?->id ?? 0) === $v->id ? 'selected' : '' }}>
                                    {{ $v->name }}
                                </option>
                            @endforeach
                        </select>
                    @endif
                    
                    {{-- Search Button --}}
                    <button @click="$dispatch('toggle-spotlight')" 
                            class="w-10 h-10 border-2 border-black flex items-center justify-center
                                   hover:bg-brutal-yellow transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Layout --}}
    <div class="flex max-w-7xl mx-auto">
        {{-- Desktop Sidebar --}}
        <aside class="hidden lg:block w-64 shrink-0 border-r-2 border-black min-h-[calc(100vh-4rem)] sticky top-16 overflow-y-auto">
            <nav class="p-4 space-y-6">
                @foreach($sidebarData as $stack)
                    <div>
                        <h4 class="font-mono text-xs uppercase tracking-widest text-gray-400 mb-3">
                            // {{ strtoupper($stack['name'] ?? 'UNKNOWN') }}
                        </h4>
                        <ul class="space-y-1">
                            @foreach($stack['posts'] ?? [] as $item)
                                @php
                                    $itemUrl = route('docs.show', [
                                        'version' => $currentVersion?->slug ?? 'v11.x',
                                        'category' => $item['pillar'] ?? 'ecosystem',
                                        'slug' => $item['slug'] ?? ''
                                    ]);
                                @endphp
                                <li>
                                    <a href="{{ $itemUrl }}" wire:navigate
                                       class="block py-2 px-3 text-sm border-l-2 transition-colors
                                              {{ ($post?->slug ?? '') === ($item['slug'] ?? '') 
                                                  ? 'border-black bg-brutal-yellow font-bold' 
                                                  : 'border-transparent hover:border-black hover:bg-gray-50' }}">
                                        {{ $item['title'] ?? 'Untitled' }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </nav>
        </aside>

        {{-- Main Content --}}
        <main class="flex-1 min-w-0">
            {{ $slot }}
        </main>
    </div>

    {{-- Footer --}}
    <x-footer-brutal />

    @livewireScripts
    @stack('scripts')
</body>

</html>
