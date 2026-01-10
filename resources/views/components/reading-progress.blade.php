@props([
    'content' => '',
    'showEstimate' => true,
])

@php
    // Calculate estimated reading time (average 200 words per minute)
    $wordCount = str_word_count(strip_tags($content));
    $readingTime = max(1, ceil($wordCount / 200));
@endphp

<div 
    x-data="readingProgress()" 
    x-init="init()"
    {{ $attributes }}
>
    {{-- Fixed progress bar at top of viewport --}}
    <div 
        class="fixed top-0 left-0 h-1 bg-gradient-to-r from-blue-500 to-indigo-600 z-[100] transition-all duration-150 ease-out"
        :style="{ width: progress + '%' }"
        x-show="progress > 0"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
    ></div>

    {{-- Reading time estimate badge --}}
    @if($showEstimate)
        <div class="inline-flex items-center gap-1.5 text-sm text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" 
                    d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
            </svg>
            <span>{{ $readingTime }} min read</span>
        </div>
    @endif
</div>

<script>
function readingProgress() {
    return {
        progress: 0,
        init() {
            this.calculateProgress();
            window.addEventListener('scroll', () => this.calculateProgress(), { passive: true });
            window.addEventListener('resize', () => this.calculateProgress(), { passive: true });
        },
        calculateProgress() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            
            if (docHeight > 0) {
                this.progress = Math.min(100, Math.max(0, (scrollTop / docHeight) * 100));
            }
        }
    }
}
</script>
