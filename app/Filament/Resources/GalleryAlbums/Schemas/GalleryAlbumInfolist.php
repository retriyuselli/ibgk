<?php

namespace App\Filament\Resources\GalleryAlbums\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class GalleryAlbumInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Album')->columns(2)->schema([
                ImageEntry::make('cover')->label('Cover')->disk('public')->columnSpanFull(),
                TextEntry::make('title')->label('Judul')->columnSpanFull(),
                TextEntry::make('category')->label('Kategori')->placeholder('-'),
                TextEntry::make('event_date')->label('Tanggal Kegiatan')->date('d F Y')->placeholder('-'),
                TextEntry::make('location')->label('Lokasi')->placeholder('-'),
                TextEntry::make('photos_count')->label('Jumlah Foto')->state(fn ($record) => $record->photos()->count()),
                TextEntry::make('description')->label('Deskripsi')->columnSpanFull()->placeholder('-'),
                IconEntry::make('is_featured')->label('Album Unggulan')->boolean(),
                IconEntry::make('is_published')->label('Dipublikasikan')->boolean(),
            ]),
        ]);
    }
}
