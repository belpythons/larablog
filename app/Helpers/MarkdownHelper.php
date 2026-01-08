<?php

namespace App\Helpers;

use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkExtension;
use League\CommonMark\Extension\HeadingPermalink\HeadingPermalinkRenderer;
use League\CommonMark\MarkdownConverter;

class MarkdownHelper
{
    protected static ?MarkdownConverter $converter = null;

    public static function parse(?string $markdown): string
    {
        if (empty($markdown)) {
            return '';
        }

        if (!self::$converter) {
            $environment = new Environment([
                'html_input' => 'strip',
                'allow_unsafe_links' => false,
                'heading_permalink' => [
                    'html_class' => 'heading-anchor',
                    'id_prefix' => '',
                    'fragment_prefix' => '',
                    'insert' => 'before',
                    'min_heading_level' => 2,
                    'max_heading_level' => 3,
                    'title' => 'Link to this section',
                    'symbol' => '#',
                    'aria_hidden' => true,
                ],
            ]);

            $environment->addExtension(new CommonMarkCoreExtension());
            $environment->addExtension(new HeadingPermalinkExtension());

            self::$converter = new MarkdownConverter($environment);
        }

        $html = self::$converter->convert($markdown)->getContent();

        // Post-process: Wrap code blocks with copy button wrapper
        $html = self::wrapCodeBlocks($html);

        return $html;
    }

    /**
     * Wrap <pre><code> blocks with a container that includes a copy button.
     */
    protected static function wrapCodeBlocks(string $html): string
    {
        // Match <pre><code class="...">...</code></pre> blocks
        $pattern = '/<pre><code(?:\s+class="([^"]*)")?>(.*?)<\/code><\/pre>/s';

        return preg_replace_callback($pattern, function ($matches) {
            $langClass = $matches[1] ?? '';
            $code = $matches[2];

            // Extract language from class (e.g., "language-php" -> "php")
            $lang = '';
            if (preg_match('/language-(\w+)/', $langClass, $langMatch)) {
                $lang = $langMatch[1];
            }

            // Generate unique ID for this code block
            $id = 'code-' . Str::random(8);

            return <<<HTML
<div class="code-block-wrapper relative group" x-data="{ copied: false }">
    <div class="absolute top-2 right-2 flex items-center space-x-2 opacity-0 group-hover:opacity-100 transition-opacity">
        <span class="text-xs text-slate-500 font-mono">{$lang}</span>
        <button 
            @click="navigator.clipboard.writeText(document.getElementById('{$id}').textContent).then(() => { copied = true; setTimeout(() => copied = false, 2000) })"
            class="px-2 py-1 text-xs rounded bg-slate-700 hover:bg-slate-600 text-slate-300 transition flex items-center space-x-1"
            :class="copied ? 'bg-green-600 text-white' : ''"
        >
            <span x-show="!copied">📋 Copy</span>
            <span x-show="copied" x-cloak>✅ Copied!</span>
        </button>
    </div>
    <pre class="!mt-0"><code id="{$id}" class="{$langClass}">{$code}</code></pre>
</div>
HTML;
        }, $html);
    }
}
