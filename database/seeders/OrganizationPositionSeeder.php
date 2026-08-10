<?php

namespace Database\Seeders;

use App\Models\OrganizationPosition;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrganizationPositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'Ketua Umum',
            'Wakil Ketua',
            'Sekretaris',
            'Bendahara',
            'Ketua Bidang',
            'Anggota',
        ];

        foreach ($positions as $index => $name) {
            OrganizationPosition::query()->updateOrCreate(
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
