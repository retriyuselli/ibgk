<?php

namespace Database\Seeders\Partners\Concerns;

use App\Models\Partner;
use App\Models\PartnerCategory;
use App\Services\PartnerShowcasePresets;

trait SeedsPartnerShowcase
{
    /** @param  array<string, mixed>  $overrides */
    protected function seedShowcasePartner(
        string $categorySlug,
        array $overrides = [],
    ): Partner {
        $category = PartnerCategory::query()
            ->where('slug', $categorySlug)
            ->firstOrFail();

        $name = $overrides['name'] ?? PartnerCategory::partnerNames()[$categorySlug] ?? $category->name;
        $slug = $overrides['slug'] ?? $categorySlug;
        $year = (int) ($overrides['showcase_year'] ?? now()->year);

        $preset = PartnerShowcasePresets::forCategory($categorySlug, $name, $year);

        unset($overrides['slug'], $overrides['name']);

        return Partner::query()->updateOrCreate(
            ['slug' => $slug],
            [
                ...$preset,
                'partner_category_id' => $category->id,
                'name' => $name,
                'slug' => $slug,
                'logo' => null,
                'website' => $overrides['website'] ?? null,
                'description' => $overrides['description'] ?? ($preset['showcase_intro'] ?? "Mitra kolaborasi IBGK Sumatera Selatan dari sektor {$name}."),
                'tier' => Partner::TIER_PLATINUM,
                'has_showcase_page' => true,
                'is_main_sponsor' => false,
                'is_featured' => true,
                'is_active' => true,
                'showcase_year' => $year,
                'sort_order' => $category->sort_order,
                ...$overrides,
            ],
        );
    }
}
