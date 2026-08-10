<?php

namespace App\Filament\Resources\ActivityCategories\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ActivityCategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Detail Kategori')->columns(2)->schema([
                TextEntry::make('name')->label('Nama Kategori'),
                TextEntry::make('slug')->label('Slug'),
                TextEntry::make('icon')->label('Icon')->placeholder('-'),
                TextEntry::make('sort_order')->label('Urutan'),
                TextEntry::make('description')->label('Deskripsi')->columnSpanFull()->placeholder('-'),
                IconEntry::make('is_active')->label('Aktif')->boolean(),
            ]),
        ]);
    }
}
