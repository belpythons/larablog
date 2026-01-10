@props(['currentVersion' => null])

<div x-data="spotlightSearch()" x-init="init()" x-show="open" x-cloak @keydown.window.prevent.cmd.k="open = true"
    @keydown.window.prevent.ctrl.k="open = true" @keydown.escape.window="open = false"
    @toggle-spotlight.window="open = !open" class="fixed inset-0 z-[100]"
    x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

    <!-- Backdrop -->
    <div class="fixed inset-0 bg-slate-900/50 backdrop-blur-sm" @click="open = false"></div>

    <!-- Modal -->
    <div class="fixed inset-x-0 top-20 mx-auto max-w-2xl px-4">
        <div class="bg-white rounded-xl shadow-2xl border border-gray-200 overflow-hidden"
            @click.outside="open = false">

            <!-- Search Input -->
            <div class="flex items-center px-4 border-b border-gray-100">
                {{-- Heroicon: magnifying-glass --}}
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
                <input type="text" x-model="query" x-ref="searchInput" @input.debounce.300ms="search()"
                    @keydown.arrow-down.prevent="moveDown()" @keydown.arrow-up.prevent="moveUp()"
                    @keydown.enter.prevent="goToSelected()" placeholder="Search documentation..."
                    class="w-full px-3 py-4 text-lg border-0 focus:ring-0 focus:outline-none placeholder-gray-400">
                <kbd class="px-2 py-1 text-xs font-mono bg-gray-100 text-gray-500 rounded">ESC</kbd>
            </div>

            <!-- Results -->
            <div class="max-h-96 overflow-y-auto" x-show="query.length >= 2">

                <!-- Loading -->
                <div x-show="loading" class="p-4 text-center text-gray-500">
                    {{-- Heroicon: arrow-path (spinner) --}}
                    <svg class="animate-spin h-5 w-5 mx-auto" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                    </svg>
                </div>

                <!-- Guides Section -->
                <template x-if="results.guides && results.guides.length > 0">
                    <div class="px-2 py-2">
                        <div class="px-3 py-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Guides
                        </div>
                        <template x-for="(item, index) in results.guides" :key="'guide-' + item.id">
                            <a :href="item.url" class="flex items-center px-3 py-2 rounded-lg transition"
                                :class="selectedIndex === getGlobalIndex('guides', index) ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-50'"
                                @mouseenter="selectedIndex = getGlobalIndex('guides', index)">
                                <span
                                    class="w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center text-sm mr-3">📖</span>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium truncate" x-text="item.title"></div>
                                    <div class="text-xs text-gray-500 truncate" x-text="item.excerpt"></div>
                                </div>
                                <span class="text-xs text-gray-400 px-2 py-0.5 bg-gray-100 rounded"
                                    x-text="item.pillar"></span>
                            </a>
                        </template>
                    </div>
                </template>

                <!-- Components Section -->
                <template x-if="results.components && results.components.length > 0">
                    <div class="px-2 py-2 border-t border-gray-100">
                        <div class="px-3 py-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Components
                        </div>
                        <template x-for="(item, index) in results.components" :key="'comp-' + item.id">
                            <a :href="item.url" class="flex items-center px-3 py-2 rounded-lg transition"
                                :class="selectedIndex === getGlobalIndex('components', index) ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-50'"
                                @mouseenter="selectedIndex = getGlobalIndex('components', index)">
                                <span
                                    class="w-8 h-8 rounded-lg bg-amber-100 text-amber-600 flex items-center justify-center text-sm mr-3">🧱</span>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium truncate" x-text="item.title"></div>
                                </div>
                            </a>
                        </template>
                    </div>
                </template>

                <!-- Tech Stacks Section -->
                <template x-if="results.tech_stacks && results.tech_stacks.length > 0">
                    <div class="px-2 py-2 border-t border-gray-100">
                        <div class="px-3 py-1.5 text-xs font-semibold text-gray-400 uppercase tracking-wider">Tech
                            Stacks</div>
                        <template x-for="(item, index) in results.tech_stacks" :key="'stack-' + item.id">
                            <div class="flex items-center px-3 py-2 rounded-lg transition"
                                :class="selectedIndex === getGlobalIndex('tech_stacks', index) ? 'bg-blue-50 text-blue-700' : 'hover:bg-gray-50'"
                                @mouseenter="selectedIndex = getGlobalIndex('tech_stacks', index)">
                                <span
                                    class="w-8 h-8 rounded-lg bg-purple-100 text-purple-600 flex items-center justify-center text-sm mr-3">⚙️</span>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium" x-text="item.title"></div>
                                </div>
                                <span class="text-xs text-gray-400" x-text="item.type"></span>
                            </div>
                        </template>
                    </div>
                </template>

                <!-- No Results -->
                <div x-show="!loading && query.length >= 2 && totalResults === 0" class="p-8 text-center text-gray-500">
                    <div class="text-4xl mb-2">🔍</div>
                    <p>No results found for "<span x-text="query"></span>"</p>
                </div>
            </div>

            <!-- Footer -->
            <div
                class="px-4 py-3 bg-gray-50 border-t border-gray-100 flex items-center justify-between text-xs text-gray-500">
                <div class="flex items-center space-x-3">
                    <span><kbd class="px-1.5 py-0.5 bg-white border rounded shadow-sm">↑</kbd> <kbd
                            class="px-1.5 py-0.5 bg-white border rounded shadow-sm">↓</kbd> Navigate</span>
                    <span><kbd class="px-1.5 py-0.5 bg-white border rounded shadow-sm">↵</kbd> Open</span>
                </div>
                <span x-show="version" x-text="'Searching in ' + version"></span>
            </div>
        </div>
    </div>
