<?php

namespace App\Filament\Resources\News\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Berita')->columns(2)->schema([
                ImageEntry::make('thumbnail')->label('Thumbnail')->disk('public')->columnSpanFull(),
                TextEntry::make('title')->label('Judul')->columnSpanFull(),
                TextEntry::make('category.name')->label('Kategori')->placeholder('-'),
                TextEntry::make('author.name')->label('Penulis')->placeholder('-'),
                TextEntry::make('location')->label('Lokasi')->placeholder('-'),
                TextEntry::make('views')->label('Views'),
                TextEntry::make('excerpt')->label('Ringkasan')->columnSpanFull()->placeholder('-'),
                TextEntry::make('content')->label('Isi Berita')->html()->columnSpanFull(),
                IconEntry::make('is_featured')->label('Berita Utama')->boolean(),
                IconEntry::make('is_published')->label('Dipublikasikan')->boolean(),
                TextEntry::make('published_at')->label('Tanggal Publikasi')->dateTime('d F Y H:i')->placeholder('-'),
            ]),
        ]);
    }
}
