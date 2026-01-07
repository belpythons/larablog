@props(['component'])

<div class="rounded-lg overflow-hidden border border-slate-700 bg-slate-800 shadow-xl">
    <div class="bg-slate-950 px-4 py-2 flex items-center justify-between border-b border-slate-700">
        <span class="text-xs font-mono text-slate-400">{{ $component->class_name }}</span>
        <div class="flex space-x-1.5">
            <div class="w-2.5 h-2.5 rounded-full bg-slate-600"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-slate-600"></div>
            <div class="w-2.5 h-2.5 rounded-full bg-slate-600"></div>
        </div>
    </div>
    <div class="p-4 bg-white pattern-grid-lg text-gray-900">
        <iframe srcdoc="{{ $component->preview_html }}" class="w-full h-64 border-0" sandbox="allow-scripts"
            loading="lazy">
        </iframe>
    </div>
    <div class="bg-slate-900 p-4 border-t border-slate-700">
        <div class="flex justify-between items-center mb-2">
            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Blade Source</span>
            <button class="text-xs text-blue-400 hover:text-blue-300"
                onclick="navigator.clipboard.writeText(this.nextElementSibling.innerText)">Copy</button>
            <div class="hidden">{{ $component->blade_snippet }}</div>
        </div>
        <pre><code class="language-blade text-sm">{{ $component->blade_snippet }}</code></pre>
    </div>
</div>