<?php

namespace Database\Seeders;

use App\Models\OrganizationPosition;
use Illuminate\Database\Seeder;

class OrganizationPositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            ['name' => 'Ketua Umum', 'slug' => 'ketua-umum'],
            ['name' => 'Wakil Ketua Umum', 'slug' => 'wakil-ketua'],
            ['name' => 'Sekretaris Umum', 'slug' => 'sekretaris'],
            ['name' => 'Bendahara Umum', 'slug' => 'bendahara'],
            ['name' => 'Humas & Publikasi', 'slug' => 'humas-publikasi'],
            ['name' => 'Ketua Bidang', 'slug' => 'ketua-bidang'],
            ['name' => 'Anggota', 'slug' => 'anggota'],
        ];

        foreach ($positions as $index => $position) {
            OrganizationPosition::query()->updateOrCreate(
                ['slug' => $position['slug']],
                [
                    'name' => $position['name'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
