<?php

namespace App\Support;

use Symfony\Component\HtmlSanitizer\HtmlSanitizer;
use Symfony\Component\HtmlSanitizer\HtmlSanitizerConfig;

class SafeHtml
{
    private static ?HtmlSanitizer $sanitizer = null;

    public static function clean(?string $html): string
    {
        if (blank($html)) {
            return '';
        }

        return self::sanitizer()->sanitize($html);
    }

    private static function sanitizer(): HtmlSanitizer
    {
        if (self::$sanitizer !== null) {
            return self::$sanitizer;
        }

        $config = (new HtmlSanitizerConfig)
            ->allowSafeElements()
            ->allowAttribute('class', allowedElements: '*')
            ->allowAttribute('href', allowedElements: ['a'])
            ->allowAttribute('src', allowedElements: ['img'])
            ->allowAttribute('alt', allowedElements: ['img'])
            ->allowAttribute('title', allowedElements: ['a', 'img', 'span'])
            ->allowLinkSchemes(['https', 'http', 'mailto'])
            ->allowMediaSchemes(['https', 'http']);

        self::$sanitizer = new HtmlSanitizer($config);

        return self::$sanitizer;
    }
}
