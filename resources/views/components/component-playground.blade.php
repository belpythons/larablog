@props([
    'component' => null,
    'code' => '',
])

<div 
    x-data="{ 
        activeTab: 'preview',
        copied: false,
        async copyCode() {
            await navigator.clipboard.writeText(this.$refs.codeContent.textContent);
            this.copied = true;
            setTimeout(() => this.copied = false, 2000);
        }
    }" 
    class="card-brutal overflow-hidden"
    {{ $attributes }}
>
    {{-- Tab Header --}}
    <div class="flex border-b-2 border-black bg-gray-100">
        <button 
            @click="activeTab = 'preview'"
            :class="activeTab === 'preview' ? 'bg-white border-b-2 border-white -mb-0.5' : 'bg-transparent hover:bg-gray-200'"
            class="px-6 py-3 font-mono text-sm font-bold uppercase tracking-wider transition-colors"
        >
            // PREVIEW
        </button>
        <button 
            @click="activeTab = 'code'"
            :class="activeTab === 'code' ? 'bg-white border-b-2 border-white -mb-0.5' : 'bg-transparent hover:bg-gray-200'"
            class="px-6 py-3 font-mono text-sm font-bold uppercase tracking-wider transition-colors"
        >
            // SOURCE
        </button>
        
        {{-- Copy Button --}}
        <button 
            x-show="activeTab === 'code'"
            @click="copyCode()"
            class="ml-auto px-4 font-mono text-xs flex items-center gap-2 hover:bg-gray-200 transition-colors border-l-2 border-black"
        >
            <template x-if="!copied">
                <span class="flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.666 3.888A2.25 2.25 0 0 0 13.5 2.25h-3c-1.03 0-1.9.693-2.166 1.638m7.332 0c.055.194.084.4.084.612v0a.75.75 0 0 1-.75.75H9a.75.75 0 0 1-.75-.75v0c0-.212.03-.418.084-.612m7.332 0c.646.049 1.288.11 1.927.184 1.1.128 1.907 1.077 1.907 2.185V19.5a2.25 2.25 0 0 1-2.25 2.25H6.75A2.25 2.25 0 0 1 4.5 19.5V6.257c0-1.108.806-2.057 1.907-2.185a48.208 48.208 0 0 1 1.927-.184"/>
                    </svg>
                    COPY
                </span>
            </template>
            <template x-if="copied">
                <span class="flex items-center gap-1 text-green-600">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5"/>
                    </svg>
                    COPIED!
                </span>
            </template>
        </button>
    </div>

    {{-- Preview Tab --}}
    <div x-show="activeTab === 'preview'" x-transition class="p-8 bg-white min-h-[200px]">
        @if($component && $component->preview_html)
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 flex items-center justify-center">
                {!! $component->preview_html !!}
            </div>
        @else
            <div class="text-center text-gray-400 font-mono py-12 border-2 border-dashed border-gray-200 rounded-lg">
                // NO_PREVIEW_AVAILABLE
            </div>
        @endif
    </div>

    {{-- Source Code Tab --}}
    <div x-show="activeTab === 'code'" x-transition class="relative">
        <div class="max-h-96 overflow-auto bg-[#0d1117]">
            <pre class="p-6 text-sm leading-relaxed"><code x-ref="codeContent" class="font-mono text-gray-300">{!! e($code ?: $component?->blade_snippet ?? '// No source code available') !!}</code></pre>
        </div>
    </div>
</div>

{{-- Shiki Syntax Highlighting via CDN --}}
@pushOnce('scripts')
<script type="module">
    // Lazy load Shiki for syntax highlighting
    const codeBlocks = document.querySelectorAll('.component-playground code');
    if (codeBlocks.length > 0) {
        import('https://esm.sh/shiki@1.0.0').then(async ({ codeToHtml }) => {
            for (const block of codeBlocks) {
                const code = block.textContent;
                try {
                    const html = await codeToHtml(code, {
                        lang: 'blade',
                        theme: 'github-dark'
                    });
                    block.innerHTML = html;
                } catch (e) {
                    console.warn('Shiki highlighting failed:', e);
                }
            }
        });
    }
</script>
@endPushOnce
