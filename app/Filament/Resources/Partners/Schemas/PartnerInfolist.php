<?php

namespace App\Filament\Resources\Partners\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartnerInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Mitra')->columns(2)->schema([
                ImageEntry::make('logo')->label('Logo')->disk('public')->columnSpanFull(),
                TextEntry::make('name')->label('Nama Mitra'),
                TextEntry::make('slug')->label('Slug'),
                TextEntry::make('category.name')->label('Kategori')->placeholder('-'),
                TextEntry::make('website')->label('Website')->url(fn ($state) => $state)->placeholder('-'),
                TextEntry::make('sort_order')->label('Urutan'),
                IconEntry::make('is_featured')->label('Unggulan')->boolean(),
                IconEntry::make('is_active')->label('Aktif')->boolean(),
                TextEntry::make('description')->label('Deskripsi')->columnSpanFull()->placeholder('-'),
            ]),
        ]);
    }
}
