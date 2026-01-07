<x-layouts.docs :title="$post->title">
    <div class="flex flex-col lg:flex-row min-h-[calc(100vh-4rem)]">

        <!-- Left Pane: Theory (The Why) -->
        <div class="w-full lg:w-1/2 bg-white p-8 lg:p-12 overflow-y-auto">
            <div class="max-w-2xl mx-auto">
                <div class="flex items-center space-x-2 mb-6">
                    <span class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800 capitalize">
                        {{ str_replace('_', ' ', $post->pillar) }}
                    </span>
                    @foreach($post->techStacks as $stack)
                        <span
                            class="px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                            {{ $stack->name }}
                        </span>
                    @endforeach
                </div>

                <h1 class="text-4xl font-extrabold tracking-tight text-gray-900 mb-6">{{ $post->title }}</h1>

                <div class="prose prose-lg prose-blue text-gray-600">
                    {!! $post->content_theory !!}
                </div>

                @if($post->troubleshooting)
                    <div class="mt-12 p-6 bg-amber-50 rounded-lg border border-amber-200">
                        <h3 class="text-lg font-bold text-amber-900 mb-4 flex items-center">
                            <svg class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            Troubleshooting
                        </h3>
                        <div class="space-y-4">
                            @foreach($post->troubleshooting as $item)
                                <div>
                                    <p class="font-semibold text-amber-800 text-sm">Symptoms:</p>
                                    <p class="text-amber-900">{{ $item['error_message'] }}</p>
                                    <p class="font-semibold text-green-700 text-sm mt-1">Solution:</p>
                                    <p class="text-gray-700">{{ $item['solution'] }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Right Pane: Technical (The How) -->
        <div
            class="w-full lg:w-1/2 bg-slate-900 text-slate-300 p-8 lg:p-12 lg:sticky lg:top-16 lg:h-[calc(100vh-4rem)] overflow-y-auto scrollbar-thin scrollbar-thumb-slate-700">
            <div class="max-w-2xl mx-auto">
                <div
                    class="prose prose-invert prose-pre:bg-slate-800 prose-pre:border prose-pre:border-slate-700 max-w-none">
                    {!! $post->content_technical !!}
                </div>

                @if($post->pillar === 'bricks' && $post->component)
                    <div class="mt-10">
                        <h3 class="text-xl font-bold text-white mb-4">Live Preview</h3>
                        <x-live-preview :component="$post->component" />
                    </div>
                @endif
            </div>
        </div>

    </div>
</x-layouts.docs>