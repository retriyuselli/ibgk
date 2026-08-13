<?php

namespace Database\Seeders;

use App\Models\PartnerCategory;
use Illuminate\Database\Seeder;

class PartnerCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Pemerintah',
                'slug' => 'pemerintah',
                'showcase_theme' => PartnerCategory::THEME_GOVERNMENT,
                'official_partner_label' => 'Official Government Partner',
                'default_cta_label' => 'Kunjungi Instansi',
            ],
            [
                'name' => 'Perguruan Tinggi',
                'slug' => 'perguruan-tinggi',
                'showcase_theme' => PartnerCategory::THEME_DEFAULT,
                'official_partner_label' => 'Official Campus Partner',
                'default_cta_label' => 'Kunjungi Kampus',
            ],
            [
                'name' => 'Perbankan',
                'slug' => 'perbankan',
                'showcase_theme' => PartnerCategory::THEME_BANKING,
                'official_partner_label' => 'Official Banking Partner',
                'default_cta_label' => 'Kunjungi Bank',
            ],
            [
                'name' => 'BUMN',
                'slug' => 'bumn',
                'showcase_theme' => PartnerCategory::THEME_GOVERNMENT,
                'official_partner_label' => 'Official BUMN Partner',
                'default_cta_label' => 'Kunjungi BUMN',
            ],
            [
                'name' => 'Corporate',
                'slug' => 'corporate',
                'showcase_theme' => PartnerCategory::THEME_RETAIL,
                'official_partner_label' => 'Official Corporate Partner',
                'default_cta_label' => 'Kunjungi Perusahaan',
            ],
            [
                'name' => 'Media',
                'slug' => 'media',
                'showcase_theme' => PartnerCategory::THEME_MEDIA,
                'official_partner_label' => 'Official Media Partner',
                'default_cta_label' => 'Kunjungi Media Partner',
            ],
            [
                'name' => 'Hotel',
                'slug' => 'hotel',
                'showcase_theme' => PartnerCategory::THEME_TOURISM,
                'official_partner_label' => 'Official Hospitality Partner',
                'default_cta_label' => 'Kunjungi Hotel',
            ],
            [
                'name' => 'Community',
                'slug' => 'community',
                'showcase_theme' => PartnerCategory::THEME_DEFAULT,
                'official_partner_label' => 'Community Partner',
                'default_cta_label' => 'Kunjungi Komunitas',
            ],
        ];

        foreach ($categories as $index => $category) {
            PartnerCategory::query()->updateOrCreate(
                ['slug' => $category['slug']],
                [
                    'name' => $category['name'],
                    'showcase_theme' => $category['showcase_theme'],
                    'official_partner_label' => $category['official_partner_label'],
                    'default_cta_label' => $category['default_cta_label'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
