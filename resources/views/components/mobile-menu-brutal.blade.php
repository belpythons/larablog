{{-- Mobile Menu Overlay - Neo-Brutalist --}}
<div x-data="{ open: false }" @toggle-mobile-menu.window="open = !open" x-cloak>
    {{-- Fullscreen Overlay --}}
    <div x-show="open" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 z-[150] lg:hidden bg-white">
        {{-- Header --}}
        <div class="flex items-center justify-between p-4 border-b-2 border-black">
            <span class="font-mono font-bold text-xl">LARA<span class="bg-brutal-yellow px-1">BLOG</span></span>
            <button @click="open = false" class="w-12 h-12 border-2 border-black flex items-center justify-center
                           hover:bg-brutal-yellow transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        {{-- Navigation Links --}}
        <nav class="p-6 space-y-0">
            <a href="{{ route('blog.index') }}" wire:navigate @click="open = false" class="block text-2xl font-bold font-mono py-4 border-b-2 border-black 
                      hover:bg-brutal-yellow transition-colors px-4 -mx-4">
                → HOME
            </a>
            <a href="{{ route('blog.index') }}#posts" wire:navigate @click="open = false" class="block text-2xl font-bold font-mono py-4 border-b-2 border-black 
                      hover:bg-brutal-yellow transition-colors px-4 -mx-4">
                → BLOG
            </a>
            <button @click="$dispatch('toggle-spotlight'); open = false" class="block w-full text-left text-2xl font-bold font-mono py-4 border-b-2 border-black 
                      hover:bg-brutal-yellow transition-colors px-4 -mx-4">
                → SEARCH
            </button>
            <a href="/admin" @click="open = false" class="block text-2xl font-bold font-mono py-4 border-b-2 border-black 
                      hover:bg-brutal-yellow transition-colors px-4 -mx-4">
                → ADMIN
            </a>
        </nav>

        {{-- Footer Info --}}
        <div class="absolute bottom-0 left-0 right-0 p-6 border-t-2 border-black bg-gray-50">
            <p class="font-mono text-xs text-gray-500 text-center">
                // Press ESC or tap outside to close
            </p>
        </div>
    </div>

    {{-- Hamburger Trigger Button (only shown when FAB is not visible) --}}
    {{-- Note: This is positioned in header, not floating, to avoid conflict with search FAB --}}
</div>