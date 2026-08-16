<?php

namespace App\Filament\Resources\HomepagePopups\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
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
                ->description('Popup beranda menampilkan poster saja. Ukurannya menyesuaikan layar. Pengunjung yang menutup tidak melihatnya lagi sampai poster diubah.')
                ->columns(2)
                ->schema([
                    TextInput::make('title')
                        ->label('Judul (teks alternatif)')
                        ->required()
                        ->maxLength(255)
                        ->helperText('Untuk aksesibilitas dan daftar di admin, tidak tampil di popup.')
                        ->columnSpanFull(),
                    FileUpload::make('image')
                        ->label('Poster')
                        ->image()
                        ->required()
                        ->directory('homepage-popups')
                        ->disk('public')
                        ->visibility('public')
                        ->imageEditor()
                        ->helperText('Wajib. Poster ini yang tampil di beranda.')
                        ->columnSpanFull(),
                    TextInput::make('button_url')
                        ->label('Tautan saat poster diklik')
                        ->maxLength(500)
                        ->placeholder('/daftar-bgk')
                        ->helperText('Opsional. Path situs (/daftar-bgk) atau URL lengkap.')
                        ->columnSpanFull(),
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
