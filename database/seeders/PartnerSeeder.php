<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\PartnerCategory;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $categorySlugs = array_keys(PartnerCategory::partnerNames());

        Partner::query()
            ->whereNotIn('slug', $categorySlugs)
            ->update(['is_active' => false, 'is_main_sponsor' => false, 'has_showcase_page' => false]);

        foreach (PartnerCategory::partnerNames() as $slug => $name) {
            $category = PartnerCategory::query()->where('slug', $slug)->first();

            Partner::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'partner_category_id' => $category?->id,
                    'name' => $name,
                    'description' => "Mitra kolaborasi IBGK Sumatera Selatan dari sektor {$name}.",
                    'logo' => null,
                    'website' => null,
                    'sort_order' => $category?->sort_order ?? 0,
                    'is_featured' => true,
                    'is_active' => true,
                    'is_main_sponsor' => false,
                    'has_showcase_page' => false,
                ],
            );
        }
    }
}