</div>

<script>
    function spotlightSearch() {
        return {
            open: false,
            query: '',
            loading: false,
            results: { guides: [], components: [], tech_stacks: [] },
            selectedIndex: 0,
            version: '{{ $currentVersion?->name ?? "" }}',
            versionSlug: '{{ $currentVersion?->slug ?? "" }}',

            init() {
                this.$watch('open', (value) => {
                    if (value) {
                        this.$nextTick(() => this.$refs.searchInput.focus());
                    } else {
                        this.query = '';
                        this.results = { guides: [], components: [], tech_stacks: [] };
                        this.selectedIndex = 0;
                    }
                });
            },

            async search() {
                if (this.query.length < 2) {
                    this.results = { guides: [], components: [], tech_stacks: [] };
                    return;
                }

                this.loading = true;
                this.selectedIndex = 0;

                try {
                    const params = new URLSearchParams({ query: this.query });
                    if (this.versionSlug) params.append('version', this.versionSlug);

                    const response = await fetch(`/api/search?${params}`);
                    const data = await response.json();
                    this.results = data.results;
                    this.version = data.version;
                } catch (e) {
                    console.error('Search failed:', e);
                } finally {
                    this.loading = false;
                }
            },

            get totalResults() {
                return (this.results.guides?.length || 0) +
                    (this.results.components?.length || 0) +
                    (this.results.tech_stacks?.length || 0);
            },

            get allItems() {
                return [
                    ...(this.results.guides || []),
                    ...(this.results.components || []),
                    ...(this.results.tech_stacks || [])
                ];
            },

            getGlobalIndex(section, localIndex) {
                let offset = 0;
                if (section === 'components') offset = this.results.guides?.length || 0;
                if (section === 'tech_stacks') offset = (this.results.guides?.length || 0) + (this.results.components?.length || 0);
                return offset + localIndex;
            },

            moveDown() {
                if (this.selectedIndex < this.totalResults - 1) {
                    this.selectedIndex++;
                }
            },

            moveUp() {
                if (this.selectedIndex > 0) {
                    this.selectedIndex--;
                }
            },

            goToSelected() {
                const item = this.allItems[this.selectedIndex];
                if (item?.url) {
                    // Use Livewire navigate for SPA experience
                    if (typeof Livewire !== 'undefined' && Livewire.navigate) {
                        Livewire.navigate(item.url);
                    } else {
                        window.location.href = item.url;
                    }
                    this.open = false;
                }
            }
        };
    }
</script>