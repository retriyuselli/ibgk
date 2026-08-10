<?php

namespace Database\Seeders;

use App\Models\Election;
use Illuminate\Database\Seeder;

class ElectionSeeder extends Seeder
{
    public function run(): void
    {
        $year = (int) now()->format('Y');
        $base = now()->setDate($year, 5, 1)->startOfDay();

        $election = Election::query()->updateOrCreate(
            ['slug' => 'pemilihan-bgk-'.$year],
            [
                'name' => 'Pemilihan Bujang Gadis Kampus Sumatera Selatan '.$year,
                'year' => $year,
                'theme' => 'Mencari Generasi Muda Kampus yang Berwawasan, Berbudaya, Berprestasi dan Berdampak.',
                'short_description' => 'Pemilihan Bujang Gadis Kampus Sumatera Selatan adalah ajang pembinaan generasi muda kampus untuk berkembang, berkarya, dan memberikan kontribusi nyata bagi masyarakat.',
                'description' => 'Pemilihan Bujang Gadis Kampus Sumatera Selatan merupakan program tahunan IBGK Sumsel untuk menemukan dan membina generasi muda kampus yang berwawasan, berbudaya, berprestasi, serta siap memberikan dampak positif bagi masyarakat.',
                'registration_start' => now()->subDays(7)->startOfDay(),
                'registration_end' => now()->addDays(90)->endOfDay(),
                'grand_final_date' => $base->copy()->addDays(100),
                'location' => 'Palembang, Sumatera Selatan',
                'status' => 'open',
                'is_active' => true,
            ]
        );

        $election->stages()->delete();
        $election->requirements()->delete();
        $election->benefits()->delete();

        $stages = [
            ['Pendaftaran', 'Pendaftaran online bagi mahasiswa/i Sumatera Selatan.', 0, 30],
            ['Seleksi Administrasi', 'Verifikasi berkas dan kelengkapan persyaratan.', 31, 45],
            ['Seleksi Wawancara', 'Penilaian kepribadian, wawasan, dan komunikasi.', 46, 60],
            ['Karantina & Pembinaan', 'Workshop, pelatihan, dan pembentukan karakter.', 61, 90],
            ['Grand Final', 'Malam puncak pemilihan Bujang dan Gadis Kampus.', 100, 100],
        ];

        foreach ($stages as $index => [$name, $description, $startOffset, $endOffset]) {
            $election->stages()->create([
                'name' => $name,
                'description' => $description,
                'start_date' => $base->copy()->addDays($startOffset),
                'end_date' => $base->copy()->addDays($endOffset),
                'sort_order' => $index + 1,
            ]);
        }

        $requirements = [
            'Mahasiswa/i aktif perguruan tinggi di Sumatera Selatan',
            'Usia 18–25 tahun pada tahun pemilihan',
            'Memiliki IPK minimal sesuai ketentuan panitia',
            'Berpenampilan menarik, beretika, dan berwawasan luas',
            'Bersedia mengikuti seluruh rangkaian kegiatan hingga selesai',
            'Tidak sedang terlibat kasus hukum',
        ];

        foreach ($requirements as $index => $requirement) {
            $election->requirements()->create([
                'requirement' => $requirement,
                'sort_order' => $index + 1,
            ]);
        }

        $benefits = [
            ['Pembinaan', 'Pelatihan kepemimpinan, komunikasi, dan soft skill.', 'academic-cap'],
            ['Jaringan & Relasi', 'Terhubung dengan alumni dan mitra lintas sektor.', 'users'],
            ['Pengalaman Berharga', 'Pengalaman panggung, kerja tim, dan manajemen diri.', 'sparkles'],
            ['Prestasi & Penghargaan', 'Pengakuan resmi sebagai Bujang/Gadis Kampus Sumsel.', 'trophy'],
        ];

        foreach ($benefits as $index => [$title, $description, $icon]) {
            $election->benefits()->create([
                'title' => $title,
                'description' => $description,
                'icon' => $icon,
                'sort_order' => $index + 1,
            ]);
        }
    }
}
