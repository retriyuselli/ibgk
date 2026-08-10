<?php

namespace App\Filament\Resources\OrganizationPositions\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrganizationPositionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Jabatan')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Jabatan'),
                        TextEntry::make('slug')
                            ->label('Slug'),
                        TextEntry::make('description')
                            ->label('Deskripsi')
                            ->columnSpanFull(),
                        TextEntry::make('sort_order')
                            ->label('Urutan'),
                        IconEntry::make('is_active')
                            ->label('Aktif')
                            ->boolean(),
                    ]),
            ]);
    }
}
