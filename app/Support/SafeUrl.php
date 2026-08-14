<?php

namespace App\Support;

class SafeUrl
{
    /** @var list<string> */
    private const ALLOWED_SCHEMES = ['http', 'https', 'mailto'];

    public static function forHref(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $url = trim($url);

        if (! filter_var($url, FILTER_VALIDATE_URL)) {
            $prefixed = str_starts_with($url, '//') ? 'https:'.$url : 'https://'.$url;

            if (! filter_var($prefixed, FILTER_VALIDATE_URL)) {
                return null;
            }

            $url = $prefixed;
        }

        $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));

        if (! in_array($scheme, self::ALLOWED_SCHEMES, true)) {
            return null;
        }

        return $url;
    }

    public static function forInstagram(?string $value): ?string
    {
        if (blank($value)) {
            return null;
        }

        $value = trim($value);

        if (preg_match('~(?:https?://)?(?:www\.)?instagram\.com/(.+)$~i', $value, $matches)) {
            $path = trim(explode('#', explode('?', $matches[1])[0])[0], '/');

            if ($path === '') {
                return null;
            }

            return self::forHref('https://www.instagram.com/'.$path);
        }

        $handle = ltrim($value, '@');
        $handle = trim($handle);

        if (preg_match('/^[A-Za-z0-9._]{1,30}$/', $handle) !== 1) {
            return null;
        }

        return self::forHref('https://www.instagram.com/'.$handle);
    }
}
