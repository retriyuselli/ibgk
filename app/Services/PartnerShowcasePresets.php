<?php

namespace App\Services;

use App\Models\PartnerCategory;

class PartnerShowcasePresets
{
    /** @return array<string, mixed> */
    public static function forCategory(?string $categorySlug, ?string $partnerName = null, ?int $year = null): array
    {
        $year ??= (int) now()->format('Y');
        $shortName = self::shortName($partnerName);
        $preset = match ($categorySlug) {
            'perbankan' => self::bankingPreset($shortName, $year),
            'media' => self::mediaPreset($shortName, $year),
            'corporate' => self::retailPreset($shortName, $year),
            'hotel' => self::tourismPreset($shortName, $year),
            'pemerintah', 'bumn' => self::governmentPreset($shortName, $year),
            'perguruan-tinggi' => self::campusPreset($shortName, $year),
            default => self::genericPreset($shortName, $year),
        };

        $category = PartnerCategory::query()->where('slug', $categorySlug)->first();

        if ($category?->default_cta_label) {
            $preset['external_cta_label'] = $category->default_cta_label;
        }

        if ($category?->official_partner_label && blank($preset['showcase_official_title'] ?? null)) {
            $preset['showcase_official_title'] = "{$shortName} sebagai {$category->official_partner_label} Pemilihan Bujang Gadis Kampus Sumatera Selatan {$year}";
        }

        return $preset;
    }

    /** @return array<string, mixed> */
    public static function bankingPreset(string $shortName, int $year): array
    {
        return [
            'tagline' => 'Empowering Young Generation',
            'showcase_intro' => 'Kolaborasi strategis untuk membangun generasi muda yang cerdas finansial, berkarakter, dan siap memimpin masa depan.',
            'showcase_official_title' => "{$shortName} sebagai Official Banking Partner Pemilihan Bujang Gadis Kampus Sumatera Selatan {$year}",
            'showcase_official_subtext' => 'Bersama mitra perbankan, kami menghadirkan rangkaian program inspiratif yang memberi manfaat nyata bagi generasi muda dan masyarakat.',
            'showcase_strategic_values' => [
                ['title' => 'Akses Generasi Muda Sumsel', 'description' => 'Terhubung langsung dengan ribuan mahasiswa dari berbagai kampus di Sumatera Selatan.', 'icon' => 'users'],
                ['title' => 'Akuisisi Nasabah Digital', 'description' => 'Potensi pembukaan rekening baru dan aktivasi layanan perbankan digital.', 'icon' => 'chart'],
                ['title' => 'Edukasi Literasi Keuangan', 'description' => 'Mitra edukasi keuangan bagi generasi muda yang cerdas finansial.', 'icon' => 'book'],
                ['title' => 'Branding & Exposure Luas', 'description' => 'Eksposur brand melalui roadshow kampus, konten digital, dan Grand Final.', 'icon' => 'megaphone'],
                ['title' => 'Transaction Value', 'description' => 'Transaksi kegiatan diarahkan melalui produk/layanan mitra perbankan.', 'icon' => 'handshake'],
                ['title' => 'Citra Positif', 'description' => 'Mendukung pendidikan, kepemimpinan, dan pengembangan generasi muda.', 'icon' => 'star'],
            ],
            'showcase_programs' => [
                ['title' => 'Akuisisi Nasabah', 'description' => 'Peserta dan finalis didorong membuka rekening mitra dengan benefit eksklusif.', 'icon' => 'users'],
                ['title' => 'Aktivasi Mobile Banking', 'description' => 'Aktivasi layanan perbankan digital untuk kemudahan transaksi harian.', 'icon' => 'mobile'],
                ['title' => 'Campus Banking Activation', 'description' => 'Booth bank di roadshow kampus untuk edukasi dan aktivasi layanan.', 'icon' => 'building'],
                ['title' => 'Kelas Literasi Keuangan', 'description' => 'Seminar literasi keuangan bersama mitra perbankan.', 'icon' => 'book'],
                ['title' => 'Kunjungan Industri', 'description' => 'Finalis berkunjung ke kantor mitra untuk mengenal industri perbankan.', 'icon' => 'map'],
                ['title' => 'Financial Challenge', 'description' => 'Challenge pengelolaan keuangan untuk finalis dengan hadiah menarik.', 'icon' => 'trophy'],
            ],
            'showcase_benefits' => [
                ['title' => 'Akuisisi Nasabah Baru', 'description' => 'Potensi pembukaan rekening dari ribuan mahasiswa dan finalis.', 'icon' => 'users'],
                ['title' => 'Aktivasi Digital Banking', 'description' => 'Peningkatan aktivasi layanan perbankan digital.', 'icon' => 'mobile'],
                ['title' => 'Brand Exposure Luas', 'description' => 'Eksposur melalui roadshow, konten digital, dan Grand Final.', 'icon' => 'spark'],
                ['title' => 'Engagement Generasi Muda', 'description' => 'Hubungan jangka panjang dengan generasi muda produktif.', 'icon' => 'heart'],
            ],
            'showcase_kpis' => [
                ['value' => '2.000+', 'label' => 'Mahasiswa Terjangkau'],
                ['value' => '200+', 'label' => 'Pembukaan Rekening Baru'],
                ['value' => '200+', 'label' => 'Aktivasi Mobile Banking'],
                ['value' => '50+', 'label' => 'Konten Digital Kolaborasi'],
            ],
            'showcase_targets' => [
                ['label' => 'Peserta PBGK Sumsel', 'value' => '300 – 500 orang'],
                ['label' => 'Finalis', 'value' => '20 – 30 orang'],
                ['label' => 'Roadshow Kampus', 'value' => '7 – 10 kampus'],
            ],
            'showcase_program_quote' => "Bersama {$shortName}, kita hadirkan program yang relevan, inspiratif, dan berdampak nyata bagi generasi muda Sumatera Selatan.",
            'showcase_partner_tagline' => 'Mitra Finansial Generasi Muda Sumatera Selatan',
            'showcase_footer_quote' => "Bersama {$shortName}, mewujudkan generasi muda Sumatera Selatan yang cerdas finansial, berkarakter, dan siap memimpin masa depan.",
            'external_cta_label' => 'Kunjungi Bank',
        ];
    }

