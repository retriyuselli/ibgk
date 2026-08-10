<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            ['Kegiatan', 'IBGK Sumsel Gelar Seminar Kepemimpinan Generasi Muda', 'Seminar membahas karakter, kepemimpinan, dan kontribusi sosial generasi muda kampus.', 'Palembang', -2, 420],
            ['Sosial', 'Aksi Bakti Sosial IBGK di Desa Binaan Ogan Ilir', 'Kegiatan pengabdian masyarakat bersama relawan dan mitra lokal.', 'Ogan Ilir', -4, 380],
            ['Budaya', 'Festival Budaya Sumsel Hadirkan Generasi Muda Kampus', 'Promosi budaya dan pariwisata daerah melalui pertunjukan dan pameran.', 'Palembang', -6, 510],
            ['Prestasi', 'Finalis IBGK Sumsel Raih Penghargaan Nasional', 'Prestasi membanggakan dari perwakilan Sumatera Selatan di tingkat nasional.', 'Jakarta', -8, 290],
            ['Pendidikan', 'Workshop Public Speaking untuk Mahasiswa Sumsel', 'Pelatihan komunikasi publik dan presentasi efektif.', 'Palembang', -10, 340],
            ['Internal', 'Rapat Kerja IBGK Sumsel Susun Program Tahunan', 'Penyusunan agenda strategis dan penguatan soliditas organisasi.', 'Palembang', -12, 180],
            ['Kegiatan', 'Donor Darah IBGK Sumsel Bersama PMI', 'Aksi kemanusiaan yang diikuti ratusan relawan muda.', 'Palembang', -14, 460],
            ['Sosial', 'Program Beasiswa untuk Anak Kurang Mampu', 'Distribusi bantuan pendidikan bagi siswa berprestasi.', 'Banyuasin', -16, 320],
            ['Budaya', 'Jelajah Heritage Palembang Bersama Peserta BGK', 'Eksplorasi situs budaya dan sejarah kota Palembang.', 'Palembang', -18, 275],
            ['Prestasi', 'Tim IBGK Sumsel Juara Lomba Karya Tulis', 'Karya ilmiah peserta meraih juara di kompetisi regional.', 'Bandar Lampung', -20, 210],
            ['Pendidikan', 'Pelatihan Digital Literacy untuk Pemuda Desa', 'Peningkatan literasi digital dan kreativitas konten positif.', 'Muara Enim', -22, 195],
            ['Kegiatan', 'Forum Mahasiswa Se-Sumsel Bahas Isu Kepemudaan', 'Diskusi lintas kampus tentang peran pemuda di era digital.', 'Palembang', -24, 365],
            ['Sosial', 'Penanaman Ribuan Pohon di Kawasan Hutan Kota', 'Gerakan peduli lingkungan bersama komunitas kampus.', 'Palembang', -26, 240],
            ['Budaya', 'Pagelaran Seni Tradisional Sumsel di Taman Kambang Iwak', 'Pentas seni tradisional menghadirkan kekayaan budaya lokal.', 'Palembang', -28, 330],
            ['Internal', 'Pelantikan Pengurus IBGK Sumsel Periode Baru', 'Seremoni pelantikan dan arah kerja organisasi ke depan.', 'Palembang', -30, 150],
            ['Prestasi', 'Alumni IBGK Sumsel Terima Apresiasi Mitra Daerah', 'Penghargaan atas kontribusi sosial dan budaya berkelanjutan.', 'Palembang', -32, 220],
            ['Pendidikan', 'Mentoring Karakter untuk Calon Finalis BGK', 'Program pendampingan intensif menjelang ajang pemilihan.', 'Palembang', -34, 260],
            ['Kegiatan', 'Kolaborasi Budaya dan Pariwisata Bersama Mitra', 'Sinergi promosi destinasi wisata dan identitas budaya Sumsel.', 'Lahat', -36, 305],
        ];

        foreach ($samples as [$categoryName, $title, $excerpt, $location, $dayOffset, $views]) {
            $category = NewsCategory::query()->where('name', $categoryName)->first();

            if (! $category) {
                continue;
            }

            News::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'news_category_id' => $category->id,
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'content' => '<p>'.$excerpt.'</p>',
                    'location' => $location,
                    'is_featured' => in_array($categoryName, ['Kegiatan', 'Prestasi', 'Budaya'], true),
                    'is_published' => true,
                    'published_at' => now()->addDays($dayOffset),
                    'views' => $views,
                ]
            );
        }
    }
}
