<?php

namespace App\Filament\Resources\AlumniBatches\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AlumniBatchInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Informasi Angkatan')
                    ->columns(2)
                    ->schema([
                        ImageEntry::make('photo')
                            ->label('Foto Angkatan')
                            ->disk('public')
                            ->columnSpanFull(),
                        TextEntry::make('name')
                            ->label('Nama Angkatan')
                            ->columnSpanFull(),
                        TextEntry::make('year')
                            ->label('Tahun'),
                        TextEntry::make('election.name')
                            ->label('Pemilihan BGK')
                            ->placeholder('-'),
                        TextEntry::make('alumni_count')
                            ->label('Jumlah Alumni Terinput')
                            ->state(fn ($record): int => $record->alumni()->count()),
                        TextEntry::make('historical_member_count')
                            ->label('Jumlah Finalis Berdasarkan Arsip')
                            ->placeholder('-'),
                        TextEntry::make('bujang_count')
                            ->label('Bujang')
                            ->state(fn ($record): int => $record->alumni()->where('gender', 'bujang')->count()),
                        TextEntry::make('gadis_count')
                            ->label('Gadis')
                            ->state(fn ($record): int => $record->alumni()->where('gender', 'gadis')->count()),
                        IconEntry::make('is_active')
                            ->label('Aktif')
                            ->boolean(),
                        TextEntry::make('description')
                            ->label('Deskripsi Angkatan')
                            ->columnSpanFull()
                            ->placeholder('-'),
                    ]),
            ]);
    }
}