    /** @return array<string, mixed> */
    public static function mediaPreset(string $shortName, int $year): array
    {
        return [
            'tagline' => 'Amplifying Youth Stories',
            'showcase_intro' => 'Sinergi media untuk memperluas jangkauan cerita generasi muda Sumatera Selatan melalui konten berkualitas dan publikasi strategis.',
            'showcase_official_title' => "{$shortName} sebagai Official Media Partner Pemilihan Bujang Gadis Kampus Sumatera Selatan {$year}",
            'showcase_official_subtext' => 'Kolaborasi konten, publikasi, dan dokumentasi perjalanan finalis menuju panggung Grand Final.',
            'showcase_strategic_values' => [
                ['title' => 'Reach Generasi Muda', 'description' => 'Akses audiens mahasiswa dan komunitas digital di Sumatera Selatan.', 'icon' => 'users'],
                ['title' => 'Konten Premium', 'description' => 'Materi dokumenter, feature story, dan konten sosial yang relevan.', 'icon' => 'share'],
                ['title' => 'Brand Visibility', 'description' => 'Logo dan branding mitra di seluruh touchpoint publikasi acara.', 'icon' => 'megaphone'],
                ['title' => 'Live Coverage', 'description' => 'Liputan langsung roadshow dan Grand Final untuk exposure maksimal.', 'icon' => 'spark'],
                ['title' => 'Cross-Platform', 'description' => 'Distribusi konten lintas TV, digital, dan media sosial.', 'icon' => 'chart'],
                ['title' => 'Reputation Building', 'description' => 'Asosiasi positif dengan event kepemudaan bergengsi.', 'icon' => 'star'],
            ],
            'showcase_programs' => [
                ['title' => 'Live Coverage Grand Final', 'description' => 'Siaran langsung malam puncak dengan branding mitra media.', 'icon' => 'megaphone'],
                ['title' => 'Dokumenter Finalis', 'description' => 'Seri dokumenter perjalanan finalis dari roadshow hingga Grand Final.', 'icon' => 'share'],
                ['title' => 'Konten Digital Kolaborasi', 'description' => 'Konten Instagram, TikTok, dan YouTube bersama finalis.', 'icon' => 'share'],
                ['title' => 'Press Release & Media Kit', 'description' => 'Rilis resmi dan paket media untuk publikasi lintas platform.', 'icon' => 'book'],
                ['title' => 'Advertorial & Feature Story', 'description' => 'Artikel mendalam tentang program dan dampak kegiatan.', 'icon' => 'megaphone'],
                ['title' => 'Behind The Scene', 'description' => 'Konten eksklusif di balik layar kegiatan IBGK Sumsel.', 'icon' => 'spark'],
            ],
            'showcase_benefits' => [
                ['title' => 'Audience Growth', 'description' => 'Peningkatan viewership dan engagement di platform media.', 'icon' => 'chart'],
                ['title' => 'Premium Content', 'description' => 'Konten berkualitas tinggi dari event kepemudaan terkemuka.', 'icon' => 'star'],
                ['title' => 'Brand Association', 'description' => 'Posisi sebagai media resmi event bergengsi.', 'icon' => 'shield'],
                ['title' => 'Digital Reach', 'description' => 'Distribusi konten ke audiens generasi muda.', 'icon' => 'share'],
            ],
            'showcase_kpis' => [
                ['value' => '500K+', 'label' => 'Estimasi Reach Digital'],
                ['value' => '50+', 'label' => 'Konten Kolaborasi'],
                ['value' => '10+', 'label' => 'Roadshow Diliput'],
                ['value' => '1', 'label' => 'Live Grand Final'],
            ],
            'showcase_targets' => [
                ['label' => 'Durasi Dokumenter', 'value' => '4 – 6 episode'],
                ['label' => 'Platform Distribusi', 'value' => 'TV + Digital'],
                ['label' => 'Frekuensi Konten', 'value' => 'Mingguan'],
            ],
            'showcase_program_quote' => "Bersama {$shortName}, cerita inspiratif generasi muda Sumsel terangkai menjadi konten yang berdampak luas.",
            'showcase_partner_tagline' => 'Mitra Media Generasi Muda Sumatera Selatan',
            'showcase_footer_quote' => "Bersama {$shortName}, menghadirkan cerita generasi muda Sumatera Selatan ke panggung yang lebih luas.",
            'external_cta_label' => 'Kunjungi Media Partner',
        ];
    }

