<?php

namespace App\Filament\Resources\OrganizationPeriods\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrganizationPeriodInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Detail Periode')
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label('Nama Periode')
                            ->columnSpanFull(),
                        TextEntry::make('start_year')
                            ->label('Tahun Mulai'),
                        TextEntry::make('end_year')
                            ->label('Tahun Selesai'),
                        TextEntry::make('is_active')
                            ->label('Status')
                            ->badge()
                            ->formatStateUsing(fn (bool $state): string => $state ? 'Aktif' : 'Tidak Aktif')
                            ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
                    ]),
            ]);
    }
}
