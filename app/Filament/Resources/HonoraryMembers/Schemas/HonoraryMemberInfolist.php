<?php

namespace App\Filament\Resources\HonoraryMembers\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class HonoraryMemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Anggota Kehormatan')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('photo')
                            ->label('Foto')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextEntry::make('name')
                            ->label('Nama')
                            ->columnSpanFull(),
                        TextEntry::make('title')
                            ->label('Gelar'),
                        TextEntry::make('sort_order')
                            ->label('Urutan'),
                        TextEntry::make('description')
                            ->label('Keterangan')
                            ->columnSpanFull(),
                        IconEntry::make('is_active')
                            ->label('Aktif')
                            ->boolean(),
                    ]),
            ]);
    }
}
