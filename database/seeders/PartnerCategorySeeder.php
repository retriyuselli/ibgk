<?php

namespace Database\Seeders;

use App\Models\PartnerCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartnerCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Pemerintah',
            'Perguruan Tinggi',
            'Perbankan',
            'BUMN',
            'Corporate',
            'Media',
            'Hotel',
            'Community',
        ];

        foreach ($categories as $index => $name) {
            PartnerCategory::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'name' => $name,
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
