<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'founded_at',
        'founder',
        'short_description',
        'description',
        'vision',
        'mission',
        'logo',
        'address',
        'phone',
        'email',
        'website',
        'instagram',
        'tiktok',
        'youtube',
        'facebook',
        'showcase_copy',
        'showcase_hero_background',
    ];

    protected function casts(): array
    {
        return [
            'founded_at' => 'date',
            'showcase_copy' => 'array',
        ];
    }

    public function formalName(): string
    {
        return filled($this->name) ? $this->name : 'Organisasi';
    }

    public function displayShortName(): string
    {
        if (filled($this->short_name)) {
            return $this->short_name;
        }

        return $this->formalName();
    }

    public function instagramHandle(): ?string
    {
        return $this->socialHandleFromUrl($this->instagram);
    }

    public function socialHandleFromUrl(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $url = trim($url);

        if (str_starts_with($url, '@')) {
            return $url;
        }

        if (preg_match('~(?:instagram|facebook|tiktok|youtube)\.com/(?:@)?([^/?#]+)~i', $url, $matches)) {
            return '@'.ltrim($matches[1], '@');
        }

        return null;
    }

    /** @return array<string, string> */
    public static function showcaseCopyDefaults(): array
    {
        return [
            'strategic_heading' => 'Mengapa Kolaborasi Ini Strategis untuk :partner?',
            'benefits_heading' => 'Manfaat Kerja Sama untuk :partner',
            'kpi_heading' => 'Indikator Keberhasilan (KPI)',
            'targets_heading' => 'Target Peserta & Jangkauan',
            'contact_heading' => 'Hubungi Kami',
            'program_count_suffix' => 'Program Kolaborasi Strategis',
            'hero_placeholder_hint' => 'Foto brand ambassador dapat diunggah melalui panel admin mitra.',
            'default_footer_quote' => 'Bersama :partner, mewujudkan generasi muda Sumatera Selatan yang berkarakter, berprestasi, dan siap memimpin masa depan.',
        ];
    }

    /** @param  array<string, string>  $replace */
    public function showcaseCopy(string $key, array $replace = []): string
    {
        $copy = array_merge(static::showcaseCopyDefaults(), $this->showcase_copy ?? []);
        $text = $copy[$key] ?? static::showcaseCopyDefaults()[$key] ?? '';

        $replacements = [];

        foreach ($replace as $placeholder => $value) {
            $replacements[':'.$placeholder] = $value;
        }

        return strtr($text, $replacements);
    }

    public function showcaseProgramCountLabel(int $count): string
    {
        return trim($count.' '.$this->showcaseCopy('program_count_suffix'));
    }

    public function showcaseHeroBackgroundFallbackPath(): string
    {
        if (filled($this->showcase_hero_background) && str_starts_with($this->showcase_hero_background, 'images/')) {
            return $this->showcase_hero_background;
        }

        return 'images/home/hero-ampera.jpg';
    }

    public function showcaseHeroBackgroundStoragePath(): ?string
    {
        if (blank($this->showcase_hero_background) || str_starts_with($this->showcase_hero_background, 'images/')) {
            return null;
        }

        return $this->showcase_hero_background;
    }

    public function logoUrl(): ?string
    {
        if (blank($this->logo)) {
            return null;
        }

        return asset('storage/'.$this->logo);
    }
}
