<?php

namespace Database\Seeders;

use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GalleryAlbumSeeder extends Seeder
{
    public function run(): void
    {
        $albums = [
            ['Grand Final BGK Sumsel 2024', 'Pemilihan BGK', 'Dokumentasi puncak pemilihan Bujang Gadis Kampus Sumatera Selatan.', -5, 'Palembang', true, 120],
            ['Aksi Tanam 1000 Pohon', 'Kegiatan Sosial', 'Gerakan peduli lingkungan bersama mahasiswa dan masyarakat.', -8, 'Palembang', true, 86],
            ['Seminar & Workshop Kepemimpinan', 'Kegiatan', 'Pelatihan kepemimpinan dan pengembangan karakter generasi muda.', -12, 'Palembang', true, 64],
            ['Festival Budaya Sumsel', 'Budaya & Pariwisata', 'Promosi budaya dan pariwisata daerah melalui pertunjukan seni.', -15, 'Palembang', true, 98],
            ['Rapat Kerja IBGK Sumsel', 'Internal IBGK', 'Penyusunan program kerja dan penguatan organisasi internal.', -18, 'Palembang', true, 42],
            ['Kolaborasi Mitra Daerah', 'Event & Kolaborasi', 'Sinergi kegiatan bersama pemerintah dan mitra strategis.', -22, 'Palembang', true, 55],
            ['Dokumentasi Seminar Kepemimpinan', 'Kegiatan', 'Materi dan suasana seminar generasi muda kampus.', -25, 'Palembang', false, 38],
            ['Bakti Sosial Desa Binaan', 'Kegiatan Sosial', 'Pengabdian masyarakat di desa binaan IBGK Sumsel.', -28, 'Ogan Ilir', false, 72],
            ['Forum Mahasiswa Se-Sumsel', 'Kegiatan', 'Diskusi lintas kampus tentang peran pemuda.', -32, 'Palembang', false, 45],
            ['Jelajah Heritage Palembang', 'Budaya & Pariwisata', 'Eksplorasi situs budaya dan sejarah kota Palembang.', -36, 'Palembang', false, 58],
            ['Pelantikan Pengurus Baru', 'Internal IBGK', 'Seremoni pelantikan dan arah kerja organisasi.', -40, 'Palembang', false, 33],
            ['Donor Darah IBGK Sumsel', 'Kegiatan Sosial', 'Aksi kemanusiaan bersama PMI dan relawan kampus.', -44, 'Palembang', false, 51],
            ['Roadshow Pemilihan BGK', 'Pemilihan BGK', 'Sosialisasi dan promosi ajang pemilihan BGK.', -48, 'Banyuasin', false, 67],
            ['Workshop Public Speaking', 'Kegiatan', 'Pelatihan komunikasi publik untuk peserta dan alumni.', -52, 'Palembang', false, 29],
            ['Pagelaran Seni Tradisional', 'Budaya & Pariwisata', 'Pentas seni tradisional Sumatera Selatan.', -56, 'Palembang', false, 74],
            ['Festival Kolaborasi Kampus', 'Event & Kolaborasi', 'Event kolaboratif antar perguruan tinggi se-Sumsel.', -60, 'Palembang', false, 61],
        ];

        foreach ($albums as $index => [$title, $category, $description, $dayOffset, $location, $featured, $photoCount]) {
            $album = GalleryAlbum::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'title' => $title,
                    'category' => $category,
                    'description' => $description,
                    'event_date' => now()->addDays($dayOffset)->toDateString(),
                    'location' => $location,
                    'is_featured' => $featured,
                    'is_published' => true,
                ]
            );

            if ($album->photos()->count() >= $photoCount) {
                continue;
            }

            $album->photos()->delete();

            $images = [
                'images/home/about-1.jpg',
                'images/home/about-2.jpg',
                'images/home/about-3.jpg',
                'images/home/about-4.jpg',
                'images/home/news-1.jpg',
                'images/home/news-2.jpg',
                'images/home/news-3.jpg',
                'images/home/election-poster.jpg',
                'images/home/sejarah-grand-final.jpg',
                'images/home/alumni-placeholder.jpg',
            ];

            $seedCount = min($photoCount, 12);

            for ($i = 0; $i < $seedCount; $i++) {
                GalleryPhoto::query()->create([
                    'gallery_album_id' => $album->id,
                    'image' => $images[($index + $i) % count($images)],
                    'caption' => $title.' — Foto '.($i + 1),
                    'sort_order' => $i + 1,
                ]);
            }
        }
    }
}
