@if ($paginator->hasPages())
    <nav class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
        {{-- Page Info --}}
        <span class="font-mono text-xs text-gray-500">
            // PAGE {{ $paginator->currentPage() }} OF {{ $paginator->lastPage() }}
        </span>

        <div class="flex flex-wrap gap-1">
            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <span class="px-4 py-2 font-mono text-sm border-2 border-gray-300 text-gray-400 bg-gray-50 cursor-not-allowed">
                    ←
                </span>
            @else
                <a href="{{ $paginator->previousPageUrl() }}" wire:navigate class="px-4 py-2 font-mono text-sm border-2 border-black bg-white shadow-brutal-sm
                                  hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none transition-all">
                    ←
                </a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($elements as $element)
                {{-- "Three Dots" Separator --}}
                @if (is_string($element))
                    <span class="px-4 py-2 font-mono text-sm border-2 border-black bg-gray-100">
                        {{ $element }}
                    </span>
                @endif

                {{-- Array Of Links --}}
                @if (is_array($element))
                    @foreach ($element as $page => $url)
                        @if ($page == $paginator->currentPage())
                            <span class="px-4 py-2 font-mono text-sm font-bold border-2 border-black bg-black text-white">
                                {{ $page }}
                            </span>
                        @else
                            <a href="{{ $url }}" wire:navigate class="px-4 py-2 font-mono text-sm border-2 border-black bg-white
                                                          hover:bg-brutal-yellow transition-colors">
                                {{ $page }}
                            </a>
                        @endif
                    @endforeach
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <a href="{{ $paginator->nextPageUrl() }}" wire:navigate class="px-4 py-2 font-mono text-sm border-2 border-black bg-white shadow-brutal-sm
                                  hover:translate-x-0.5 hover:translate-y-0.5 hover:shadow-none transition-all">
                    →
                </a>
            @else
                <span class="px-4 py-2 font-mono text-sm border-2 border-gray-300 text-gray-400 bg-gray-50 cursor-not-allowed">
                    →
                </span>
            @endif
        </div>
    </nav>
@endif