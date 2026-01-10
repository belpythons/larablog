<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LaraBlog // Terminal</title>
    <meta name="description"
        content="Neo-Brutalist Developer Documentation System - Laravel guides, starter kits, and UI components.">

    {{-- JetBrains Mono Font --}}
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=jetbrains-mono:400,500,600,700&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>

<body class="font-mono bg-black text-white min-h-screen flex items-center justify-center p-6">

    <div class="max-w-2xl w-full">
        {{-- Terminal Window Header --}}
        <div class="flex items-center gap-2 border-2 border-white/20 border-b-0 px-4 py-3 bg-gray-900">
            <div class="flex gap-1.5">
                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                <span class="w-3 h-3 rounded-full bg-yellow-500"></span>
                <span class="w-3 h-3 rounded-full bg-green-500"></span>
            </div>
            <span class="text-xs text-gray-500 ml-2 font-mono">larablog@dev:~</span>
        </div>

        {{-- Terminal Body --}}
        <div class="border-2 border-white/20 p-6 sm:p-8 bg-gray-950">
            {{-- ASCII Art Logo --}}
            <pre class="text-brutal-green text-[10px] sm:text-xs mb-8 overflow-x-auto leading-tight">
 _                     ____  _             
| |    __ _ _ __ __ _ | __ )| | ___   __ _ 
| |   / _` | '__/ _` ||  _ \| |/ _ \ / _` |
| |__| (_| | | | (_| || |_) | | (_) | (_| |
|_____\__,_|_|  \__,_||____/|_|\___/ \__, |
                                     |___/ 
            </pre>

            {{-- System Information --}}
            <div class="space-y-3 text-sm mb-10">
                <div>
                    <span class="text-brutal-yellow">$</span> whoami
                </div>
                <div class="pl-4 text-gray-400">
                    // Developer Documentation System v2.0
                </div>

                <div class="mt-4">
                    <span class="text-brutal-yellow">$</span> ls -la /system/stats/
                </div>
                <div class="pl-4 text-gray-400 space-y-1">
                    <div>drwxr-xr-x articles <span class="text-white">{{ \App\Models\Post::count() }}</span></div>
                    <div>drwxr-xr-x stacks <span class="text-white">{{ \App\Models\TechStack::count() }}</span></div>
                    <div>drwxr-xr-x versions <span class="text-white">{{ \App\Models\Version::count() }}</span></div>
                </div>
            </div>

            {{-- Navigation Commands --}}
            <div class="space-y-2 text-sm mb-8 border-t border-white/10 pt-6">
                <div class="text-gray-500 text-xs uppercase tracking-widest mb-3">// AVAILABLE_COMMANDS</div>

                <a href="{{ route('blog.index') }}" wire:navigate
                    class="flex items-center gap-3 py-2 hover:bg-white/5 -mx-2 px-2 transition-colors group">
                    <span class="text-brutal-yellow">$</span>
                    <span class="text-gray-400 group-hover:text-white">cd /docs && ls</span>
                    <span class="text-gray-600 text-xs ml-auto"># browse documentation</span>
                </a>

                @php
                    $latestVersion = \App\Models\Version::stable()->orderByDesc('slug')->first();
                @endphp
                @if($latestVersion)
                    <a href="{{ route('docs.changelog', $latestVersion->slug) }}" wire:navigate
                        class="flex items-center gap-3 py-2 hover:bg-white/5 -mx-2 px-2 transition-colors group">
                        <span class="text-brutal-yellow">$</span>
                        <span class="text-gray-400 group-hover:text-white">cat CHANGELOG.md</span>
                        <span class="text-gray-600 text-xs ml-auto"># {{ $latestVersion->name }} release notes</span>
                    </a>
                @endif

                <a href="/admin"
                    class="flex items-center gap-3 py-2 hover:bg-white/5 -mx-2 px-2 transition-colors group">
                    <span class="text-brutal-yellow">$</span>
                    <span class="text-gray-400 group-hover:text-white">sudo -i</span>
                    <span class="text-gray-600 text-xs ml-auto"># admin access</span>
                </a>
            </div>

            {{-- CTA Buttons --}}
            <div class="space-y-3">
                <a href="{{ route('blog.index') }}" wire:navigate class="block w-full px-6 py-4 border-2 border-brutal-green text-brutal-green 
                          hover:bg-brutal-green hover:text-black transition-colors text-center font-bold
                          uppercase tracking-wider">
                    [ ENTER SYSTEM ] →
                </a>
                @if($latestVersion)
                    <a href="{{ route('docs.changelog', $latestVersion->slug) }}" wire:navigate class="block w-full px-6 py-4 border-2 border-brutal-yellow text-brutal-yellow
                                  hover:bg-brutal-yellow hover:text-black transition-colors text-center
                                  uppercase tracking-wider">
                        [ $ cat CHANGELOG.md ] {{ $latestVersion->name }}
                    </a>
                @endif
                <a href="/admin" class="block w-full px-6 py-4 border-2 border-white/30 text-gray-400
                          hover:border-white hover:text-white transition-colors text-center
                          uppercase tracking-wider">
                    [ ADMIN ACCESS ]
                </a>
            </div>

            {{-- Recent Commits (Posts) --}}
            <div class="mt-10 pt-6 border-t border-white/10">
                <p class="text-xs text-gray-500 mb-4 uppercase tracking-widest">// RECENT_COMMITS</p>
                @foreach(\App\Models\Post::published()->latest('published_at')->take(3)->get() as $post)
                    <a href="{{ route('docs.show', ['version' => 'v11.x', 'category' => $post->pillar->value, 'slug' => $post->slug]) }}"
                        wire:navigate
                        class="flex items-start gap-3 py-2 text-sm hover:bg-white/5 -mx-2 px-2 transition-colors group">
                        <span class="text-brutal-yellow shrink-0">*</span>
                        <span class="text-brutal-green shrink-0">{{ $post->published_at?->format('Y-m-d') }}</span>
                        <span class="text-gray-400 truncate group-hover:text-white transition-colors">
                            {{ Str::limit($post->title, 40) }}
                        </span>
                    </a>
                @endforeach
            </div>

            {{-- Version List Link --}}
            <div class="mt-6 pt-4 border-t border-white/10">
                <a href="{{ route('blog.index') }}" wire:navigate
                    class="flex items-center justify-between text-xs text-gray-500 hover:text-white transition-colors">
                    <span>// ALL_VERSIONS</span>
                    <span class="flex items-center gap-2">
                        @foreach(\App\Models\Version::stable()->orderByDesc('slug')->take(3)->get() as $v)
                            <span
                                class="px-2 py-0.5 border border-gray-700 hover:border-brutal-yellow hover:text-brutal-yellow">
                                {{ $v->name }}
                            </span>
                        @endforeach
                    </span>
                </a>
            </div>

            {{-- Keyboard Shortcut Hint --}}
            <div class="mt-8 pt-4 border-t border-white/10 text-center">
                <p class="text-xs text-gray-600">
                    <kbd class="px-2 py-1 bg-white/10 border border-white/20 text-gray-400">Ctrl+K</kbd>
                    quick search
                    <span class="mx-2 text-gray-700">|</span>
                    <kbd class="px-2 py-1 bg-white/10 border border-white/20 text-gray-400">Shift + ?</kbd>
                    help
                </p>
            </div>
        </div>

        {{-- Footer Credit --}}
        <div class="mt-4 text-center text-xs text-gray-600">
            <p>// Built with Laravel × Livewire × Tailwind</p>
        </div>
    </div>

    @livewireScripts
</body>

</html>