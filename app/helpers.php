<?php

use App\Support\SafeHtml;
use App\Support\SafeUrl;

if (! function_exists('clean_html')) {
    function clean_html(?string $html): string
    {
        return SafeHtml::clean($html);
    }
}

if (! function_exists('title_case')) {
    function title_case(?string $value): string
    {
        $value = trim(preg_replace('/\s+/u', ' ', (string) $value) ?? '');

        if ($value === '' || $value === '-') {
            return '';
        }

        return \Illuminate\Support\Str::title(mb_strtolower($value, 'UTF-8'));
    }
}

if (! function_exists('safe_url')) {
    function safe_url(?string $url): ?string
    {
        return SafeUrl::forHref($url);
    }
}

if (! function_exists('instagram_url')) {
    function instagram_url(?string $value): ?string
    {
        return SafeUrl::forInstagram($value);
    }
}

if (! function_exists('org_profile')) {
    function org_profile(?App\Models\OrganizationProfile $profile = null): App\Models\OrganizationProfile
    {
        if ($profile instanceof App\Models\OrganizationProfile) {
            return $profile;
        }

        static $fallback = null;

        return $fallback ??= App\Models\OrganizationProfile::make([
            'name' => 'Organisasi',
            'showcase_copy' => App\Models\OrganizationProfile::showcaseCopyDefaults(),
            'election_copy' => App\Models\OrganizationProfile::electionCopyDefaults(),
            'election_pillars' => App\Models\OrganizationProfile::electionPillarDefaults(),
        ]);
    }
}

if (! function_exists('site_image')) {
    /**
     * @param  array<string, mixed>  $attributes
     */
    function site_image(string $path, string $alt = '', array $attributes = []): string
    {
        $path = ltrim($path, '/');
        $lazy = (bool) ($attributes['lazy'] ?? true);
        $priority = (bool) ($attributes['priority'] ?? false);
        $class = $attributes['class'] ?? null;
        unset($attributes['lazy'], $attributes['priority'], $attributes['class']);

        $jpgUrl = asset($path);
        $webpPath = preg_replace('/\.jpe?g$/i', '.webp', $path);
        $webpUrl = is_file(public_path($webpPath)) ? asset($webpPath) : null;

        $htmlAttributes = collect($attributes)
            ->map(fn ($value, $key): string => $key.'="'.e($value).'"')
            ->all();

        if ($lazy && ! $priority) {
            $htmlAttributes[] = 'loading="lazy"';
        }

        if ($priority) {
            $htmlAttributes[] = 'fetchpriority="high"';
        }

        $htmlAttributes[] = 'decoding="async"';
        $attributeString = implode(' ', $htmlAttributes);
        $classAttr = $class ? ' class="'.e($class).'"' : '';

        if ($webpUrl) {
            return '<picture'.$classAttr.'>'
                .'<source srcset="'.e($webpUrl).'" type="image/webp">'
                .'<img src="'.e($jpgUrl).'" alt="'.e($alt).'"'.$classAttr.($attributeString !== '' ? ' '.$attributeString : '').'>'
                .'</picture>';
        }

        return '<img src="'.e($jpgUrl).'" alt="'.e($alt).'"'.$classAttr.($attributeString !== '' ? ' '.$attributeString : '').'>';
    }
}

if (! function_exists('site_image_or_storage')) {
    /**
     * @param  array<string, mixed>  $attributes
     */
    function site_image_or_storage(?string $storagePath, string $fallbackPath, string $alt = '', array $attributes = []): string
    {
        if (filled($storagePath)) {
            return site_image_from_src(asset('storage/'.$storagePath), $alt, $attributes);
        }

        return site_image($fallbackPath, $alt, $attributes);
    }
}

if (! function_exists('site_image_from_src')) {
    /**
     * @param  array<string, mixed>  $attributes
     */
    function site_image_from_src(string $src, string $alt = '', array $attributes = []): string
    {
        $path = parse_url($src, PHP_URL_PATH);

        if (is_string($path) && preg_match('#/(images/home/[^/?]+\.jpe?g)$#i', $path, $matches) === 1) {
            return site_image($matches[1], $alt, $attributes);
        }

        $class = $attributes['class'] ?? null;
        $lazy = (bool) ($attributes['lazy'] ?? true);
        $priority = (bool) ($attributes['priority'] ?? false);

        $htmlAttributes = ['src="'.e($src).'"', 'alt="'.e($alt).'"'];

        if ($class) {
            $htmlAttributes[] = 'class="'.e($class).'"';
        }

        if ($lazy && ! $priority) {
            $htmlAttributes[] = 'loading="lazy"';
        }

        if ($priority) {
            $htmlAttributes[] = 'fetchpriority="high"';
        }

        $htmlAttributes[] = 'decoding="async"';

        return '<img '.implode(' ', $htmlAttributes).'>';
    }
}
