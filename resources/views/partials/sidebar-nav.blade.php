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
                        {{-- Heroicon: tag --}}
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.568 3H5.25A2.25 2.25 0 0 0 3 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 0 0 5.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 0 0 9.568 3Z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 6h.008v.008H6V6Z"/>
                        </svg>
                    @endif
                    {{ $stack['name'] }}
                </span>
                {{-- Heroicon: chevron-down --}}
                <svg class="w-4 h-4 text-gray-400 transition-transform" :class="expanded ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5"/>
                </svg>
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
                                {{-- Heroicon: chevron-right --}}
                                <svg class="w-3.5 h-3.5 text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5"/>
                                </svg>
                            @else
                                {{-- Heroicon: document-text --}}
                                <svg class="w-3.5 h-3.5 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
                                </svg>
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
        {{-- Heroicon: document-text --}}
        <svg class="w-12 h-12 mx-auto text-gray-300 mb-3" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z"/>
        </svg>
        <p class="text-sm text-gray-400">No articles available</p>
    </div>
@endif
