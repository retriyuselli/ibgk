<?php

namespace App\Filament\Resources\Elections\Schemas;

use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\ImageEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ElectionInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Informasi Pemilihan')
                ->columns(2)
                ->schema([
                    TextEntry::make('name')->label('Nama')->columnSpanFull(),
                    TextEntry::make('slug')->label('Slug'),
                    TextEntry::make('year')->label('Tahun'),
                    TextEntry::make('theme')->label('Tema')->placeholder('-')->columnSpanFull(),
                    TextEntry::make('location')->label('Lokasi')->placeholder('-')->columnSpanFull(),
                    TextEntry::make('status')
                        ->label('Status')
                        ->badge()
                        ->formatStateUsing(fn (?string $state): string => match ($state) {
                            'open' => 'Dibuka',
                            'closed' => 'Ditutup',
                            'finished' => 'Selesai',
                            default => 'Draft',
                        }),
                    IconEntry::make('is_active')->label('Aktif')->boolean(),
                ]),
            Section::make('Jadwal')
                ->columns(3)
                ->schema([
                    TextEntry::make('registration_start')->label('Mulai Pendaftaran')->dateTime('d M Y H:i')->placeholder('-'),
                    TextEntry::make('registration_end')->label('Akhir Pendaftaran')->dateTime('d M Y H:i')->placeholder('-'),
                    TextEntry::make('grand_final_date')->label('Grand Final')->date('d F Y')->placeholder('-'),
                ]),
            Section::make('Deskripsi')
                ->schema([
                    TextEntry::make('short_description')->label('Ringkasan')->placeholder('-')->columnSpanFull(),
                    TextEntry::make('description')->label('Deskripsi')->html()->placeholder('-')->columnSpanFull(),
                ]),
            Section::make('Media')
                ->columns(2)
                ->schema([
                    ImageEntry::make('poster')->label('Poster')->disk('public')->placeholder('-'),
                    ImageEntry::make('banner')->label('Banner')->disk('public')->placeholder('-'),
                ]),
        ]);
    }
}