    /** @return array<string, mixed> */
    public static function retailPreset(string $shortName, int $year): array
    {
        return [
            'tagline' => 'Youth Brand Activation',
            'showcase_intro' => 'Aktivasi brand langsung ke generasi muda melalui sampling, sponsorship, dan engagement di setiap touchpoint kegiatan.',
            'showcase_official_title' => "{$shortName} sebagai Official Corporate Partner Pemilihan Bujang Gadis Kampus Sumatera Selatan {$year}",
            'showcase_official_subtext' => 'Kolaborasi aktivasi brand, sponsorship produk, dan engagement langsung dengan peserta dan finalis.',
            'showcase_strategic_values' => [
                ['title' => 'Direct Activation', 'description' => 'Interaksi langsung dengan ribuan mahasiswa di roadshow kampus.', 'icon' => 'users'],
                ['title' => 'Product Trial', 'description' => 'Kesempatan sampling dan trial produk ke target market muda.', 'icon' => 'spark'],
                ['title' => 'Brand Visibility', 'description' => 'Branding di booth, merchandise, dan area kegiatan.', 'icon' => 'megaphone'],
                ['title' => 'Event Sponsorship', 'description' => 'Dukungan produk untuk hadiah, goodie bag, dan kebutuhan acara.', 'icon' => 'trophy'],
                ['title' => 'Community Engagement', 'description' => 'Membangun hubungan dengan komunitas kampus dan alumni.', 'icon' => 'heart'],
                ['title' => 'Positive Association', 'description' => 'Brand terhubung dengan nilai positif kepemudaan dan budaya.', 'icon' => 'star'],
            ],
            'showcase_programs' => [
                ['title' => 'Booth Activation', 'description' => 'Stand brand di setiap roadshow kampus dengan games dan sampling.', 'icon' => 'building'],
                ['title' => 'Product Sampling', 'description' => 'Distribusi produk langsung ke peserta dan pengunjung roadshow.', 'icon' => 'spark'],
                ['title' => 'Sponsorship Hadiah', 'description' => 'Dukungan produk untuk doorprize dan penghargaan finalis.', 'icon' => 'trophy'],
                ['title' => 'Co-Branding Merchandise', 'description' => 'Merchandise kolaborasi untuk finalis dan peserta.', 'icon' => 'star'],
                ['title' => 'Brand Challenge', 'description' => 'Kompetisi kreatif berbasis produk/jasa mitra.', 'icon' => 'award'],
                ['title' => 'Grand Final Activation', 'description' => 'Aktivasi brand di malam puncak dengan exposure maksimal.', 'icon' => 'megaphone'],
            ],
            'showcase_benefits' => [
                ['title' => 'Trial & Conversion', 'description' => 'Konversi trial produk menjadi pelanggan setia.', 'icon' => 'chart'],
                ['title' => 'Brand Recall', 'description' => 'Meningkatkan ingatan merek di segmen usia muda.', 'icon' => 'spark'],
                ['title' => 'On-Ground Engagement', 'description' => 'Interaksi langsung yang measurable di lapangan.', 'icon' => 'users'],
                ['title' => 'Event Association', 'description' => 'Brand positioning di event kepemudaan premium.', 'icon' => 'shield'],
            ],
            'showcase_kpis' => [
                ['value' => '5.000+', 'label' => 'Sampling Terdistribusi'],
                ['value' => '10+', 'label' => 'Roadshow Activation'],
                ['value' => '2.000+', 'label' => 'Engagement Booth'],
                ['value' => '100+', 'label' => 'Konten UGC'],
            ],
            'showcase_targets' => [
                ['label' => 'Titik Aktivasi', 'value' => '7 – 10 kampus'],
                ['label' => 'Produk Sponsorship', 'value' => 'Goodie bag + Grand Final'],
                ['label' => 'Durasi Kolaborasi', 'value' => "Satu siklus {$year}"],
            ],
            'showcase_program_quote' => "Bersama {$shortName}, brand hadir dekat dengan generasi muda Sumsel melalui aktivasi yang relevan dan memorable.",
            'showcase_partner_tagline' => 'Mitra Brand Generasi Muda Sumatera Selatan',
            'showcase_footer_quote' => "Bersama {$shortName}, menghadirkan brand ke generasi muda Sumatera Selatan melalui pengalaman langsung yang autentik.",
            'external_cta_label' => 'Kunjungi Perusahaan',
        ];
    }

