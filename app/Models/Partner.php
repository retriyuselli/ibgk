<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Partner extends Model
{
    use HasFactory;

    public const TIER_PLATINUM = 'platinum';

    public const TIER_GOLD = 'gold';

    public const TIER_SILVER = 'silver';

    public const TIER_BRONZE = 'bronze';

    protected $fillable = [
        'partner_category_id',
        'name',
        'slug',
        'tier',
        'is_main_sponsor',
        'has_showcase_page',
        'logo',
        'website',
        'description',
        'tagline',
        'hero_image',
        'showcase_year',
        'showcase_intro',
        'showcase_official_title',
        'showcase_official_subtext',
        'showcase_programs',
        'showcase_timeline',
        'showcase_activations',
        'showcase_benefits',
        'showcase_kpis',
        'showcase_targets',
        'showcase_program_quote',
        'showcase_partner_tagline',
        'showcase_strategic_values',
        'showcase_footer_quote',
        'showcase_social_handle',
        'showcase_privacy_note',
        'external_cta_label',
        'sort_order',
        'is_featured',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'sort_order' => 'integer',
            'showcase_year' => 'integer',
            'is_main_sponsor' => 'boolean',
            'has_showcase_page' => 'boolean',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
            'showcase_programs' => 'array',
            'showcase_timeline' => 'array',
            'showcase_activations' => 'array',
            'showcase_benefits' => 'array',
            'showcase_kpis' => 'array',
            'showcase_targets' => 'array',
            'showcase_strategic_values' => 'array',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(PartnerCategory::class, 'partner_category_id');
    }

    public function partnerCategory(): BelongsTo
    {
        return $this->category();
    }

    public function logoUrl(): ?string
    {
        if (blank($this->logo)) {
            return null;
        }

        if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        }

        if (str_starts_with($this->logo, 'images/')) {
            return asset($this->logo);
        }

        return asset('storage/'.$this->logo);
    }

    public function heroImageUrl(): ?string
    {
        if (blank($this->hero_image)) {
            return null;
        }

        if (str_starts_with($this->hero_image, 'http://') || str_starts_with($this->hero_image, 'https://')) {
            return $this->hero_image;
        }

        if (str_starts_with($this->hero_image, 'images/')) {
            return asset($this->hero_image);
        }

        return asset('storage/'.$this->hero_image);
    }

    public function tierLabel(): ?string
    {
        return match ($this->tier) {
            self::TIER_PLATINUM => 'Platinum Main Partner',
            self::TIER_GOLD => 'Gold Partner',
            self::TIER_SILVER => 'Silver Partner',
            self::TIER_BRONZE => 'Bronze Partner',
            default => null,
        };
    }

    public function showcaseUrl(): ?string
    {
        if (! $this->has_showcase_page || ! $this->is_active) {
            return null;
        }

        return route('partnership.show', $this);
    }

    public function publicLinkUrl(): ?string
    {
        return $this->showcaseUrl() ?? safe_url($this->website);
    }

    public function externalWebsiteUrl(): ?string
    {
        return safe_url($this->website);
    }

    public function showcaseShortName(): string
    {
        $short = trim(str($this->name)->before(' ')->toString());

        return $short !== '' ? str($short)->upper()->toString() : 'BANK';
    }

    public function usesOfficeIcon(): bool
    {
        return blank($this->logo) || str_contains((string) $this->logo, 'bank-logo');
    }

    /** @return array<int, array{value: string, label: string, is_total?: bool}> */
    public function showcaseKpisForDisplay(): array
    {
        $kpis = $this->showcase_kpis ?? [];

        if ($kpis === []) {
            return [];
        }

        $baseKpis = [];
        $total = 0;

        foreach ($kpis as $kpi) {
            $label = (string) ($kpi['label'] ?? '');

            if (str_contains(strtolower($label), 'estimasi reach')) {
                continue;
            }

            $baseKpis[] = $kpi;
            $total += self::parseKpiNumericValue((string) ($kpi['value'] ?? '0'));
        }

        if ($total > 0) {
            $baseKpis[] = [
                'value' => self::formatKpiTotal($total),
                'label' => 'Estimasi Reach (Online & Offline)',
                'is_total' => true,
            ];
        }

        return $baseKpis;
    }

    public static function parseKpiNumericValue(string $value): int
    {
        $digits = preg_replace('/\D/', '', str_replace('.', '', $value));

        return (int) ($digits ?: 0);
    }

    public static function formatKpiTotal(int $total): string
    {
        return number_format($total, 0, ',', '.').'+';
    }
}
