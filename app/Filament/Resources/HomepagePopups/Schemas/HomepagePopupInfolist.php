<?php

namespace App\Filament\Resources\HomepagePopups\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HomepagePopupInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Popup')
                ->columns(2)
                ->schema([
                    ImageEntry::make('image')
                        ->label('Gambar / Poster')
                        ->disk('public')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('title')
                        ->label('Judul')
                        ->columnSpanFull(),
                    TextEntry::make('body')
                        ->label('Isi singkat')
                        ->placeholder('-')
                        ->columnSpanFull(),
                    TextEntry::make('button_label')
                        ->label('Teks tombol')
                        ->placeholder('-'),
                    TextEntry::make('button_url')
                        ->label('Tautan tombol')
                        ->placeholder('-'),
                    IconEntry::make('is_active')
                        ->label('Aktif')
                        ->boolean(),
                    TextEntry::make('starts_at')
                        ->label('Mulai tampil')
                        ->dateTime('d F Y H:i')
                        ->placeholder('-'),
                    TextEntry::make('ends_at')
                        ->label('Selesai tampil')
                        ->dateTime('d F Y H:i')
                        ->placeholder('-'),
                ]),
        ]);
    }
}