    /** @return array<string, mixed> */
    public static function tourismPreset(string $shortName, int $year): array
    {
        return [
            'tagline' => 'Hospitality & Culture Experience',
            'showcase_intro' => 'Kolaborasi hospitality untuk mendukung venue, akomodasi, dan pengalaman budaya finalis di Sumatera Selatan.',
            'showcase_official_title' => "{$shortName} sebagai Official Hospitality Partner Pemilihan Bujang Gadis Kampus Sumatera Selatan {$year}",
            'showcase_official_subtext' => 'Dukungan fasilitas, akomodasi, dan pengalaman pariwisata budaya untuk finalis dan kegiatan IBGK Sumsel.',
            'showcase_strategic_values' => [
                ['title' => 'Venue Premium', 'description' => 'Penyediaan venue untuk Grand Final dan kegiatan resmi.', 'icon' => 'building'],
                ['title' => 'Akomodasi Finalis', 'description' => 'Paket hospitality untuk finalis selama rangkaian kegiatan.', 'icon' => 'heart'],
                ['title' => 'Promosi Destinasi', 'description' => 'Eksposur destinasi wisata Sumsel ke audiens nasional.', 'icon' => 'map'],
                ['title' => 'Cultural Experience', 'description' => 'Pengalaman budaya autentik Sumatera Selatan.', 'icon' => 'star'],
                ['title' => 'Media Exposure', 'description' => 'Branding di dokumentasi dan publikasi kegiatan.', 'icon' => 'megaphone'],
                ['title' => 'Tourism Impact', 'description' => 'Kontribusi langsung terhadap promosi pariwisata daerah.', 'icon' => 'chart'],
            ],
            'showcase_programs' => [
                ['title' => 'Venue Grand Final', 'description' => 'Penyediaan venue premium untuk malam puncak pemilihan.', 'icon' => 'building'],
                ['title' => 'Paket Akomodasi Finalis', 'description' => 'Akomodasi finalis selama rangkaian kegiatan intensif.', 'icon' => 'heart'],
                ['title' => 'Fam Trip Pariwisata', 'description' => 'Kunjungan destinasi wisata budaya Sumatera Selatan.', 'icon' => 'map'],
                ['title' => 'Cultural Dinner', 'description' => 'Jamuan budaya dengan kuliner khas Sumsel.', 'icon' => 'star'],
                ['title' => 'Hospitality Training', 'description' => 'Pengenalan industri hospitality untuk finalis.', 'icon' => 'book'],
                ['title' => 'Co-Branding Experience', 'description' => 'Konten kolaborasi destinasi dan finalis.', 'icon' => 'share'],
            ],
            'showcase_benefits' => [
                ['title' => 'Occupancy & Booking', 'description' => 'Peningkatan occupancy melalui paket event dan finalis.', 'icon' => 'chart'],
                ['title' => 'Destination Promotion', 'description' => 'Promosi destinasi ke audiens generasi muda.', 'icon' => 'map'],
                ['title' => 'Brand Hospitality', 'description' => 'Positioning sebagai mitra hospitality resmi.', 'icon' => 'shield'],
                ['title' => 'Content Tourism', 'description' => 'Konten pariwisata dari kolaborasi dengan finalis.', 'icon' => 'share'],
            ],
            'showcase_kpis' => [
                ['value' => '1', 'label' => 'Venue Grand Final'],
                ['value' => '30+', 'label' => 'Finalis Terakomodasi'],
                ['value' => '5+', 'label' => 'Destinasi Dipromosikan'],
                ['value' => '20+', 'label' => 'Konten Pariwisata'],
            ],
            'showcase_targets' => [
                ['label' => 'Kapasitas Venue', 'value' => '500 – 1.000 tamu'],
                ['label' => 'Durasi Akomodasi', 'value' => '7 – 14 hari'],
                ['label' => 'Destinasi Fam Trip', 'value' => '3 – 5 lokasi'],
            ],
            'showcase_program_quote' => "Bersama {$shortName}, finalis mengenal kehangatan hospitality dan keindahan budaya Sumatera Selatan.",
            'showcase_partner_tagline' => 'Mitra Hospitality Generasi Muda Sumatera Selatan',
            'showcase_footer_quote' => "Bersama {$shortName}, memperkenalkan kehangatan Sumatera Selatan kepada generasi muda Indonesia.",
            'external_cta_label' => 'Kunjungi Hotel',
        ];
    }

