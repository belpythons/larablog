<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $version->name }} // CHANGELOG</title>
    <meta name="description" content="Changelog and release notes for {{ $version->name }}">

    {{-- JetBrains Mono - Brutalist Identity --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-mono bg-white text-black min-h-screen">

    {{-- Page Loading Bar --}}
    <x-page-loading />

    {{-- Spotlight Search --}}
    <x-spotlight-search />

    {{-- Navigation --}}
    <header class="border-b-2 border-black sticky top-0 z-50 bg-white">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                {{-- Logo --}}
                <div class="flex items-center gap-4">
                    <a href="{{ route('blog.index') }}" wire:navigate class="flex items-center gap-3 group">
                        <div class="w-10 h-10 bg-black flex items-center justify-center">
                            <span class="text-white font-bold text-lg">L</span>
                        </div>
                        <span class="font-bold text-xl hidden sm:block">LARA<span
                                class="bg-brutal-yellow px-1">BLOG</span></span>
                    </a>
                    <span class="text-gray-400">/</span>
                    <span class="font-mono text-sm uppercase tracking-wider">CHANGELOG</span>
                </div>

                {{-- Version Selector --}}
                <div class="flex items-center gap-3">
                    <select
                        class="font-mono text-sm border-2 border-black px-4 py-2 bg-white focus:outline-none focus:shadow-brutal-sm cursor-pointer"
                        onchange="window.location.href = this.value">
                        @foreach($versions as $v)
                            <option value="{{ route('docs.changelog', $v->slug) }}" {{ $v->id === $version->id ? 'selected' : '' }}>
                                {{ $v->name }}
                            </option>
                        @endforeach
                    </select>

                    {{-- Search Button --}}
                    <button @click="$dispatch('toggle-spotlight')" class="w-10 h-10 border-2 border-black flex items-center justify-center
                                   hover:bg-brutal-yellow transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </header>

    {{-- Header --}}
    <div class="border-b-2 border-black bg-gray-50">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="font-mono text-xs uppercase tracking-widest text-gray-400 mb-3">
                // GIT_LOG --oneline {{ $version->slug }}
            </div>
            <h1 class="text-3xl sm:text-4xl font-bold mb-4">
                CHANGELOG <span class="badge-brutal bg-brutal-yellow">{{ $version->name }}</span>
            </h1>
            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-500">
                @if($version->released_at)
                    <span>Released: <span class="text-black">{{ $version->released_at->format('Y-m-d') }}</span></span>
                @endif
                <span>Articles: <span class="text-black">{{ $changelog->flatten()->count() }}</span></span>
            </div>
        </div>
    </div>

    {{-- Changelog Content --}}
    <main class="py-12">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            @forelse($changelog as $pillarValue => $posts)
                @php
                    $pillarStyles = [
                        'ecosystem' => ['label' => 'ECOSYSTEM', 'bg' => 'bg-brutal-blue', 'border' => 'border-l-brutal-blue'],
                        'starter_kit' => ['label' => 'STARTER_KIT', 'bg' => 'bg-brutal-green', 'border' => 'border-l-brutal-green'],
                        'bricks' => ['label' => 'BRICKS', 'bg' => 'bg-brutal-orange', 'border' => 'border-l-brutal-orange'],
                    ];
                    $pillar = $pillarStyles[$pillarValue] ?? ['label' => strtoupper($pillarValue), 'bg' => 'bg-gray-200', 'border' => 'border-l-gray-400'];
                @endphp

                <section class="mb-12">
                    {{-- Section Header --}}
                    <div class="flex items-center gap-4 mb-6 pb-4 border-b-2 border-black">
                        <span class="badge-brutal {{ $pillar['bg'] }}">{{ $pillar['label'] }}</span>
                        <span class="font-mono text-sm text-gray-400">
                            // {{ $posts->count() }} {{ Str::plural('commit', $posts->count()) }}
                        </span>
                    </div>

                    {{-- Articles List with Smart Navigation --}}
                    <div class="space-y-0">
                        @foreach($posts as $post)
                            @php
                                // Check if post has substantial content (can be linked directly)
                                $hasContent = !empty($post->content_theory) || !empty($post->content_technical);
                                // Generate excerpt for inline display
                                $excerpt = $post->excerpt ?? Str::limit(strip_tags($post->content_theory), 200);
                            @endphp

                            <div x-data="{ expanded: false }" class="border-l-4 {{ $pillar['border'] }} border-2 border-l-4 border-black mb-4 bg-white
                                                transition-all duration-200" :class="expanded ? 'shadow-brutal' : ''">

                                {{-- Header Row --}}
                                <div class="flex items-start gap-4 p-4">
                                    {{-- Commit Hash Style --}}
                                    <span class="font-mono text-xs text-brutal-purple bg-brutal-purple/10 px-2 py-1 shrink-0">
                                        {{ substr(md5($post->id), 0, 7) }}
                                    </span>

                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-bold text-black mb-1">
                                            {{ $post->title }}
                                        </h3>
                                        <time class="font-mono text-xs text-gray-400">
                                            {{ $post->published_at->format('Y-m-d') }}
                                        </time>
                                    </div>

                                    {{-- Action Buttons --}}
                                    <div class="flex items-center gap-2 shrink-0">
                                        @if($hasContent)
                                            {{-- Direct Link to Article --}}
                                            <a href="{{ route('docs.show', ['version' => $version->slug, 'category' => $pillarValue, 'slug' => $post->slug]) }}"
                                                wire:navigate class="px-3 py-1.5 border-2 border-black bg-black text-white text-xs font-bold uppercase
                                                                  hover:bg-brutal-yellow hover:text-black transition-colors">
                                                READ →
                                            </a>
                                        @endif

                                        {{-- Expand/Collapse Toggle --}}
                                        <button @click="expanded = !expanded" class="w-8 h-8 border-2 border-black flex items-center justify-center
                                                               hover:bg-gray-100 transition-colors">
                                            <svg :class="expanded ? 'rotate-180' : ''" class="w-4 h-4 transition-transform"
                                                fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </div>
                                </div>

                                {{-- Expandable Content (Inline Release Notes) --}}
                                <div x-show="expanded" x-collapse>
                                    <div class="px-4 pb-4 pt-0">
                                        <div class="bg-gray-50 border-2 border-black p-4">
                                            <p class="font-mono text-xs text-gray-500 uppercase tracking-wider mb-2">
                                                // RELEASE_NOTES
                                            </p>
                                            <p class="text-sm text-gray-700 leading-relaxed">
                                                {{ $excerpt ?: 'No description available.' }}
                                            </p>

                                            {{-- Tech Stacks --}}
                                            @if($post->techStacks->count() > 0)
                                                <div class="flex flex-wrap gap-1.5 mt-4 pt-3 border-t border-gray-200">
                                                    @foreach($post->techStacks as $stack)
                                                        <span class="badge-brutal-sm bg-gray-100">{{ $stack->name }}</span>
                                                    @endforeach
                                                </div>
                                            @endif

                                            @if($hasContent)
                                                <a href="{{ route('docs.show', ['version' => $version->slug, 'category' => $pillarValue, 'slug' => $post->slug]) }}"
                                                    wire:navigate
                                                    class="inline-flex items-center gap-2 mt-4 text-sm font-bold text-black hover:underline">
                                                    Read full documentation
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                                    </svg>
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </section>
            @empty
                <div class="card-brutal-static text-center py-16 px-8">
                    <div class="text-6xl mb-4">📋</div>
                    <h3 class="text-xl font-bold mb-2">// NO_COMMITS_FOUND</h3>
                    <p class="text-gray-500 font-mono text-sm">
                        No documentation has been published for {{ $version->name }} yet.
                    </p>
                </div>
            @endforelse
        </div>
    </main>

    {{-- Footer --}}
    <x-footer-brutal />

    @livewireScripts
</body>

</html>