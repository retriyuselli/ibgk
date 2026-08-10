<?php

namespace App\Filament\Resources\Pages\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Halaman')->columns(2)->schema([
                TextEntry::make('title')->label('Judul'),
                TextEntry::make('slug')->label('Slug'),
                TextEntry::make('excerpt')->label('Ringkasan')->columnSpanFull()->placeholder('-'),
                TextEntry::make('content')->label('Konten')->html()->columnSpanFull()->placeholder('-'),
                ImageEntry::make('banner')->label('Banner')->disk('public')->columnSpanFull(),
                TextEntry::make('meta_title')->label('SEO Title')->placeholder('-'),
                TextEntry::make('meta_description')->label('Meta Description')->placeholder('-')->columnSpanFull(),
                IconEntry::make('is_published')->label('Dipublikasikan')->boolean(),
                TextEntry::make('published_at')->label('Tanggal Publikasi')->dateTime('d M Y H:i')->placeholder('-'),
            ]),
        ]);
    }
}