    /** @return array<string, mixed> */
    public static function governmentPreset(string $shortName, int $year): array
    {
        return [
            'tagline' => 'Youth Development Partnership',
            'showcase_intro' => 'Sinergi pembinaan generasi muda, pelestarian budaya, dan kontribusi sosial untuk Sumatera Selatan.',
            'showcase_official_title' => "{$shortName} sebagai Official Partner Pemilihan Bujang Gadis Kampus Sumatera Selatan {$year}",
            'showcase_official_subtext' => 'Kolaborasi program pembinaan pemuda, CSR, dan promosi potensi daerah.',
            'showcase_strategic_values' => [
                ['title' => 'Pembinaan Pemuda', 'description' => 'Program pengembangan karakter dan kepemimpinan generasi muda.', 'icon' => 'users'],
                ['title' => 'CSR Alignment', 'description' => 'Selaras dengan program tanggung jawab sosial instansi/BUMN.', 'icon' => 'heart'],
                ['title' => 'Promosi Daerah', 'description' => 'Meningkatkan citra positif Sumatera Selatan.', 'icon' => 'megaphone'],
                ['title' => 'Pelestarian Budaya', 'description' => 'Dukungan terhadap nilai budaya dan kearifan lokal.', 'icon' => 'star'],
                ['title' => 'Kontribusi Sosial', 'description' => 'Program bakti masyarakat bersama finalis dan alumni.', 'icon' => 'handshake'],
                ['title' => 'Institutional Trust', 'description' => 'Kolaborasi resmi yang memperkuat kepercayaan publik.', 'icon' => 'shield'],
            ],
            'showcase_programs' => [
                ['title' => 'Program Beasiswa / Penghargaan', 'description' => 'Penghargaan khusus untuk finalis berprestasi.', 'icon' => 'trophy'],
                ['title' => 'Aksi Sosial Budaya', 'description' => 'Kegiatan bakti masyarakat dan pelestarian budaya.', 'icon' => 'heart'],
                ['title' => 'Edukasi Karakter', 'description' => 'Workshop kepemimpinan dan nilai-nilai lokal.', 'icon' => 'book'],
                ['title' => 'Promosi Pariwisata Daerah', 'description' => 'Konten promosi potensi wisata Sumatera Selatan.', 'icon' => 'map'],
                ['title' => 'Dukungan Logistik Acara', 'description' => 'Dukungan fasilitas untuk roadshow dan Grand Final.', 'icon' => 'building'],
                ['title' => 'Penghargaan Grand Final', 'description' => 'Penghargaan resmi dari instansi mitra.', 'icon' => 'award'],
            ],
            'showcase_benefits' => [
                ['title' => 'CSR Impact', 'description' => 'Dampak nyata program CSR yang terukur.', 'icon' => 'chart'],
                ['title' => 'Public Trust', 'description' => 'Memperkuat citra institusi di mata masyarakat.', 'icon' => 'shield'],
                ['title' => 'Youth Reach', 'description' => 'Akses langsung ke generasi muda produktif.', 'icon' => 'users'],
                ['title' => 'Regional Promotion', 'description' => 'Promosi potensi daerah ke level nasional.', 'icon' => 'megaphone'],
            ],
            'showcase_kpis' => [
                ['value' => '2.000+', 'label' => 'Pemuda Terjangkau'],
                ['value' => '5+', 'label' => 'Program Sosial'],
                ['value' => '10+', 'label' => 'Kegiatan Kolaborasi'],
                ['value' => '1', 'label' => 'Grand Final Resmi'],
            ],
            'showcase_targets' => [
                ['label' => 'Penerima Manfaat', 'value' => 'Peserta + masyarakat'],
                ['label' => 'Wilayah Jangkauan', 'value' => 'Sumatera Selatan'],
                ['label' => 'Durasi Program', 'value' => "Tahun {$year}"],
            ],
            'showcase_program_quote' => "Bersama {$shortName}, pembinaan generasi muda Sumsel berjalan selaras dengan agenda pembangunan daerah.",
            'showcase_partner_tagline' => 'Mitra Pembinaan Generasi Muda Sumatera Selatan',
            'showcase_footer_quote' => "Bersama {$shortName}, membangun generasi muda Sumatera Selatan yang berkarakter dan berkontribusi bagi daerah.",
            'external_cta_label' => 'Kunjungi Instansi',
        ];
    }

