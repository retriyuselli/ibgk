<?php

namespace App\Filament\Resources\Activities\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Kegiatan')->columns(2)->schema([
                ImageEntry::make('thumbnail')->label('Thumbnail')->disk('public'),
                ImageEntry::make('banner')->label('Banner')->disk('public'),
                TextEntry::make('title')->label('Judul')->columnSpanFull(),
                TextEntry::make('category.name')->label('Kategori'),
                TextEntry::make('location')->label('Lokasi')->placeholder('-'),
                TextEntry::make('activity_date')->label('Tanggal Mulai')->date('d F Y'),
                TextEntry::make('end_date')->label('Tanggal Selesai')->date('d F Y')->placeholder('-'),
                TextEntry::make('excerpt')->label('Ringkasan')->columnSpanFull()->placeholder('-'),
                TextEntry::make('content')->label('Isi Kegiatan')->html()->columnSpanFull(),
                IconEntry::make('is_featured')->label('Unggulan')->boolean(),
                IconEntry::make('is_published')->label('Dipublikasikan')->boolean(),
                TextEntry::make('published_at')->label('Tanggal Publikasi')->dateTime('d F Y H:i')->placeholder('-'),
            ]),
        ]);
    }
}
