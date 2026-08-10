<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\AlumniBatch;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $batch = AlumniBatch::query()->where('year', 2002)->first();

        if (! $batch) {
            return;
        }

        $samples = [
            ['Romi Febriansyah', 'male', 'Universitas Sriwijaya', 'Entrepreneur', 'Palembang'],
            ['Ayu Lestari', 'female', 'Universitas Sriwijaya', 'Dosen', 'Palembang'],
            ['Budi Santoso', 'male', 'Politeknik Negeri Sriwijaya', 'ASN', 'Palembang'],
            ['Citra Melati', 'female', 'Universitas Muhammadiyah Palembang', 'Dokter', 'Lubuklinggau'],
            ['Dian Pratama', 'male', 'Universitas Tridinanti', 'Banker', 'Palembang'],
            ['Eka Putri', 'female', 'Universitas PGRI Palembang', 'Guru', 'Prabumulih'],
            ['Fajar Nugraha', 'male', 'Universitas Sriwijaya', 'Pengusaha', 'Palembang'],
            ['Gita Safira', 'female', 'IAIN Raden Fatah', 'Content Creator', 'Palembang'],
            ['Hendra Wijaya', 'male', 'Universitas Bina Darma', 'IT Consultant', 'Jakarta'],
            ['Indah Permata', 'female', 'Universitas Sriwijaya', 'Marketing Manager', 'Palembang'],
            ['Joko Susilo', 'male', 'Universitas Muhammadiyah Palembang', 'Lawyer', 'Palembang'],
            ['Kartika Sari', 'female', 'Politeknik Negeri Sriwijaya', 'Architect', 'Palembang'],
        ];

        foreach ($samples as $index => [$name, $gender, $university, $profession, $city]) {
            Alumni::query()->updateOrCreate(
                [
                    'alumni_batch_id' => $batch->id,
                    'slug' => Str::slug($name.'-2002'),
                ],
                [
                    'gender' => $gender,
                    'name' => $name,
                    'university' => $university,
                    'profession' => $profession,
                    'city' => $city,
                    'is_public' => true,
                    'is_active' => true,
                ]
            );
        }
    }
}
