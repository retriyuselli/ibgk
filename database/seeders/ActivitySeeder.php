<?php

namespace Database\Seeders;

use App\Models\Activity;
use App\Models\ActivityCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ActivitySeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            ['Pendidikan & Pengembangan Diri', 'Seminar Kepemimpinan Generasi Muda', 'Pelatihan kepemimpinan dan karakter bagi mahasiswa Sumatera Selatan.', 'Palembang', -40],
            ['Sosial & Pengabdian Masyarakat', 'Bakti Sosial Desa Binaan', 'Kegiatan pengabdian masyarakat bersama warga dan mitra lokal.', 'Ogan Ilir', -35],
            ['Budaya & Pariwisata', 'Festival Budaya Sumsel', 'Promosi budaya dan pariwisata daerah bersama generasi muda kampus.', 'Palembang', -30],
            ['Pemuda & Kampus', 'Forum Mahasiswa Se-Sumsel', 'Diskusi lintas kampus tentang isu kepemudaan dan kontribusi sosial.', 'Palembang', -25],
            ['Internal IBGK', 'Rapat Kerja IBGK Sumsel', 'Penyusunan program dan penguatan soliditas pengurus serta alumni.', 'Palembang', -20],
            ['Pendidikan & Pengembangan Diri', 'Workshop Public Speaking', 'Pelatihan komunikasi publik untuk finalis dan alumni muda.', 'Palembang', -15],
            ['Sosial & Pengabdian Masyarakat', 'Donor Darah IBGK', 'Aksi kemanusiaan bersama PMI dan komunitas kampus.', 'Palembang', -10],
            ['Budaya & Pariwisata', 'Jelajah Heritage Palembang', 'Eksplorasi situs budaya dan sejarah kota bersama peserta.', 'Palembang', -5],
        ];

        foreach ($samples as $index => [$categoryName, $title, $excerpt, $location, $dayOffset]) {
            $category = ActivityCategory::query()->where('name', $categoryName)->first();

            if (! $category) {
                continue;
            }

            Activity::query()->updateOrCreate(
                ['slug' => Str::slug($title)],
                [
                    'activity_category_id' => $category->id,
                    'title' => $title,
                    'excerpt' => $excerpt,
                    'content' => '<p>'.$excerpt.'</p>',
                    'activity_date' => now()->addDays($dayOffset)->toDateString(),
                    'location' => $location,
                    'is_featured' => true,
                    'is_published' => true,
                    'published_at' => now()->addDays($dayOffset - 2),
                ]
            );
        }

        $descriptions = [
            'Pendidikan & Pengembangan Diri' => 'Program pelatihan, seminar, dan pengembangan soft skill generasi muda.',
            'Sosial & Pengabdian Masyarakat' => 'Aksi sosial dan pengabdian untuk memberi manfaat bagi masyarakat.',
            'Budaya & Pariwisata' => 'Pelestarian budaya serta promosi potensi pariwisata Sumsel.',
            'Pemuda & Kampus' => 'Kolaborasi lintas kampus dan penguatan peran pemuda.',
            'Internal IBGK' => 'Penguatan organisasi, soliditas anggota, dan tata kelola internal.',
        ];

        foreach ($descriptions as $name => $description) {
            ActivityCategory::query()
                ->where('name', $name)
                ->where(function ($query): void {
                    $query->whereNull('description')->orWhere('description', '');
                })
                ->update(['description' => $description]);
        }
    }
}
