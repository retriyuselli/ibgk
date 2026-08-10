<?php

namespace Database\Seeders;

use App\Models\Partner;
use App\Models\PartnerCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PartnerSeeder extends Seeder
{
    public function run(): void
    {
        $partners = [
            ['Dinas Pendidikan Provinsi Sumsel', 'Pemerintah', 1],
            ['Pemerintah Provinsi Sumatera Selatan', 'Pemerintah', 2],
            ['Universitas Sriwijaya', 'Perguruan Tinggi', 3],
            ['Politeknik Negeri Sriwijaya', 'Perguruan Tinggi', 4],
            ['Universitas Bina Darma', 'Perguruan Tinggi', 5],
            ['Bank Sumsel Babel', 'Perbankan', 6],
            ['Bank Indonesia', 'Perbankan', 7],
            ['PT Telkomsel', 'Corporate', 8],
            ['Wardah Cosmetics', 'Corporate', 9],
            ['Aston Palembang Hotel', 'Hotel', 10],
            ['Palembang Indah Mall', 'Corporate', 11],
            ['Sriwijaya Post', 'Media', 12],
            ['Sonora FM Palembang', 'Media', 13],
            ['PLN UID Sumsel', 'BUMN', 14],
            ['Pertamina', 'BUMN', 15],
            ['Komunitas Generasi Muda Sumsel', 'Community', 16],
            ['Dinas Pariwisata Provinsi Sumsel', 'Pemerintah', 17],
            ['Dinas Kebudayaan Provinsi Sumsel', 'Pemerintah', 18],
            ['Universitas Muhammadiyah Palembang', 'Perguruan Tinggi', 19],
            ['Bank Mandiri', 'Perbankan', 20],
            ['Telkom Indonesia', 'BUMN', 21],
            ['Metro TV Palembang', 'Media', 22],
        ];

        foreach ($partners as [$name, $categoryName, $sortOrder]) {
            $category = PartnerCategory::query()->where('name', $categoryName)->first();

            Partner::query()->updateOrCreate(
                ['slug' => Str::slug($name)],
                [
                    'partner_category_id' => $category?->id,
                    'name' => $name,
                    'description' => 'Mitra kolaborasi IBGK Sumatera Selatan.',
                    'sort_order' => $sortOrder,
                    'is_featured' => $sortOrder <= 12,
                    'is_active' => true,
                ]
            );
        }
    }
}
