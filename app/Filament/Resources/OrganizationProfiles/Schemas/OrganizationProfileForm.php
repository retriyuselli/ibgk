<?php

namespace App\Filament\Resources\OrganizationProfiles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use App\Support\SiteTheme;

class OrganizationProfileForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Identitas Organisasi')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Organisasi')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('short_name')
                            ->label('Nama Singkat')
                            ->maxLength(255),
                        DatePicker::make('founded_at')
                            ->label('Tanggal Berdiri')
                            ->native(false)
                            ->displayFormat('d F Y'),
                        TextInput::make('founder')
                            ->label('Pendiri')
                            ->maxLength(255),
                        FileUpload::make('logo')
                            ->label('Logo')
                            ->image()
                            ->directory('organization')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor()
                            ->columnSpanFull(),
                        Select::make('frontend_theme')
                            ->label('Tema Tampilan Situs')
                            ->options(SiteTheme::options())
                            ->default(SiteTheme::CLASSIC)
                            ->required()
                            ->native(false)
                            ->helperText('Tema awal untuk pengunjung baru. Pengunjung tetap bisa mengganti tema dari header situs.')
                            ->columnSpanFull(),
                    ]),

                Section::make('Profil Organisasi')
                    ->columns(1)
                    ->schema([
                        Textarea::make('short_description')
                            ->label('Deskripsi Singkat')
                            ->rows(3)
                            ->columnSpanFull(),
                        RichEditor::make('description')
                            ->label('Tentang Organisasi')
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),

                Section::make('Visi & Misi')
                    ->columns(1)
                    ->schema([
                        RichEditor::make('vision')
                            ->label('Visi')
                            ->columnSpanFull(),
                        RichEditor::make('mission')
                            ->label('Misi')
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),

                Section::make('Kontak')
                    ->columns(2)
                    ->schema([
                        Textarea::make('address')
                            ->label('Alamat')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('phone')
                            ->label('Nomor Telepon')
                            ->tel()
                            ->maxLength(255),
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->maxLength(255),
                        TextInput::make('website')
                            ->label('Website')
                            ->url()
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->collapsed(),

                Section::make('Media Sosial')
                    ->columns(2)
                    ->schema([
                        TextInput::make('instagram')
                            ->label('Instagram')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('tiktok')
                            ->label('TikTok')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('youtube')
                            ->label('YouTube')
                            ->url()
                            ->maxLength(255),
                        TextInput::make('facebook')
                            ->label('Facebook')
                            ->url()
                            ->maxLength(255),
                    ])
                    ->collapsed(),

                Section::make('Halaman Showcase Mitra')
                    ->description('Teks bawaan untuk halaman kemitraan mitra. Gunakan placeholder :partner untuk nama singkat mitra.')
                    ->columns(1)
                    ->schema([
                        FileUpload::make('showcase_hero_background')
                            ->label('Background Hero Showcase')
                            ->helperText('Kosongkan untuk memakai gambar default. Unggah gambar custom atau isi path publik seperti images/home/hero-ampera.jpg.')
                            ->image()
                            ->directory('organization/showcase')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor(),
                        TextInput::make('showcase_copy.strategic_heading')
                            ->label('Judul Nilai Strategis')
                            ->maxLength(255),
                        TextInput::make('showcase_copy.benefits_heading')
                            ->label('Judul Manfaat Kerja Sama')
                            ->maxLength(255),
                        TextInput::make('showcase_copy.kpi_heading')
                            ->label('Judul KPI')
                            ->maxLength(255),
                        TextInput::make('showcase_copy.targets_heading')
                            ->label('Judul Target Peserta')
                            ->maxLength(255),
                        TextInput::make('showcase_copy.contact_heading')
                            ->label('Judul Hubungi Kami')
                            ->maxLength(255),
                        TextInput::make('showcase_copy.program_count_suffix')
                            ->label('Label Jumlah Program')
                            ->maxLength(255),
                        Textarea::make('showcase_copy.hero_placeholder_hint')
                            ->label('Petunjuk Placeholder Foto Hero')
                            ->rows(2),
                        Textarea::make('showcase_copy.default_footer_quote')
                            ->label('Quote Footer Default')
                            ->rows(3),
                    ])
                    ->collapsed(),

                Section::make('Halaman Pemilihan BGK')
                    ->description('Teks dan pilar untuk /pemilihan-bgk. Placeholder: :org_short, :org_formal, :org_region, :year.')
                    ->columns(1)
                    ->schema([
                        TextInput::make('election_copy.breadcrumb_label')
                            ->label('Label Breadcrumb')
                            ->maxLength(255),
                        TextInput::make('election_copy.hero_title_fallback')
                            ->label('Judul Hero (jika pemilihan aktif kosong)')
                            ->maxLength(255),
                        TextInput::make('election_copy.register_button_label')
                            ->label('Tombol Daftar')
                            ->maxLength(255),
                        TextInput::make('election_copy.about_title')
                            ->label('Judul Section Tentang')
                            ->maxLength(255),
                        Textarea::make('election_copy.about_second_paragraph')
                            ->label('Paragraf Kedua Tentang')
                            ->rows(3),
                        TextInput::make('election_copy.about_link_label')
                            ->label('Teks Link Tentang IBGK')
                            ->maxLength(255),
                        Repeater::make('election_pillars')
                            ->label('Pilar Tentang Pemilihan')
                            ->schema([
                                TextInput::make('title')
                                    ->label('Judul')
                                    ->required()
                                    ->maxLength(255),
                                Textarea::make('text')
                                    ->label('Deskripsi')
                                    ->required()
                                    ->rows(2),
                                Select::make('icon')
                                    ->label('Ikon')
                                    ->options([
                                        'user' => 'Pengembangan Diri',
                                        'building' => 'Kebudayaan',
                                        'heart' => 'Kontribusi Sosial',
                                        'trophy' => 'Prestasi',
                                    ])
                                    ->default('user')
                                    ->required(),
                            ])
                            ->columns(1)
                            ->defaultItems(4)
                            ->columnSpanFull(),
                        TextInput::make('election_copy.stages_title')
                            ->label('Judul Tahapan Seleksi')
                            ->maxLength(255),
                        TextInput::make('election_copy.schedule_title')
                            ->label('Judul Jadwal')
                            ->maxLength(255),
                        Textarea::make('election_copy.schedule_footnote')
                            ->label('Catatan Jadwal')
                            ->rows(2),
                        TextInput::make('election_copy.requirements_title')
                            ->label('Judul Persyaratan')
                            ->maxLength(255),
                        TextInput::make('election_copy.benefits_title')
                            ->label('Judul Manfaat')
                            ->maxLength(255),
                        FileUpload::make('election_benefits_image')
                            ->label('Gambar Samping Manfaat')
                            ->helperText('Kosongkan untuk gambar default.')
                            ->image()
                            ->directory('organization/election')
                            ->disk('public')
                            ->visibility('public')
                            ->imageEditor(),
                        TextInput::make('election_copy.participants_title')
                            ->label('Judul Peserta')
                            ->maxLength(255),
                        Textarea::make('election_copy.participants_intro')
                            ->label('Intro Peserta')
                            ->rows(2),
                        TextInput::make('election_copy.cta_heading')
                            ->label('Judul CTA Bawah')
                            ->maxLength(255),
                        Textarea::make('election_copy.cta_description')
                            ->label('Deskripsi CTA Bawah')
                            ->rows(2),
                        TextInput::make('election_copy.cta_button_label')
                            ->label('Tombol CTA Bawah')
                            ->maxLength(255),
                    ])
                    ->collapsed(),

                Section::make('Halaman Daftar BGK')
                    ->description('Teks untuk /daftar-bgk. Placeholder: :org_short, :org_formal, :year, :name.')
                    ->columns(1)
                    ->schema([
                        TextInput::make('registration_copy.breadcrumb_label')
                            ->label('Label Breadcrumb')
                            ->maxLength(255),
                        TextInput::make('registration_copy.hero_title')
                            ->label('Judul Hero')
                            ->maxLength(255),
                        TextInput::make('registration_copy.hero_subtitle')
                            ->label('Subjudul Hero')
                            ->maxLength(255),
                        Textarea::make('registration_copy.hero_description_fallback')
                            ->label('Deskripsi Hero (jika ringkasan pemilihan kosong)')
                            ->rows(3),
                        TextInput::make('registration_copy.form_title')
                            ->label('Judul Formulir')
                            ->maxLength(255),
                        Textarea::make('registration_copy.form_intro')
                            ->label('Intro Formulir')
                            ->rows(2),
                        TextInput::make('registration_copy.submit_label')
                            ->label('Tombol Kirim')
                            ->maxLength(255),
                        Textarea::make('registration_copy.terms_text')
                            ->label('Teks Persetujuan')
                            ->rows(3),
                        TextInput::make('registration_copy.success_title')
                            ->label('Judul Sukses')
                            ->maxLength(255),
                        Textarea::make('registration_copy.success_intro')
                            ->label('Intro Sukses')
                            ->rows(2),
                        Textarea::make('registration_copy.success_footnote')
                            ->label('Catatan Sukses')
                            ->rows(2),
                        TextInput::make('registration_copy.closed_title')
                            ->label('Judul Pendaftaran Tertutup')
                            ->maxLength(255),
                        Textarea::make('registration_copy.closed_description')
                            ->label('Deskripsi Pendaftaran Tertutup')
                            ->rows(2),
                        TextInput::make('registration_copy.sidebar_help_title')
                            ->label('Judul Bantuan Sidebar')
                            ->maxLength(255),
                        Textarea::make('registration_copy.sidebar_help_text')
                            ->label('Teks Bantuan Sidebar')
                            ->rows(2),
                    ])
                    ->collapsed(),
            ]);
    }
}
