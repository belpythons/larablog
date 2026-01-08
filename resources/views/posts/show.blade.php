<x-layouts.docs :title="$post->title" :post="$post" :sidebarData="$sidebarData" :currentVersion="$currentVersion"
    :versions="$versions">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 py-8 lg:py-12">

        <!-- Breadcrumb -->
        <nav class="flex items-center gap-2 text-sm text-gray-500 mb-6">
            <a href="{{ route('blog.index') }}" class="hover:text-blue-600 transition-colors flex items-center gap-1">
                {{-- Heroicon: home --}}
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25"/>
                </svg>
                Home
            </a>
            {{-- Heroicon: chevron-right --}}
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
            </svg>
            <span>{{ $currentVersion->name }}</span>
            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
            </svg>
            <span class="capitalize">{{ str_replace('_', ' ', $post->pillar->value) }}</span>
        </nav>

        <!-- Header -->
        <header class="mb-8 animate-fade-in">
            <h1 class="text-3xl sm:text-4xl font-extrabold tracking-tight text-gray-900 mb-4">
                {{ $post->title }}
            </h1>

            <div class="flex flex-wrap items-center gap-3">
                @php
                    $pillarColors = [
                        'ecosystem' => 'bg-blue-100 text-blue-700',
                        'starter_kit' => 'bg-emerald-100 text-emerald-700',
                        'bricks' => 'bg-amber-100 text-amber-700',
                    ];
                @endphp
                <span
                    class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-sm font-semibold {{ $pillarColors[$post->pillar->value] ?? 'bg-gray-100 text-gray-700' }}">
                    {{ $post->pillar->getLabel() }}
                </span>

                @foreach($post->techStacks as $stack)
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-600">
                        {{ $stack->name }}
                    </span>
                @endforeach

                @foreach($post->versions as $v)
                    <span class="px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-700">
                        {{ $v->name }}
                    </span>
                @endforeach
            </div>
        </header>

        <!-- Main Content Tabs -->
        <div x-data="{ activeTab: 'guide', mobileView: 'theory' }" class="space-y-6">

            <!-- Tab Buttons -->
            <div class="flex gap-1 p-1 bg-gray-100 rounded-xl w-fit">
                <button @click="activeTab = 'guide'"
                    :class="activeTab === 'guide' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600 hover:text-gray-900'"
                    class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                    {{-- Heroicon: book-open --}}
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25"/>
                    </svg>
                    Guide
                </button>
                @if($post->troubleshooting && count($post->troubleshooting) > 0)
                    <button @click="activeTab = 'issues'"
                        :class="activeTab === 'issues' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600 hover:text-gray-900'"
                        class="flex items-center gap-2 px-4 py-2 text-sm font-medium rounded-lg transition-all duration-200">
                        {{-- Heroicon: exclamation-triangle --}}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                        </svg>
                        Troubleshooting
                        <span
                            class="px-1.5 py-0.5 text-xs bg-red-100 text-red-700 rounded-full">{{ count($post->troubleshooting) }}</span>
                    </button>
                @endif
            </div>

            <!-- Guide Tab Content -->
            <div x-show="activeTab === 'guide'" x-transition:enter="transition ease-out duration-300"
                x-transition:enter-start="opacity-0 transform -translate-y-2"
                x-transition:enter-end="opacity-100 transform translate-y-0">

                {{-- Live Preview for Bricks --}}
                @if($post->pillar->value === 'bricks' && $post->component)
                    <div class="mb-8 card overflow-hidden">
                        <div class="bg-gray-900 px-4 py-3 flex items-center justify-between">
                            <span
                                class="text-sm font-mono text-gray-400">{{ $post->component->class_name ?? 'Component Preview' }}</span>
                            <div class="flex gap-1.5">
                                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                            </div>
                        </div>
                        <div class="bg-gradient-to-br from-gray-50 to-gray-100 p-8">
                            <iframe srcdoc="{{ e($post->component->preview_html) }}"
                                class="w-full h-64 border-0 rounded-xl bg-white shadow-inner" sandbox="allow-scripts"
                                loading="lazy">
                            </iframe>
                        </div>
                        <div class="bg-gray-900 p-4" x-data="{ copied: false }">
                            <div class="flex justify-between items-center mb-2">
                                <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Blade Snippet</span>
                                <button
                                    @click="navigator.clipboard.writeText($refs.bladeCode.innerText); copied = true; setTimeout(() => copied = false, 2000)"
                                    class="flex items-center gap-1.5 text-xs text-blue-400 hover:text-blue-300 transition-colors">
                                    <template x-if="!copied">
                                        {{-- Heroicon: clipboard-document --}}
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184"/>
                                        </svg>
                                    </template>
                                    <template x-if="copied">
                                        {{-- Heroicon: check --}}
                                        <svg class="w-4 h-4 text-green-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                                        </svg>
                                    </template>
                                    <span x-text="copied ? 'Copied!' : 'Copy'"></span>
                                </button>
                            </div>
                            <pre
                                class="text-sm text-gray-300 overflow-x-auto"><code x-ref="bladeCode" class="language-blade">{{ $post->component->blade_snippet }}</code></pre>
                        </div>
                    </div>
                @endif

                {{-- Mobile View Toggle --}}
                <div class="lg:hidden mb-4">
                    <div class="flex p-1 bg-gray-100 rounded-xl">
                        <button @click="mobileView = 'theory'"
                            :class="mobileView === 'theory' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600'"
                            class="flex-1 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                            {{-- Heroicon: light-bulb --}}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                            </svg>
                            Theory
                        </button>
                        <button @click="mobileView = 'code'"
                            :class="mobileView === 'code' ? 'bg-white shadow-sm text-gray-900' : 'text-gray-600'"
                            class="flex-1 py-2.5 text-sm font-medium rounded-lg transition-all duration-200 flex items-center justify-center gap-2">
                            {{-- Heroicon: code-bracket --}}
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5"/>
                            </svg>
                            Code
                        </button>
                    </div>
                </div>

                {{-- Split Content Grid --}}
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 lg:gap-8">

                    {{-- Theory Section --}}
                    <div x-show="mobileView === 'theory' || window.innerWidth >= 1024" x-transition
                        class="card p-6 lg:p-8">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center">
                                {{-- Heroicon: light-bulb --}}
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-gray-900">The Why (Theory)</h2>
                                <p class="text-sm text-gray-500">Understanding the concepts</p>
                            </div>
                        </div>
                        <div class="prose prose-blue prose-sm max-w-none">
                            {!! \App\Helpers\MarkdownHelper::parse($post->content_theory) !!}
                        </div>
                    </div>

                    {{-- Code Section --}}
                    <div x-show="mobileView === 'code' || window.innerWidth >= 1024" x-transition
                        class="bg-gray-900 rounded-2xl p-6 lg:p-8 lg:sticky lg:top-20 self-start">
                        <div class="flex items-center gap-3 mb-6">
                            <div
                                class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-emerald-600 flex items-center justify-center">
                                {{-- Heroicon: code-bracket --}}
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 6.75 22.5 12l-5.25 5.25m-10.5 0L1.5 12l5.25-5.25m7.5-3-4.5 16.5"/>
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-white">The How (Code)</h2>
                                <p class="text-sm text-gray-400">Implementation details</p>
                            </div>
                        </div>
                        <div
                            class="prose prose-invert prose-sm prose-pre:bg-gray-800 prose-pre:border prose-pre:border-gray-700 max-w-none">
                            {!! \App\Helpers\MarkdownHelper::parse($post->content_technical) !!}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Troubleshooting Tab Content -->
            @if($post->troubleshooting && count($post->troubleshooting) > 0)
                <div x-show="activeTab === 'issues'" x-cloak x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                    x-transition:enter-end="opacity-100 transform translate-y-0">

                    <div class="space-y-4">
                        @foreach($post->troubleshooting as $index => $item)
                            <div x-data="{ open: {{ $index === 0 ? 'true' : 'false' }} }"
                                class="card overflow-hidden transition-shadow duration-200" :class="open ? 'shadow-lg' : ''">
                                <button @click="open = !open"
                                    class="w-full flex items-center justify-between p-5 text-left hover:bg-gray-50 transition-colors">
                                    <div class="flex items-center gap-3 min-w-0">
                                        <div
                                            class="w-10 h-10 rounded-xl bg-red-100 text-red-600 flex-shrink-0 flex items-center justify-center">
                                            {{-- Heroicon: exclamation-triangle --}}
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m-9.303 3.376c-.866 1.5.217 3.374 1.948 3.374h14.71c1.73 0 2.813-1.874 1.948-3.374L13.949 3.378c-.866-1.5-3.032-1.5-3.898 0L2.697 16.126ZM12 15.75h.007v.008H12v-.008Z"/>
                                            </svg>
                                        </div>
                                        <span
                                            class="font-semibold text-gray-900 truncate">{{ $item['error_message'] ?? 'Unknown Error' }}</span>
                                    </div>
                                    {{-- Heroicon: chevron-down --}}
                                    <svg :class="open ? 'rotate-180' : ''"
                                        class="w-5 h-5 text-gray-400 transition-transform flex-shrink-0 ml-4" fill="none"
                                        stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                                    </svg>
                                </button>
                                <div x-show="open" x-collapse>
                                    <div class="px-5 pb-5">
                                        <div class="callout-success flex items-start gap-3">
                                            {{-- Heroicon: check-circle --}}
                                            <svg class="w-5 h-5 text-emerald-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                                            </svg>
                                            <div>
                                                <p class="font-semibold text-emerald-800 mb-1">Solution</p>
                                                <p class="text-sm text-emerald-700">
                                                    {{ $item['solution'] ?? 'No solution provided.' }}</p>
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
</x-layouts.docs>