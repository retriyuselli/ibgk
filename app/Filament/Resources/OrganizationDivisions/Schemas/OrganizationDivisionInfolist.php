<?php

namespace App\Filament\Resources\OrganizationDivisions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrganizationDivisionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Bidang')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Bidang'),
                        TextEntry::make('slug')
                            ->label('Slug'),
                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull()
                            ->placeholder('-'),
                        TextEntry::make('sort_order')
                            ->label('Urutan'),
                        IconEntry::make('is_active')
                            ->label('Aktif')
                            ->boolean(),
                    ]),
            ]);
    }
}
