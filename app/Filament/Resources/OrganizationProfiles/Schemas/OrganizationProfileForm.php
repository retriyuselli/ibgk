<?php

namespace App\Filament\Resources\OrganizationProfiles\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

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
            ]);
    }
}
