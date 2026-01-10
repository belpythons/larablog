<x-layouts.docs :title="$post->title" :post="$post" :sidebarData="$sidebarData" :currentVersion="$currentVersion"
    :versions="$versions">
    
    {{-- 12-Column Grid Layout --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 lg:py-12">
        <div class="grid grid-cols-12 gap-8">
            
            {{-- Main Content Area (9 cols on lg) --}}
            <div class="col-span-12 lg:col-span-9">
                
                <!-- Brutalist Breadcrumb -->
                <nav class="font-mono text-xs text-gray-500 mb-6 uppercase tracking-widest">
                    <a href="{{ route('blog.index') }}" wire:navigate
                        class="hover:bg-brutal-yellow transition-colors px-1">HOME</a>
                    <span class="mx-1">/</span>
                    <span>{{ $currentVersion->name }}</span>
                    <span class="mx-1">/</span>
                    <span>{{ strtoupper(str_replace('_', ' ', $post->pillar->value)) }}</span>
                    <span class="mx-1">/</span>
                    <span class="text-black">{{ $post->slug }}</span>
                </nav>

                <!-- Header as Commit Message -->
                <header class="border-b-2 border-black pb-6 mb-8">
                    <div class="text-xs uppercase tracking-widest text-gray-400 mb-2 font-mono">
                        // {{ strtoupper($post->pillar->value) }}/{{ $post->slug }}
                    </div>
                    <h1 class="font-mono text-2xl sm:text-3xl lg:text-4xl font-bold leading-tight mb-4 text-black">
                        {{ $post->title }}
                    </h1>

                    {{-- Brutalist Badges --}}
                    <div class="flex flex-wrap items-center gap-2 mb-4">
                        <span class="badge-brutal bg-brutal-yellow">{{ $post->pillar->getLabel() }}</span>
                        @foreach($post->techStacks as $stack)
                            <span class="badge-brutal-sm bg-gray-100">{{ $stack->name }}</span>
                        @endforeach
                        @foreach($post->versions as $v)
                            <span class="badge-brutal-sm bg-brutal-purple text-white border-brutal-purple">{{ $v->name }}</span>
                        @endforeach
                    </div>

                    {{-- Meta Information (Git-style) --}}
                    <div class="font-mono text-xs text-gray-500 space-y-1">
                        <div class="flex flex-wrap items-center gap-4">
                            <span>Author: <span class="text-black">{{ $post->author?->name ?? 'System' }}</span></span>
                            <span>Date: <span
                                    class="text-black">{{ $post->published_at?->format('Y-m-d H:i:s T') }}</span></span>
                        </div>
                        <div class="flex items-center gap-4">
                            <x-reading-progress :content="$post->content_theory . ' ' . $post->content_technical" />
                        </div>
                    </div>
                </header>

                <!-- Main Content Tabs -->
                <div x-data="{ activeTab: 'guide', mobileView: 'theory' }" class="space-y-6">

                    <!-- Brutalist Tab Buttons -->
                    <div class="flex gap-0 w-fit border-2 border-black">
                        <button @click="activeTab = 'guide'"
                            :class="activeTab === 'guide' ? 'bg-black text-white' : 'bg-white text-black hover:bg-gray-100'"
                            class="flex items-center gap-2 px-6 py-3 font-mono text-sm font-bold uppercase transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                            </svg>
                            GUIDE
                        </button>
                        @if($post->troubleshooting && count($post->troubleshooting) > 0)
                            <button @click="activeTab = 'issues'"
                                :class="activeTab === 'issues' ? 'bg-black text-white' : 'bg-white text-black hover:bg-gray-100'"
                                class="flex items-center gap-2 px-6 py-3 font-mono text-sm font-bold uppercase transition-colors border-l-2 border-black">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                </svg>
                                ISSUES
                                <span
                                    class="px-2 py-0.5 text-xs bg-red-500 text-white border border-red-700">{{ count($post->troubleshooting) }}</span>
                            </button>
                        @endif
                    </div>

                    <!-- Guide Tab Content -->
                    <div x-show="activeTab === 'guide'" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

                        {{-- Live Preview for Bricks --}}
                        @if($post->pillar->value === 'bricks' && $post->component)
                            <div class="mb-8 border-2 border-black overflow-hidden shadow-brutal">
                                <div class="bg-gray-900 px-4 py-3 flex items-center justify-between border-b-2 border-black">
                                    <span class="text-sm font-mono text-brutal-green">//
                                        {{ $post->component->class_name ?? 'COMPONENT_PREVIEW' }}</span>
                                    <div class="flex gap-1.5">
                                        <div class="w-3 h-3 bg-red-500"></div>
                                        <div class="w-3 h-3 bg-yellow-500"></div>
                                        <div class="w-3 h-3 bg-green-500"></div>
                                    </div>
                                </div>
                                <div class="bg-gray-100 p-8">
                                    <iframe srcdoc="{{ e($post->component->preview_html) }}"
                                        class="w-full h-64 border-2 border-black bg-white" sandbox="allow-scripts" loading="lazy">
                                    </iframe>
                                </div>
                                <div class="bg-gray-900 p-4 border-t-2 border-black" x-data="{ copied: false }">
                                    <div class="flex justify-between items-center mb-2">
                                        <span class="text-xs font-bold text-gray-400 uppercase tracking-wider font-mono">//
                                            BLADE_SNIPPET</span>
                                        <button
                                            @click="navigator.clipboard.writeText($refs.bladeCode.innerText); copied = true; setTimeout(() => copied = false, 2000)"
                                            class="btn-brutal-sm bg-brutal-green text-black text-xs">
                                            <span x-text="copied ? '✓ COPIED' : 'COPY'"></span>
                                        </button>
                                    </div>
                                    <pre
                                        class="text-sm text-gray-300 overflow-x-auto font-mono"><code x-ref="bladeCode">{{ $post->component->blade_snippet }}</code></pre>
                                </div>
                            </div>
                        @endif

                        {{-- Mobile View Toggle --}}
                        <div class="lg:hidden mb-4">
                            <div class="flex border-2 border-black">
                                <button @click="mobileView = 'theory'"
                                    :class="mobileView === 'theory' ? 'bg-black text-white' : 'bg-white text-black'"
                                    class="flex-1 py-3 font-mono text-sm font-bold uppercase transition-colors flex items-center justify-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                                    </svg>
                                    WHY
                                </button>
                                <button @click="mobileView = 'code'"
                                    :class="mobileView === 'code' ? 'bg-black text-white' : 'bg-white text-black'"
                                    class="flex-1 py-3 font-mono text-sm font-bold uppercase transition-colors flex items-center justify-center gap-2 border-l-2 border-black">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                                    </svg>
                                    HOW
                                </button>
                            </div>
                        </div>

                        {{-- Split Content Grid --}}
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                            {{-- Theory Section --}}
                            <div x-show="mobileView === 'theory' || window.innerWidth >= 1024" x-transition
                                class="border-2 border-black p-6 lg:p-8 bg-white shadow-brutal">
                                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-black">
                                    <div class="w-10 h-10 bg-brutal-blue flex items-center justify-center">
                                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold font-mono uppercase">// THE_WHY</h2>
                                        <p class="text-xs text-gray-500 font-mono">Understanding the concepts</p>
                                    </div>
                                </div>
                                <div class="prose prose-brutal max-w-none">
                                    {!! \App\Helpers\MarkdownHelper::parse($post->content_theory) !!}
                                </div>
                            </div>

                            {{-- Code Section --}}
                            <div x-show="mobileView === 'code' || window.innerWidth >= 1024" x-transition
                                class="border-2 border-black p-6 lg:p-8 bg-gray-900 text-white">
                                <div class="flex items-center gap-3 mb-6 pb-4 border-b-2 border-white/20">
                                    <div class="w-10 h-10 bg-brutal-green flex items-center justify-center">
                                        <svg class="w-5 h-5 text-black" fill="none" stroke="currentColor" stroke-width="2"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5" />
                                        </svg>
                                    </div>
                                    <div>
                                        <h2 class="text-lg font-bold font-mono uppercase">// THE_HOW</h2>
                                        <p class="text-xs text-gray-400 font-mono">Implementation details</p>
                                    </div>
                                </div>
                                <div class="prose prose-invert prose-brutal max-w-none">
                                    {!! \App\Helpers\MarkdownHelper::parse($post->content_technical) !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Troubleshooting Tab Content -->
                    @if($post->troubleshooting && count($post->troubleshooting) > 0)
                        <div x-show="activeTab === 'issues'" x-cloak x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">

                            <div class="space-y-4">
                                @foreach($post->troubleshooting as $index => $item)
                                    <div x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }"
                                        class="border-2 border-black overflow-hidden transition-all"
                                        :class="open ? 'shadow-brutal' : ''">

                                        {{-- Error Header --}}
                                        <button @click="open = !open"
                                            class="w-full flex items-center justify-between p-4 bg-red-50 hover:bg-red-100 transition-colors text-left">
                                            <div class="flex items-center gap-3 min-w-0">
                                                <div
                                                    class="w-10 h-10 bg-red-500 text-white flex-shrink-0 flex items-center justify-center">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"
                                                        viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z" />
                                                    </svg>
                                                </div>
                                                <div class="min-w-0">
                                                    <span class="font-mono text-xs text-red-600 uppercase tracking-wider">//
                                                        ERROR</span>
                                                    <p class="font-bold text-black truncate">
                                                        {{ $item['error_message'] ?? 'Unknown Error' }}</p>
                                                </div>
                                            </div>
                                            <svg :class="open ? 'rotate-180' : ''"
                                                class="w-5 h-5 text-gray-400 transition-transform flex-shrink-0 ml-4" fill="none"
                                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>

                                        {{-- Solution --}}
                                        <div x-show="open" x-collapse>
                                            <div class="p-4 bg-brutal-green/10 border-t-2 border-black">
                                                <div class="flex items-start gap-3">
                                                    <div
                                                        class="w-8 h-8 bg-brutal-green text-black flex-shrink-0 flex items-center justify-center mt-0.5">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2"
                                                            viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                d="m4.5 12.75 6 6 9-13.5" />
                                                        </svg>
                                                    </div>
                                                    <div>
                                                        <p class="font-mono text-xs text-green-700 uppercase tracking-wider mb-1">//
                                                            SOLUTION</p>
                                                        <p class="text-sm text-gray-700 font-mono">
                                                            {{ $item['solution'] ?? 'No solution provided.' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                </div>
            </div>

            {{-- Sticky Sidebar (3 cols on lg) --}}
            <aside class="col-span-12 lg:col-span-3">
                <div class="lg:sticky lg:top-24 space-y-6">
                    
                    {{-- Table of Contents --}}
                    <div class="border-2 border-black bg-white shadow-brutal p-4">
                        <h3 class="font-mono text-xs uppercase tracking-widest text-gray-500 mb-4 pb-2 border-b-2 border-black">
                            // ON_THIS_PAGE
                        </h3>
                        <nav class="space-y-2 text-sm">
                            <a href="#" class="block text-black hover:bg-brutal-yellow px-2 py-1 transition-colors font-bold">
                                Overview
                            </a>
                            @if($post->content_theory)
                                <a href="#" class="block text-gray-600 hover:bg-brutal-yellow hover:text-black px-2 py-1 transition-colors">
                                    Theory (The Why)
                                </a>
                            @endif
                            @if($post->content_technical)
                                <a href="#" class="block text-gray-600 hover:bg-brutal-yellow hover:text-black px-2 py-1 transition-colors">
                                    Implementation (The How)
                                </a>
                            @endif
                            @if($post->troubleshooting && count($post->troubleshooting) > 0)
                                <a href="#" class="block text-gray-600 hover:bg-brutal-yellow hover:text-black px-2 py-1 transition-colors">
                                    Troubleshooting ({{ count($post->troubleshooting) }})
                                </a>
                            @endif
                        </nav>
                    </div>

                    {{-- Related Articles --}}
                    @php
                        $relatedPosts = \App\Models\Post::where('id', '!=', $post->id)
                            ->where('pillar', $post->pillar)
                            ->published()
                            ->latest('published_at')
                            ->take(3)
                            ->get();
                    @endphp
                    @if($relatedPosts->count() > 0)
                        <div class="border-2 border-black bg-white shadow-brutal p-4">
                            <h3 class="font-mono text-xs uppercase tracking-widest text-gray-500 mb-4 pb-2 border-b-2 border-black">
                                // RELATED_ARTICLES
                            </h3>
                            <div class="space-y-3">
                                @foreach($relatedPosts as $related)
                                    <a href="{{ route('docs.show', ['version' => $currentVersion->slug, 'category' => $related->pillar->value, 'slug' => $related->slug]) }}"
                                       wire:navigate
                                       class="block group">
                                        <p class="text-sm font-bold text-black group-hover:underline line-clamp-2">
                                            {{ $related->title }}
                                        </p>
                                        <p class="text-xs text-gray-500 mt-1">
                                            {{ $related->published_at?->format('M d, Y') }}
                                        </p>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    {{-- Version Info --}}
                    <div class="border-2 border-black bg-gray-50 p-4">
                        <h3 class="font-mono text-xs uppercase tracking-widest text-gray-500 mb-3">
                            // VERSION_INFO
                        </h3>
                        <div class="space-y-2 text-sm">
                            <div class="flex justify-between">
                                <span class="text-gray-500">Current:</span>
                                <span class="font-bold">{{ $currentVersion->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span class="text-gray-500">Updated:</span>
                                <span>{{ $post->updated_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                        <a href="{{ route('docs.changelog', $currentVersion->slug) }}" 
                           wire:navigate
                           class="block mt-4 text-center px-4 py-2 border-2 border-black bg-black text-white text-xs font-bold uppercase
                                  hover:bg-brutal-yellow hover:text-black transition-colors">
                            View Changelog
                        </a>
                    </div>

                </div>
            </aside>

        </div>
    </div>

</x-layouts.docs>