    /** @return array<string, mixed> */
    public static function campusPreset(string $shortName, int $year): array
    {
        return [
            'tagline' => 'Campus Collaboration',
            'showcase_intro' => 'Kolaborasi kampus untuk roadshow, talent pipeline, dan pengembangan mahasiswa berprestasi.',
            'showcase_official_title' => "{$shortName} sebagai Official Campus Partner Pemilihan Bujang Gadis Kampus Sumatera Selatan {$year}",
            'showcase_official_subtext' => 'Kerja sama roadshow, rekrutmen peserta, dan program pengembangan mahasiswa.',
            'showcase_strategic_values' => [
                ['title' => 'Talent Pipeline', 'description' => 'Akses mahasiswa berprestasi sebagai calon peserta.', 'icon' => 'users'],
                ['title' => 'Campus Visibility', 'description' => 'Eksposur kampus melalui event bergengsi.', 'icon' => 'megaphone'],
                ['title' => 'Student Development', 'description' => 'Program pengembangan soft skill mahasiswa.', 'icon' => 'book'],
                ['title' => 'Academic Prestige', 'description' => 'Meningkatkan reputasi kampus di tingkat regional.', 'icon' => 'star'],
                ['title' => 'Community Building', 'description' => 'Memperkuat komunitas mahasiswa di kampus.', 'icon' => 'heart'],
                ['title' => 'Long-term Network', 'description' => 'Jejaring alumni dan finalis lintas angkatan.', 'icon' => 'handshake'],
            ],
            'showcase_programs' => [
                ['title' => 'Roadshow Kampus', 'description' => 'Penyelenggaraan roadshow di lingkungan kampus mitra.', 'icon' => 'campus'],
                ['title' => 'Seleksi Peserta Kampus', 'description' => 'Seleksi internal calon peserta dari kampus mitra.', 'icon' => 'users'],
                ['title' => 'Workshop Kepemimpinan', 'description' => 'Pelatihan kepemimpinan untuk mahasiswa.', 'icon' => 'book'],
                ['title' => 'Kuliah Umum / Talkshow', 'description' => 'Sesi inspiratif dengan finalis dan alumni.', 'icon' => 'megaphone'],
                ['title' => 'Community Service', 'description' => 'Program sosial bersama mahasiswa kampus.', 'icon' => 'heart'],
                ['title' => 'Penghargaan Kampus', 'description' => 'Apresiasi kampus atas kontribusi peserta.', 'icon' => 'award'],
            ],
            'showcase_benefits' => [
                ['title' => 'Campus Branding', 'description' => 'Meningkatkan visibilitas kampus.', 'icon' => 'spark'],
                ['title' => 'Student Engagement', 'description' => 'Partisipasi mahasiswa dalam event nasional.', 'icon' => 'users'],
                ['title' => 'Prestige', 'description' => 'Asosiasi dengan event kepemudaan terkemuka.', 'icon' => 'star'],
                ['title' => 'Network', 'description' => 'Jejaring lintas kampus di Sumatera Selatan.', 'icon' => 'handshake'],
            ],
            'showcase_kpis' => [
                ['value' => '500+', 'label' => 'Mahasiswa Terlibat'],
                ['value' => '10+', 'label' => 'Peserta dari Kampus'],
                ['value' => '3+', 'label' => 'Workshop Diselenggarakan'],
                ['value' => '1', 'label' => 'Roadshow Resmi'],
            ],
            'showcase_targets' => [
                ['label' => 'Calon Peserta', 'value' => '30 – 50 mahasiswa'],
                ['label' => 'Program Kampus', 'value' => 'Roadshow + workshop'],
                ['label' => 'Timeline', 'value' => "Semester {$year}"],
            ],
            'showcase_program_quote' => "Bersama {$shortName}, mahasiswa berprestasi Sumsel mendapat panggung untuk berkembang dan berkontribusi.",
            'showcase_partner_tagline' => 'Mitra Kampus Generasi Muda Sumatera Selatan',
            'showcase_footer_quote' => "Bersama {$shortName}, membina mahasiswa berprestasi yang siap memimpin Sumatera Selatan.",
            'external_cta_label' => 'Kunjungi Kampus',
        ];
    }

