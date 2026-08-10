<?php

namespace App\Filament\Resources\OrganizationMembers\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrganizationMemberInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Pengurus')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('photo')
                            ->label('Foto')
                            ->disk('public')
                            ->circular()
                            ->columnSpanFull(),
                        TextEntry::make('name')
                            ->label('Nama Lengkap')
                            ->columnSpanFull(),
                        TextEntry::make('period.name')
                            ->label('Periode'),
                        TextEntry::make('position.name')
                            ->label('Jabatan'),
                        TextEntry::make('alumni.name')
                            ->label('Alumni')
                            ->placeholder('-'),
                        TextEntry::make('email')
                            ->label('Email'),
                        TextEntry::make('phone')
                            ->label('Nomor Telepon'),
                        TextEntry::make('bio')
                            ->label('Biografi Singkat')
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
