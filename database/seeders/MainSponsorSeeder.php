<?php

namespace Database\Seeders;

use App\Models\Partner;
use Database\Seeders\Partners\Concerns\SeedsPartnerShowcase;
use Illuminate\Database\Seeder;

class MainSponsorSeeder extends Seeder
{
    use SeedsPartnerShowcase;

    public function run(): void
    {
        Partner::query()
            ->whereIn('slug', ['bank-mitra-utama', 'bank-syariah-indonesia'])
            ->update([
                'is_main_sponsor' => false,
                'is_active' => false,
                'has_showcase_page' => false,
            ]);

        $this->seedShowcasePartner('perbankan', [
            'tier' => Partner::TIER_PLATINUM,
            'is_main_sponsor' => true,
            'sort_order' => 0,
            'description' => 'Official Banking Partner Pemilihan Bujang Gadis Kampus Sumatera Selatan 2026.',
            'showcase_strategic_values' => [
                ['title' => 'Akses Generasi Muda Sumatera Selatan', 'description' => 'Terhubung langsung dengan ribuan mahasiswa dari berbagai kampus di Sumatera Selatan.', 'icon' => 'users'],
                ['title' => 'Akuisisi Nasabah dan Digital User', 'description' => 'Potensi pembukaan rekening baru dan aktivasi layanan perbankan digital dari peserta dan ekosistem kampus.', 'icon' => 'chart'],
                ['title' => 'Edukasi & Literasi Keuangan', 'description' => 'Bank menjadi mitra edukasi keuangan bagi generasi muda yang cerdas finansial dan berdaya saing.', 'icon' => 'book'],
                ['title' => 'Branding & Exposure yang Luas', 'description' => 'Eksposur brand bank melalui rangkaian roadshow kampus, konten digital, dan Grand Final.', 'icon' => 'megaphone'],
                ['title' => 'Transaction Value', 'description' => 'Seluruh transaksi kegiatan diarahkan melalui bank mitra untuk mendukung ekosistem cashless.', 'icon' => 'handshake'],
                ['title' => 'Citra Positif & Reputasi', 'description' => 'Bank dikenal sebagai mitra yang mendukung pendidikan, kepemimpinan, dan pengembangan generasi muda.', 'icon' => 'star'],
            ],
            'showcase_programs' => [
                ['title' => 'Akuisisi Nasabah Bank', 'description' => 'Seluruh peserta dan finalis didorong membuka rekening bank mitra dengan berbagai benefit eksklusif.', 'icon' => 'users'],
                ['title' => 'Aktivasi Mobile Banking', 'description' => 'Peserta dan finalis melakukan aktivasi layanan perbankan digital untuk kemudahan transaksi harian.', 'icon' => 'mobile'],
                ['title' => 'Campus Banking Activation', 'description' => 'Booth bank hadir di setiap roadshow kampus untuk pembukaan rekening, aktivasi digital, games, dan edukasi.', 'icon' => 'building'],
                ['title' => 'Kelas Literasi Keuangan', 'description' => 'Seminar literasi keuangan bersama bank mitra untuk meningkatkan pengetahuan finansial peserta dan finalis.', 'icon' => 'book'],
                ['title' => 'Kunjungan ke Bank', 'description' => 'Finalis berkunjung ke kantor bank untuk mengenal industri perbankan dan budaya kerja profesional.', 'icon' => 'map'],
                ['title' => 'Financial Challenge', 'description' => 'Challenge pengelolaan keuangan untuk finalis dengan hadiah menarik dan penghargaan khusus dari bank.', 'icon' => 'trophy'],
                ['title' => 'Bank Goes to Campus', 'description' => 'Bank hadir di kampus melalui program IBGK untuk edukasi generasi muda dan akuisisi nasabah.', 'icon' => 'campus'],
                ['title' => 'Official Transaction Partner', 'description' => 'Transaksi kegiatan IBGK diarahkan melalui produk/layanan bank (rekening, QRIS, payroll, dan lainnya).', 'icon' => 'card'],
                ['title' => 'Penghargaan Bank', 'description' => 'Penghargaan khusus dari bank mitra pada malam Grand Final untuk finalis terpilih.', 'icon' => 'award'],
                ['title' => 'Kolaborasi Konten Digital', 'description' => 'Konten kolaborasi bank dan finalis di media sosial (Instagram, TikTok, YouTube) untuk eksposur luas.', 'icon' => 'share'],
                ['title' => 'Aktivitas Brand Ambassador', 'description' => 'Pemenang Bujang Gadis Kampus Sumsel terlibat dalam kegiatan atau program pilihan bank mitra.', 'icon' => 'star'],
                ['title' => 'Lead Generation', 'description' => 'Akuisisi peserta/komunitas yang memberikan consent (opt-in) untuk dihubungi bank terkait produk & layanan.', 'icon' => 'database'],
            ],
            'showcase_benefits' => [
                ['title' => 'Akuisisi Nasabah Baru', 'description' => 'Potensi pembukaan rekening baru dari ribuan mahasiswa dan finalis BGK Sumsel.', 'icon' => 'users'],
                ['title' => 'Aktivasi Digital Banking', 'description' => 'Peningkatan aktivasi layanan perbankan digital dari peserta dan komunitas kampus.', 'icon' => 'mobile'],
                ['title' => 'Brand Exposure Luas', 'description' => 'Eksposur melalui roadshow kampus, konten digital, media partner, dan Grand Final.', 'icon' => 'spark'],
                ['title' => 'Engagement Generasi Muda', 'description' => 'Membangun hubungan jangka panjang dengan generasi muda yang produktif dan potensial.', 'icon' => 'heart'],
                ['title' => 'Transaction Value', 'description' => 'Peningkatan volume transaksi melalui produk/layanan bank selama rangkaian kegiatan.', 'icon' => 'chart'],
                ['title' => 'Association & Reputation', 'description' => 'Memperkuat citra bank sebagai mitra yang mendukung pendidikan dan pengembangan pemuda.', 'icon' => 'shield'],
            ],
            'showcase_kpis' => [
                ['value' => '2.000+', 'label' => 'Mahasiswa Terjangkau'],
                ['value' => '200+', 'label' => 'Pembukaan Rekening Baru'],
                ['value' => '200+', 'label' => 'Aktivasi Mobile Banking'],
                ['value' => '50+', 'label' => 'Konten Digital Kolaborasi'],
            ],
            'showcase_targets' => [
                ['label' => 'Peserta PBGK Sumsel 2026', 'value' => '300 – 500 orang'],
                ['label' => 'Finalis', 'value' => '20 – 30 orang'],
                ['label' => 'Roadshow Kampus', 'value' => '7 – 10 kampus'],
            ],
            'showcase_program_quote' => 'Bersama mitra perbankan, kita hadirkan program yang relevan, inspiratif, dan berdampak nyata bagi generasi muda Sumatera Selatan.',
            'showcase_partner_tagline' => 'Mitra Finansial Generasi Muda Sumatera Selatan',
            'showcase_footer_quote' => 'Bersama Perbankan, mewujudkan generasi muda Sumatera Selatan yang cerdas finansial, berkarakter, dan siap memimpin masa depan.',
        ]);
    }
}
