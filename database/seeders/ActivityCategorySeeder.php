<?php

namespace Database\Seeders;

use App\Models\ActivityCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivityCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Pendidikan & Pengembangan Diri',
            'Sosial & Pengabdian Masyarakat',
            'Budaya & Pariwisata',
            'Pemuda & Kampus',
            'Internal IBGK',
        ];

        foreach ($categories as $index => $name) {
            ActivityCategory::query()->updateOrCreate(
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
