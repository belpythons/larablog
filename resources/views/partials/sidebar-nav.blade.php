{{-- Sidebar Navigation Partial --}}
@if(count($sidebarData) > 0)
    @foreach($sidebarData as $stack)
        <div x-data="{ expanded: true }">
            <button @click="expanded = !expanded" 
                    class="w-full flex items-center justify-between p-2 rounded-lg hover:bg-gray-50 transition-colors group">
                <span class="flex items-center gap-2 text-xs font-semibold text-gray-400 uppercase tracking-wider">
                    @if(isset($stack['icon_path']) && $stack['icon_path'])
                        <img src="{{ asset($stack['icon_path']) }}" class="w-4 h-4" alt="">
                    @else
                        <x-lucide-tag class="w-4 h-4" />
                    @endif
                    {{ $stack['name'] }}
                </span>
                <x-lucide-chevron-down class="w-4 h-4 text-gray-400 transition-transform" :class="expanded ? 'rotate-180' : ''" />
            </button>
            
            <ul x-show="expanded" x-transition class="mt-1 space-y-0.5 pl-2">
                @foreach($stack['posts'] as $navPost)
                    @php 
                        $isActive = isset($post) && $post->slug === $navPost['slug'];
                    @endphp
                    <li>
                        <a href="{{ route('docs.show', ['version' => $currentVersion->slug, 'category' => $navPost['pillar'], 'slug' => $navPost['slug']]) }}"
                           @if(isset($sidebarOpen)) @click="sidebarOpen = false" @endif
                           class="flex items-center gap-2 px-3 py-2 text-sm rounded-lg transition-all duration-200 {{ $isActive ? 'bg-blue-50 text-blue-700 font-medium border-l-2 border-blue-600' : 'text-gray-600 hover:bg-gray-50 hover:text-gray-900' }}">
                            @if($isActive)
                                <x-lucide-chevron-right class="w-3.5 h-3.5 text-blue-600" />
                            @else
                                <x-lucide-file-text class="w-3.5 h-3.5 text-gray-400" />
                            @endif
                            <span class="truncate">{{ $navPost['title'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
@else
    <div class="text-center py-8">
        <x-lucide-file-text class="w-12 h-12 mx-auto text-gray-300 mb-3" />
        <p class="text-sm text-gray-400">No articles available</p>
    </div>
@endif
