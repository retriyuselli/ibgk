<?php

namespace App\Filament\Resources\PartnerCategories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PartnerCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Kategori')->columns(2)->schema([
                TextEntry::make('name')->label('Nama Kategori'),
                TextEntry::make('slug')->label('Slug'),
                TextEntry::make('sort_order')->label('Urutan'),
                IconEntry::make('is_active')->label('Aktif')->boolean(),
                TextEntry::make('description')->label('Deskripsi')->columnSpanFull()->placeholder('-'),
                TextEntry::make('partners_count')
                    ->label('Jumlah Mitra')
                    ->state(fn ($record) => $record->partners()->count()),
            ]),
        ]);
    }
}
