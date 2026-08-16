<?php

namespace App\Filament\Resources\HomepagePopups\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomepagePopupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Isi Popup')
                ->description('Popup hanya tampil di beranda saat status aktif. Pengunjung yang menutup tidak melihatnya lagi sampai konten diubah.')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul')
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Textarea::make('body')
                        ->label('Isi singkat')
                        ->rows(4)
                        ->columnSpanFull(),
                    FileUpload::make('image')
                        ->label('Gambar / Poster')
                        ->image()
                        ->directory('homepage-popups')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->helperText('Opsional. Jika diisi, poster tampil di bagian atas popup.')
                        ->columnSpanFull(),
                    TextInput::make('button_label')
                        ->label('Teks tombol')
                        ->maxLength(100)
                        ->placeholder('Daftar Sekarang'),
                    TextInput::make('button_url')
                        ->label('Tautan tombol')
                        ->maxLength(500)
                        ->placeholder('/daftar-bgk')
                        ->helperText('Boleh path situs (/daftar-bgk) atau URL lengkap.'),
                    Toggle::make('is_active')
                        ->label('Tampilkan di beranda')
                        ->default(true)
                        ->inline(false),
                    DateTimePicker::make('starts_at')
                        ->label('Mulai tampil')
                        ->native(false)
                        ->seconds(false)
                        ->helperText('Kosongkan agar langsung tampil.'),
                    DateTimePicker::make('ends_at')
                        ->label('Selesai tampil')
                        ->native(false)
                        ->seconds(false)
                        ->helperText('Kosongkan agar tidak ada batas waktu.'),
                ]),
        ]);
    }
}
