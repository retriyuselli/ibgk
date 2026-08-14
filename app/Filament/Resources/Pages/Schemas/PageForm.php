<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class PageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Halaman')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255)
                        ->live(onBlur: true)
                        ->afterStateUpdated(function (Set $set, Get $get, ?string $state, ?string $old): void {
                            $currentSlug = $get('slug');
                            if (blank($currentSlug) || $currentSlug === Str::slug((string) $old)) {
                                $set('slug', Str::slug((string) $state));
                            }
                        })
                        ->columnSpanFull(),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->live(onBlur: true)
                        ->columnSpanFull(),
                    Textarea::make('excerpt')
                        ->label('Ringkasan')
                        ->helperText('Ditampilkan sebagai deskripsi hero halaman.')
                        ->rows(3)
                        ->columnSpanFull(),
                ]),

            Section::make('Konten')
                ->schema([
                    RichEditor::make('content')
                        ->label('Konten')
                        ->columnSpanFull(),
                ]),

            Section::make('Media')
                ->columns(2)
                ->schema([
                    FileUpload::make('banner')
                        ->label('Banner Hero')
                        ->helperText('Gambar latar hero halaman. Kosongkan untuk gambar bawaan.')
                        ->image()
                        ->directory('pages/banners')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->maxSize(5120)
                        ->columnSpanFull(),
                    self::aboutImageUpload('about_image_1', 'Foto Tentang 1', 'Kolase beranda, kiri atas.'),
                    self::aboutImageUpload('about_image_2', 'Foto Tentang 2', 'Kolase beranda, kiri bawah.'),
                    self::aboutImageUpload('about_image_3', 'Foto Tentang 3', 'Kolase beranda, kanan atas.'),
                    self::aboutImageUpload('about_image_4', 'Foto Tentang 4', 'Kolase beranda, kanan bawah.'),
                ]),

            Section::make('SEO')
                ->schema([
                    TextInput::make('meta_title')
                        ->label('SEO Title / Subjudul Hero')
                        ->maxLength(255)
                        ->helperText('Subjudul atau tagline hero (Beranda, Kontak, Kemitraan). Halaman lain: judul SEO.'),
                    Textarea::make('meta_description')
                        ->label('Meta Description / Kutipan Hero')
                        ->rows(3)
                        ->helperText('Kutipan hero Kontak, atau deskripsi SEO halaman lainnya.')
                        ->columnSpanFull(),
                ])
                ->collapsed(),

            Section::make('Publikasi')
                ->columns(2)
                ->schema([
                    Toggle::make('is_published')
                        ->label('Dipublikasikan')
                        ->default(false)
                        ->inline(false),
                    DateTimePicker::make('published_at')
                        ->label('Tanggal Publikasi')
                        ->native(false)
                        ->seconds(false),
                ]),
        ]);
    }

    protected static function aboutImageUpload(string $field, string $label, string $helper): FileUpload
    {
        return FileUpload::make($field)
            ->label($label)
            ->helperText($helper.' Kosongkan untuk gambar bawaan.')
            ->image()
            ->directory('pages/about')
            ->disk('public')
            ->visibility('public')
            ->imageEditor()
            ->maxSize(5120)
            ->visible(fn (Get $get): bool => $get('slug') === 'about');
    }
}
