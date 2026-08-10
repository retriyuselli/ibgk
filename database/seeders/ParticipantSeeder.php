<?php

namespace Database\Seeders;

use App\Models\Election;
use App\Models\Participant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ParticipantSeeder extends Seeder
{
    public function run(): void
    {
        $election = Election::query()->where('is_active', true)->latest('year')->first();

        if (! $election) {
            return;
        }

        $samples = [
            ['female', 'Siti Rahma Dewi', 'Universitas Sriwijaya', 'Fakultas Hukum', 'Palembang', 'Mewujudkan generasi muda yang berintegritas dan berdampak.'],
            ['male', 'Ahmad Fauzi Pratama', 'Politeknik Negeri Sriwijaya', 'Teknik Informatika', 'Palembang', 'Teknologi dan budaya untuk Sumatera Selatan yang lebih baik.'],
            ['female', 'Citra Melati Sari', 'Universitas Muhammadiyah Palembang', 'Ilmu Komunikasi', 'Palembang', 'Menyuarakan semangat pemuda dengan etika dan kearifan lokal.'],
            ['male', 'Dian Pratama Wijaya', 'Universitas Tridinanti', 'Manajemen', 'Palembang', 'Kepemimpinan muda yang inspiratif dan berkontribusi sosial.'],
            ['female', 'Eka Putri Anggraini', 'Universitas PGRI Palembang', 'Pendidikan Bahasa Inggris', 'Prabumulih', 'Mendidik dan menginspirasi melalui peran aktif di kampus.'],
            ['male', 'Fajar Nugraha Saputra', 'Universitas Sriwijaya', 'Teknik Sipil', 'Palembang', 'Membangun karakter kuat dan jejaring positif lintas kampus.'],
            ['female', 'Gita Safira Lestari', 'IAIN Raden Fatah', 'Pendidikan Agama Islam', 'Palembang', 'Menjaga nilai budaya sambil berkarya di era digital.'],
            ['male', 'Hendra Wijaya Kusuma', 'Universitas Bina Darma', 'Sistem Informasi', 'Palembang', 'Inovasi dan kolaborasi untuk kemajuan generasi muda Sumsel.'],
        ];

        foreach ($samples as $index => [$gender, $name, $university, $studyProgram, $city, $motto]) {
            Participant::query()->updateOrCreate(
                [
                    'election_id' => $election->id,
                    'slug' => Str::slug($name.'-'.$election->year),
                ],
                [
                    'registration_number' => sprintf('BGK-%d-%04d', $election->year, $index + 1),
                    'gender' => $gender,
                    'full_name' => $name,
                    'university' => $university,
                    'study_program' => $studyProgram,
                    'city' => $city,
                    'motto' => $motto,
                    'status' => 'active',
                    'is_public' => true,
                ]
            );
        }
    }
}