    /** @return array<string, mixed> */
    public static function genericPreset(string $shortName, int $year): array
    {
        return [
            'tagline' => 'Strategic Partnership',
            'showcase_intro' => 'Kolaborasi strategis untuk mendukung pengembangan generasi muda Sumatera Selatan melalui program yang relevan dan berdampak.',
            'showcase_official_title' => "{$shortName} sebagai Strategic Partner Pemilihan Bujang Gadis Kampus Sumatera Selatan {$year}",
            'showcase_official_subtext' => 'Kerja sama program yang memberi manfaat nyata bagi peserta, finalis, dan masyarakat.',
            'showcase_strategic_values' => [
                ['title' => 'Youth Access', 'description' => 'Akses langsung ke generasi muda Sumatera Selatan.', 'icon' => 'users'],
                ['title' => 'Brand Visibility', 'description' => 'Eksposur brand di seluruh rangkaian kegiatan.', 'icon' => 'megaphone'],
                ['title' => 'Program Impact', 'description' => 'Program kolaborasi dengan dampak terukur.', 'icon' => 'chart'],
                ['title' => 'Positive Image', 'description' => 'Asosiasi dengan nilai positif kepemudaan.', 'icon' => 'star'],
            ],
            'showcase_programs' => [
                ['title' => 'Program Kolaborasi 1', 'description' => 'Program utama kolaborasi dengan mitra.', 'icon' => 'handshake'],
                ['title' => 'Program Kolaborasi 2', 'description' => 'Aktivasi brand di roadshow kampus.', 'icon' => 'building'],
                ['title' => 'Program Kolaborasi 3', 'description' => 'Engagement dengan peserta dan finalis.', 'icon' => 'users'],
                ['title' => 'Program Kolaborasi 4', 'description' => 'Konten digital kolaborasi.', 'icon' => 'share'],
            ],
            'showcase_benefits' => [
                ['title' => 'Brand Exposure', 'description' => 'Visibilitas brand di event premium.', 'icon' => 'megaphone'],
                ['title' => 'Youth Engagement', 'description' => 'Interaksi langsung dengan generasi muda.', 'icon' => 'users'],
                ['title' => 'Positive Association', 'description' => 'Citra positif melalui kemitraan resmi.', 'icon' => 'shield'],
            ],
            'showcase_program_quote' => "Bersama {$shortName}, kita wujudkan kolaborasi yang relevan dan berdampak bagi generasi muda Sumatera Selatan.",
            'showcase_partner_tagline' => 'Mitra Strategis Generasi Muda Sumatera Selatan',
            'showcase_footer_quote' => "Bersama {$shortName}, mewujudkan generasi muda Sumatera Selatan yang berkarakter dan berprestasi.",
            'external_cta_label' => 'Kunjungi Website Mitra',
        ];
    }

    public static function shortName(?string $partnerName): string
    {
        if (blank($partnerName)) {
            return 'MITRA';
        }

        $short = trim(str($partnerName)->before(' ')->toString());

        return $short !== '' ? str($short)->upper()->toString() : str($partnerName)->upper()->toString();
    }
}
