<?php

namespace App\Support;

class SiteTheme
{
    public const CLASSIC = 'classic';

    public const FESTIVAL = 'festival';

    public const STORAGE_KEY = 'ibgk-site-theme';

    /** @return list<string> */
    public static function all(): array
    {
        return [self::CLASSIC, self::FESTIVAL];
    }

    /** @return array<string, string> */
    public static function options(): array
    {
        return [
            self::CLASSIC => 'Klasik (Navy & Emas)',
            self::FESTIVAL => 'Festival (Magenta & Emas)',
        ];
    }

    public static function default(): string
    {
        return self::CLASSIC;
    }

    public static function isValid(?string $theme): bool
    {
        return in_array($theme, self::all(), true);
    }

    public static function normalize(?string $theme): string
    {
        return self::isValid($theme) ? $theme : self::default();
    }
}
