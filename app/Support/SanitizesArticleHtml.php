<?php

namespace App\Support;

use DOMDocument;
use DOMElement;
use DOMNode;

class SanitizesArticleHtml
{
    private const ALLOWED_TAGS = ['p', 'br', 'strong', 'em', 's', 'h2', 'h3', 'ul', 'ol', 'li', 'blockquote', 'a', 'code', 'pre'];

    public static function clean(string $html): string
    {
        $document = new DOMDocument('1.0', 'UTF-8');
        libxml_use_internal_errors(true);
        $document->loadHTML('<div id="article-root">'.$html.'</div>', LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);
        libxml_clear_errors();

        $root = $document->getElementById('article-root');
        if (! $root) {
            return '';
        }

        self::sanitizeChildren($root);

        $clean = '';
        foreach ($root->childNodes as $child) {
            $clean .= $document->saveHTML($child);
        }

        return trim($clean);
    }

    private static function sanitizeChildren(DOMNode $parent): void
    {
        foreach (iterator_to_array($parent->childNodes) as $node) {
            if (! $node instanceof DOMElement) {
                continue;
            }

            if (! in_array(strtolower($node->tagName), self::ALLOWED_TAGS, true)) {
                while ($node->firstChild) {
                    $parent->insertBefore($node->firstChild, $node);
                }
                $parent->removeChild($node);

                continue;
            }

            foreach (iterator_to_array($node->attributes) as $attribute) {
                $name = strtolower($attribute->name);
                $allowed = $node->tagName === 'a' && in_array($name, ['href', 'target', 'rel'], true);
                if (! $allowed || ($name === 'href' && ! self::isSafeUrl($attribute->value))) {
                    $node->removeAttribute($attribute->name);
                }
            }

            if ($node->tagName === 'a') {
                $node->setAttribute('rel', 'noopener noreferrer');
            }

            self::sanitizeChildren($node);
        }
    }

    private static function isSafeUrl(string $url): bool
    {
        return str_starts_with($url, '/') || preg_match('/^(https?:|mailto:)/i', trim($url)) === 1;
    }
}
