<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'short_name',
        'founded_at',
        'founder',
        'short_description',
        'description',
        'vision',
        'mission',
        'logo',
        'address',
        'phone',
        'email',
        'website',
        'instagram',
        'tiktok',
        'youtube',
        'facebook',
        'showcase_copy',
        'showcase_hero_background',
        'election_copy',
        'election_pillars',
        'election_benefits_image',
        'registration_copy',
    ];

    protected function casts(): array
    {
        return [
            'founded_at' => 'date',
            'showcase_copy' => 'array',
            'election_copy' => 'array',
            'election_pillars' => 'array',
            'registration_copy' => 'array',
        ];
    }

    public function formalName(): string
    {
        return filled($this->name) ? $this->name : 'Organisasi';
    }

    public function displayShortName(): string
    {
        if (filled($this->short_name)) {
            return $this->short_name;
        }

        return $this->formalName();
    }

    public function instagramHandle(): ?string
    {
        return $this->socialHandleFromUrl($this->instagram);
    }

    public function socialHandleFromUrl(?string $url): ?string
    {
        if (blank($url)) {
            return null;
        }

        $url = trim($url);

        if (str_starts_with($url, '@')) {
            return $url;
        }

        if (preg_match('~(?:instagram|facebook|tiktok|youtube)\.com/(?:@)?([^/?#]+)~i', $url, $matches)) {
            return '@'.ltrim($matches[1], '@');
        }

        return null;
    }

    /** @return array<string, string> */
    public static function showcaseCopyDefaults(): array
    {
        return [
            'strategic_heading' => 'Mengapa Kolaborasi Ini Strategis untuk :partner?',
            'benefits_heading' => 'Manfaat Kerja Sama untuk :partner',
            'kpi_heading' => 'Indikator Keberhasilan (KPI)',
            'targets_heading' => 'Target Peserta & Jangkauan',
            'contact_heading' => 'Hubungi Kami',
            'program_count_suffix' => 'Program Kolaborasi Strategis',
            'hero_placeholder_hint' => 'Foto brand ambassador dapat diunggah melalui panel admin mitra.',
            'default_footer_quote' => 'Bersama :partner, mewujudkan generasi muda Sumatera Selatan yang berkarakter, berprestasi, dan siap memimpin masa depan.',
        ];
    }

    /** @param  array<string, string>  $replace */
    public function showcaseCopy(string $key, array $replace = []): string
    {
        $copy = array_merge(static::showcaseCopyDefaults(), $this->showcase_copy ?? []);
        $text = $copy[$key] ?? static::showcaseCopyDefaults()[$key] ?? '';

        $replacements = [];

        foreach ($replace as $placeholder => $value) {
            $replacements[':'.$placeholder] = $value;
        }

        return strtr($text, $replacements);
    }

    public function showcaseProgramCountLabel(int $count): string
    {
        return trim($count.' '.$this->showcaseCopy('program_count_suffix'));
    }

    public function showcaseHeroBackgroundFallbackPath(): string
    {
        if (filled($this->showcase_hero_background) && str_starts_with($this->showcase_hero_background, 'images/')) {
            return $this->showcase_hero_background;
        }

        return 'images/home/hero-ampera.jpg';
    }

    public function showcaseHeroBackgroundStoragePath(): ?string
    {
        if (blank($this->showcase_hero_background) || str_starts_with($this->showcase_hero_background, 'images/')) {
            return null;
        }

        return $this->showcase_hero_background;
    }

    public function logoUrl(): ?string
    {
        if (blank($this->logo)) {
            return null;
        }

        return asset('storage/'.$this->logo);
    }

    /** @return array<string, string> */
    public static function electionCopyDefaults(): array
    {
        return [
            'breadcrumb_label' => 'Pemilihan BGK :org_short',
            'hero_title_fallback' => 'Pemilihan Bujang Gadis Kampus :org_region',
            'theme_fallback' => 'Mencari Generasi Muda Kampus yang Berwawasan, Berbudaya, Berprestasi dan Berdampak.',
            'short_description_fallback' => 'Pemilihan Bujang Gadis Kampus Sumatera Selatan adalah ajang pembinaan generasi muda kampus untuk berkembang, berkarya, dan memberikan kontribusi nyata bagi masyarakat.',
            'description_fallback' => 'Pemilihan Bujang Gadis Kampus Sumatera Selatan merupakan program tahunan :org_short untuk menemukan dan membina generasi muda kampus yang berwawasan, berbudaya, berprestasi, serta siap memberikan dampak positif bagi masyarakat.',
            'register_button_label' => 'Daftar :org_short :year',
            'download_guide_label' => 'Unduh Panduan',
            'download_guide_full_label' => 'Unduh Panduan Lengkap',
            'about_title' => 'Tentang Pemilihan BGK :org_region',
            'about_second_paragraph' => 'Melalui rangkaian seleksi dan pembinaan, peserta ditantang untuk tumbuh secara personal, membangun jejaring, serta membawa semangat muda, berbudaya, berprestasi, dan menginspirasi.',
            'about_link_label' => 'Selengkapnya Tentang :org_short',
            'stages_title' => 'Tahapan Seleksi',
            'schedule_title' => 'Informasi Pemilihan :org_short :year',
            'schedule_footnote' => '* Jadwal dapat berubah sewaktu-waktu mengikuti keputusan panitia resmi.',
            'schedule_tbd_label' => 'Menyesuaikan jadwal',
            'requirements_title' => 'Persyaratan Peserta',
            'benefits_title' => 'Apa yang Anda Dapatkan?',
            'participants_title' => 'Peserta Pemilihan BGK :year',
            'participants_intro' => 'Kenali peserta publik :org_formal yang siap menunjukkan potensi, karakter, dan semangat generasi muda kampus.',
            'participants_empty_title' => 'Daftar peserta segera diumumkan',
            'participants_empty_text' => 'Profil peserta publik akan tampil setelah proses verifikasi administrasi selesai.',
            'gender_bujang_label' => 'Bujang',
            'gender_gadis_label' => 'Gadis',
            'cta_heading' => 'Siap Menjadi Bagian dari Generasi Muda Berdampak?',
            'cta_description' => 'Daftarkan dirimu sekarang dan wujudkan potensi terbaikmu bersama :org_short pada Pemilihan BGK :year.',
            'cta_button_label' => 'Daftar Sekarang',
            'past_elections_title' => 'Pemilihan Sebelumnya',
            'guide_unavailable_text' => 'Panduan lengkap akan segera tersedia.',
            'poster_alt' => 'Finalis :org_formal',
            'hero_banner_fallback' => 'images/home/hero-ampera.jpg',
            'hero_poster_fallback' => 'images/home/about-1.jpg',
            'benefits_image_fallback' => 'images/home/sejarah-grand-final.jpg',
            'org_region' => 'Sumatera Selatan',
        ];
    }

    /** @return array<int, array{title: string, text: string, icon: string}> */
    public static function electionPillarDefaults(): array
    {
        return [
            [
                'title' => 'Pengembangan Diri',
                'text' => 'Pembinaan kepemimpinan, komunikasi, dan karakter peserta.',
                'icon' => 'user',
            ],
            [
                'title' => 'Kebudayaan',
                'text' => 'Menjaga dan mempromosikan budaya Sumatera Selatan.',
                'icon' => 'building',
            ],
            [
                'title' => 'Kontribusi Sosial',
                'text' => 'Mendorong aksi nyata dan kepedulian terhadap masyarakat.',
                'icon' => 'heart',
            ],
            [
                'title' => 'Prestasi & Inspirasi',
                'text' => 'Menjadi teladan positif bagi generasi muda kampus.',
                'icon' => 'trophy',
            ],
        ];
    }

    /** @param  array<string, string|int|null>  $replace */
    public function electionCopy(string $key, array $replace = []): string
    {
        $copy = array_merge(static::electionCopyDefaults(), $this->election_copy ?? []);
        $text = $copy[$key] ?? static::electionCopyDefaults()[$key] ?? '';

        $replacements = [
            ':org_short' => $this->displayShortName(),
            ':org_formal' => $this->formalName(),
            ':org_region' => $copy['org_region'] ?? static::electionCopyDefaults()['org_region'],
        ];

        foreach ($replace as $placeholder => $value) {
            $replacements[':'.$placeholder] = (string) $value;
        }

        return strtr($text, $replacements);
    }

    /** @return array<int, array{title: string, text: string, icon: string}> */
    public function electionPillars(): array
    {
        $pillars = $this->election_pillars ?? [];

        if ($pillars === []) {
            return static::electionPillarDefaults();
        }

        return array_values($pillars);
    }

    public function electionBenefitsImagePath(): string
    {
        if (filled($this->election_benefits_image) && str_starts_with($this->election_benefits_image, 'images/')) {
            return $this->election_benefits_image;
        }

        return $this->electionCopy('benefits_image_fallback');
    }

    public function electionBenefitsImageStoragePath(): ?string
    {
        if (blank($this->election_benefits_image) || str_starts_with($this->election_benefits_image, 'images/')) {
            return null;
        }

        return $this->election_benefits_image;
    }

    /** @return array<string, string> */
    public static function registrationCopyDefaults(): array
    {
        return [
            'breadcrumb_label' => 'Daftar',
            'hero_title' => 'Daftar :org_short :year',
            'hero_subtitle' => ':org_formal',
            'hero_description_fallback' => 'Isi formulir pendaftaran resmi Pemilihan Bujang Gadis Kampus Sumatera Selatan dan jadilah bagian dari generasi muda kampus yang berdampak.',
            'registration_period_prefix' => 'Pendaftaran:',
            'form_title' => 'Formulir Pendaftaran',
            'form_intro' => 'Lengkapi data diri Anda dengan benar. Pastikan seluruh informasi dapat diverifikasi oleh panitia.',
            'section_personal' => 'Data Diri',
            'section_campus' => 'Data Kampus',
            'section_contact' => 'Kontak & Profil',
            'gender_label' => 'Jenis Kelamin',
            'gender_bujang_label' => 'Bujang',
            'gender_gadis_label' => 'Gadis',
            'field_full_name' => 'Nama Lengkap',
            'field_nickname' => 'Nama Panggilan',
            'field_religion' => 'Agama',
            'field_birth_place' => 'Tempat Lahir',
            'field_birth_date' => 'Tanggal Lahir',
            'field_city' => 'Kota Asal',
            'field_photo' => 'Foto Diri Close Up',
            'field_photo_full_body' => 'Foto Diri Full Body',
            'field_height' => 'Tinggi Badan (cm)',
            'field_weight' => 'Berat Badan (kg)',
            'field_medical_history' => 'Riwayat Penyakit',
            'field_university' => 'Perguruan Tinggi',
            'field_faculty' => 'Fakultas',
            'field_study_program' => 'Program Studi',
            'field_semester' => 'Semester',
            'field_gpa' => 'IPK',
            'field_email' => 'Email',
            'field_password' => 'Kata Sandi',
            'field_password_confirmation' => 'Konfirmasi Kata Sandi',
            'section_account' => 'Akun Dashboard Peserta',
            'hint_account' => 'Email dan kata sandi ini dipakai untuk masuk ke Dashboard Peserta. Email tidak boleh dipakai dua kali.',
            'field_phone' => 'Nomor Telepon',
            'field_emergency_phone' => 'Nomor Darurat',
            'field_address' => 'Alamat',
            'field_motto' => 'Motto / Tagline',
            'field_instagram' => 'Instagram',
            'field_tiktok' => 'TikTok',
            'field_social' => 'Akun Sosmed',
            'field_biography' => 'Profil Singkat',
            'field_achievements' => 'Prestasi',
            'field_hobbies' => 'Hobi',
            'field_talents' => 'Bakat Menarik',
            'field_parent_name' => 'Nama Orang Tua',
            'field_parent_occupation' => 'Pekerjaan Orang Tua',
            'field_parent_address' => 'Alamat Orang Tua',
            'field_motivation' => 'Motivasi Mengikuti PBGK',
            'field_ibgk_opinion' => 'Pendapat Mengenai IBGKSS',
            'section_physical' => 'Data Fisik & Kesehatan',
            'section_family' => 'Data Orang Tua',
            'section_profile' => 'Prestasi & Minat',
            'section_essay' => 'Motivasi & Pendapat',
            'hint_achievements' => 'Tulis satu prestasi per baris.',
            'hint_medical' => 'Isi “Tidak ada” jika tidak memiliki riwayat penyakit.',
            'hint_photo' => 'Foto akan dikompres otomatis ke ukuran standar.',
            'submit_label' => 'Kirim Pendaftaran',
            'terms_text' => 'Saya menyatakan data yang saya isi benar, memenuhi persyaratan peserta, dan bersedia mengikuti seluruh rangkaian Pemilihan BGK :year.',
            'success_title' => 'Pendaftaran Berhasil',
            'success_intro' => 'Terima kasih, :name. Nomor registrasi Anda:',
            'success_footnote' => 'Simpan nomor registrasi ini. Panitia akan menghubungi Anda melalui email atau telepon untuk tahap selanjutnya.',
            'success_election_link' => 'Lihat Info Pemilihan',
            'success_home_link' => 'Kembali ke Beranda',
            'closed_title' => 'Pendaftaran Belum Dibuka',
            'closed_description' => 'Formulir pendaftaran Pemilihan BGK saat ini belum tersedia atau periode pendaftaran telah berakhir.',
            'closed_button' => 'Lihat Jadwal Pemilihan',
            'sidebar_info_title' => 'Informasi Pemilihan',
            'sidebar_requirements_title' => 'Persyaratan Peserta',
            'sidebar_stages_title' => 'Tahapan Seleksi',
            'sidebar_help_title' => 'Butuh Bantuan?',
            'sidebar_help_text' => 'Hubungi panitia Pemilihan BGK :year jika ada pertanyaan seputar pendaftaran.',
            'sidebar_help_button' => 'Hubungi Panitia',
            'sidebar_election_link' => 'Lihat detail pemilihan →',
            'hero_banner_fallback' => 'images/home/hero-ampera.jpg',
            'hero_banner_alt' => 'Daftar BGK Sumatera Selatan',
        ];
    }

    /** @param  array<string, string|int|null>  $replace */
    public function registrationCopy(string $key, array $replace = []): string
    {
        $copy = array_merge(static::registrationCopyDefaults(), $this->registration_copy ?? []);
        $text = $copy[$key] ?? static::registrationCopyDefaults()[$key] ?? '';

        $replacements = [
            ':org_short' => $this->displayShortName(),
            ':org_formal' => $this->formalName(),
        ];

        foreach ($replace as $placeholder => $value) {
            $replacements[':'.$placeholder] = (string) $value;
        }

        return strtr($text, $replacements);
    }
}
