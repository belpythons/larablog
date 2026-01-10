{{-- Fat Footer - Neo-Brutalist Style --}}
<footer class="border-t-4 border-black bg-gray-50 mt-auto">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 mb-8">
            {{-- Navigation --}}
            <div>
                <h4 class="font-mono text-xs uppercase tracking-widest mb-4 text-gray-500">// NAV</h4>
                <ul class="space-y-2 text-sm font-mono">
                    <li><a href="{{ route('blog.index') }}" wire:navigate class="link-brutal">Home</a></li>
                    <li><a href="{{ route('blog.index') }}#posts" wire:navigate class="link-brutal">Blog</a></li>
                    <li><a href="/admin" class="link-brutal">Admin</a></li>
                </ul>
            </div>

            {{-- Resources --}}
            <div>
                <h4 class="font-mono text-xs uppercase tracking-widest mb-4 text-gray-500">// RESOURCES</h4>
                <ul class="space-y-2 text-sm font-mono">
                    <li><a href="https://laravel.com/docs" target="_blank" rel="noopener" class="link-brutal">Laravel
                            Docs ↗</a></li>
                    <li><a href="https://filamentphp.com/docs" target="_blank" rel="noopener"
                            class="link-brutal">Filament ↗</a></li>
                    <li><a href="https://tailwindcss.com" target="_blank" rel="noopener" class="link-brutal">Tailwind
                            ↗</a></li>
                </ul>
            </div>

            {{-- Tech Stacks --}}
            <div>
                <h4 class="font-mono text-xs uppercase tracking-widest mb-4 text-gray-500">// STACK</h4>
                <div class="flex flex-wrap gap-2">
                    <span class="badge-brutal-sm">Laravel 12</span>
                    <span class="badge-brutal-sm">Filament 4</span>
                    <span class="badge-brutal-sm">Livewire</span>
                    <span class="badge-brutal-sm">Tailwind</span>
                </div>
            </div>

            {{-- Logo --}}
            <div class="text-right">
                <div class="w-12 h-12 bg-black flex items-center justify-center ml-auto mb-4 shadow-brutal">
                    <span class="text-white font-bold text-xl">L</span>
                </div>
                <p class="font-mono text-sm">LARA<span class="bg-brutal-yellow px-1">BLOG</span></p>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="pt-8 border-t-2 border-black/10 flex flex-col sm:flex-row justify-between items-center gap-4">
            <p class="font-mono text-xs text-gray-500">
                // MIT License © {{ date('Y') }} LaraBlog
            </p>
            <p class="font-mono text-xs text-gray-400">
                Built with ❤️ by developers, for developers
            </p>
        </div>
    </div>
</footer>