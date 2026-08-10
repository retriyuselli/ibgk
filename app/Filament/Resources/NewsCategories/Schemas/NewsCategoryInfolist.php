<?php

namespace App\Filament\Resources\NewsCategories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class NewsCategoryInfolist
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
            ]),
        ]);
    }
}
