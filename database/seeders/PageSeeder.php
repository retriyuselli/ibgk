<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            'home' => [
                'title' => 'Ikatan Bujang Gadis Kampus Sumatera Selatan',
                'meta_title' => 'Muda, Berbudaya, Berprestasi, dan Menginspirasi.',
                'excerpt' => 'Wadah pemersatu para alumni dan finalis Pemilihan Bujang Gadis Kampus Sumatera Selatan.',
                'meta_description' => 'Ikatan Bujang Gadis Kampus Sumatera Selatan — wadah pemersatu alumni dan finalis Pemilihan BGK Sumsel.',
            ],
            'about' => [
                'title' => 'Tentang IBGK Sumatera Selatan',
                'excerpt' => 'Ikatan Bujang Gadis Kampus Sumatera Selatan merupakan wadah pemersatu para alumni dan finalis Pemilihan Bujang Gadis Kampus Sumatera Selatan.',
                'meta_title' => 'Tentang IBGK Sumatera Selatan',
                'meta_description' => 'Kenali sejarah, visi, misi, dan perjalanan IBGK Sumatera Selatan.',
            ],
            'alumni' => [
                'title' => 'Alumni IBGK Sumatera Selatan',
                'excerpt' => 'Keluarga besar IBGK Sumsel terdiri dari finalis Pemilihan Bujang Gadis Kampus dari berbagai perguruan tinggi di Sumatera Selatan yang terus berkarya dan berkontribusi.',
                'meta_title' => 'Alumni IBGK Sumatera Selatan',
                'meta_description' => 'Direktori alumni dan finalis Pemilihan BGK Sumatera Selatan.',
            ],
            'activities' => [
                'title' => 'Kegiatan IBGK Sumatera Selatan',
                'excerpt' => 'Rangkaian program pendidikan, sosial, budaya, dan kepemudaan yang menjadi wadah kontribusi nyata IBGK Sumsel bagi masyarakat dan generasi muda kampus.',
                'meta_title' => 'Kegiatan IBGK Sumatera Selatan',
                'meta_description' => 'Program dan kegiatan IBGK Sumsel — pendidikan, sosial, budaya, dan kepemudaan.',
            ],
            'news' => [
                'title' => 'Berita IBGK Sumatera Selatan',
                'excerpt' => 'Ikuti perkembangan terbaru kegiatan, prestasi, dan kontribusi IBGK Sumsel bagi generasi muda kampus dan masyarakat Sumatera Selatan.',
                'meta_title' => 'Berita IBGK Sumatera Selatan',
                'meta_description' => 'Berita dan informasi terbaru seputar IBGK Sumatera Selatan.',
            ],
            'gallery' => [
                'title' => 'Galeri IBGK Sumatera Selatan',
                'excerpt' => 'Abadikan momen perjalanan IBGK Sumsel — dari pemilihan BGK, kegiatan sosial, budaya, hingga kolaborasi yang menginspirasi generasi muda kampus.',
                'meta_title' => 'Galeri IBGK Sumatera Selatan',
                'meta_description' => 'Galeri foto kegiatan dan momen IBGK Sumatera Selatan.',
            ],
            'partnership' => [
                'title' => 'Kemitraan',
                'meta_title' => 'IBGK Sumatera Selatan',
                'excerpt' => 'Kolaborasi bersama mitra strategis memperkuat peran generasi muda kampus Sumatera Selatan dalam pendidikan, sosial, budaya, dan kepemimpinan.',
                'meta_description' => 'Informasi kemitraan dan kolaborasi dengan IBGK Sumatera Selatan.',
            ],
            'contact' => [
                'title' => 'Kontak',
                'meta_title' => 'IBGK Sumatera Selatan',
                'excerpt' => 'Kami terbuka untuk pertanyaan, informasi kegiatan, dan kolaborasi. Hubungi tim IBGK Sumsel melalui kanal resmi berikut.',
                'meta_description' => 'Bersama, Berbudaya, Berprestasi, Menginspirasi.',
            ],
            'privacy-policy' => [
                'title' => 'Kebijakan Privasi',
                'excerpt' => 'Kebijakan privasi penggunaan situs web IBGK Sumatera Selatan.',
                'meta_title' => 'Kebijakan Privasi — IBGK Sumsel',
                'meta_description' => 'Kebijakan privasi IBGK Sumatera Selatan.',
            ],
            'terms' => [
                'title' => 'Syarat & Ketentuan',
                'excerpt' => 'Syarat dan ketentuan penggunaan situs web IBGK Sumatera Selatan.',
                'meta_title' => 'Syarat & Ketentuan — IBGK Sumsel',
                'meta_description' => 'Syarat dan ketentuan IBGK Sumatera Selatan.',
            ],
        ];

        foreach ($pages as $slug => $data) {
            Page::query()->updateOrCreate(
                ['slug' => $slug],
                [
                    'title' => $data['title'],
                    'meta_title' => $data['meta_title'] ?? null,
                    'excerpt' => $data['excerpt'],
                    'meta_description' => $data['meta_description'] ?? null,
                    'is_published' => true,
                    'published_at' => now(),
                ]
            );
        }
    }
}
