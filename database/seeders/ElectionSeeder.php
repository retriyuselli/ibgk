<?php

namespace Database\Seeders;

use App\Models\AlumniBatch;
use App\Models\Election;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

class ElectionSeeder extends Seeder
{
    private const LOCATION = 'Palembang, Sumatera Selatan';

    private const DEFAULT_THEME = 'Mencari Generasi Muda Kampus yang Berwawasan, Berbudaya, Berprestasi dan Berdampak.';

    private const SHORT_DESCRIPTION = 'Pemilihan Bujang Gadis Kampus Sumatera Selatan adalah ajang pembinaan generasi muda kampus untuk berkembang, berkarya, dan memberikan kontribusi nyata bagi masyarakat.';

    private const DESCRIPTION = 'Pemilihan Bujang Gadis Kampus Sumatera Selatan merupakan program tahunan IBGK Sumsel untuk menemukan dan membina generasi muda kampus yang berwawasan, berbudaya, berprestasi, serta siap memberikan dampak positif bagi masyarakat.';

    public function run(): void
    {
        $currentYear = (int) now()->format('Y');
        $firstYear = AlumniBatch::FIRST_ELECTION_YEAR;

        $this->cleanupDuplicateElections($firstYear, $currentYear);

        for ($year = $firstYear; $year < $currentYear; $year++) {
            $this->seedHistoricalElection($year);
        }

        $this->seedCurrentElection($currentYear);
        $this->linkAlumniBatches();
    }

    private function cleanupDuplicateElections(int $firstYear, int $currentYear): void
    {
        for ($year = $firstYear; $year <= $currentYear; $year++) {
            $canonicalSlug = 'pemilihan-bgk-'.$year;
            $canonical = Election::query()->where('slug', $canonicalSlug)->first();

            Election::query()
                ->where('year', $year)
                ->when($canonical, fn ($query) => $query->whereKeyNot($canonical->id))
                ->delete();
        }
    }

    private function seedHistoricalElection(int $year): void
    {
        Election::query()->updateOrCreate(
            ['year' => $year],
            [
                'slug' => 'pemilihan-bgk-'.$year,
                'name' => 'Pemilihan Bujang Gadis Kampus Sumatera Selatan '.$year,
                'theme' => $year === AlumniBatch::FIRST_ELECTION_YEAR
                    ? 'Pemilihan Perdana Bujang Gadis Kampus Sumatera Selatan'
                    : self::DEFAULT_THEME,
                'short_description' => $year === AlumniBatch::FIRST_ELECTION_YEAR
                    ? 'Pemilihan Bujang Gadis Kampus Sumsel digelar untuk pertama kali pada tahun 2002.'
                    : self::SHORT_DESCRIPTION,
                'description' => self::DESCRIPTION,
                'registration_start' => Carbon::create($year, 3, 1)->startOfDay(),
                'registration_end' => Carbon::create($year, 5, 31)->endOfDay(),
                'grand_final_date' => Carbon::create($year, 8, 14),
                'location' => self::LOCATION,
                'status' => 'finished',
                'is_active' => false,
            ]
        );
    }

    private function seedCurrentElection(int $year): void
    {
        $base = now()->setDate($year, 5, 1)->startOfDay();

        $election = Election::query()->updateOrCreate(
            ['year' => $year],
            [
                'slug' => 'pemilihan-bgk-'.$year,
                'name' => 'Pemilihan Bujang Gadis Kampus Sumatera Selatan '.$year,
                'theme' => self::DEFAULT_THEME,
                'short_description' => self::SHORT_DESCRIPTION,
                'description' => self::DESCRIPTION,
                'registration_start' => now()->subDays(7)->startOfDay(),
                'registration_end' => now()->addDays(90)->endOfDay(),
                'grand_final_date' => $base->copy()->addDays(100),
                'location' => self::LOCATION,
                'status' => 'open',
                'is_active' => true,
            ]
        );

        Election::query()
            ->whereKeyNot($election->id)
            ->update(['is_active' => false]);

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

    private function linkAlumniBatches(): void
    {
        AlumniBatch::syncElectionYearBatches();

        Election::query()
            ->orderBy('year')
            ->each(function (Election $election): void {
                AlumniBatch::query()
                    ->election()
                    ->where('year', $election->year)
                    ->update(['election_id' => $election->id]);
            });
    }
}
