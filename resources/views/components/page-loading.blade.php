{{-- Page Loading Bar - NProgress Style for wire:navigate --}}
<div x-data="{ 
        loading: false, 
        progress: 0,
        timeout: null
    }" x-init="
        document.addEventListener('livewire:navigate:start', () => {
            loading = true;
            progress = 30;
            // Animate progress
            timeout = setInterval(() => {
                if (progress < 90) progress += Math.random() * 10;
            }, 200);
        });
        document.addEventListener('livewire:navigate:end', () => {
            clearInterval(timeout);
            progress = 100;
            setTimeout(() => { 
                loading = false; 
                progress = 0; 
            }, 200);
        });
    " x-show="loading" x-transition:enter="transition-opacity duration-100"
    x-transition:leave="transition-opacity duration-300"
    class="fixed top-0 left-0 right-0 z-[200] h-1 bg-transparent pointer-events-none">
    <div class="h-full bg-black transition-all duration-200 ease-out" :style="{ width: progress + '%' }"></div>

    {{-- Spinner dot at end of bar --}}
    <div class="absolute top-0 right-0 -translate-x-1 w-3 h-3 rounded-full bg-black shadow-brutal-sm"
        :style="{ left: progress + '%' }" x-show="progress > 0 && progress < 100"></div>
</div>