<?php

namespace App\Filament\Resources\OrganizationPeriods\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class OrganizationPeriodForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Data Periode')
                    ->columns(2)
                    ->schema([
                        TextInput::make('name')
                            ->label('Nama Periode')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Contoh: 2026–2028')
                            ->columnSpanFull(),
                        TextInput::make('start_year')
                            ->label('Tahun Mulai')
                            ->required()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(2100),
                        TextInput::make('end_year')
                            ->label('Tahun Selesai')
                            ->required()
                            ->numeric()
                            ->minValue(1900)
                            ->maxValue(2100)
                            ->gte('start_year')
                            ->validationMessages([
                                'gte' => 'Tahun selesai harus lebih besar atau sama dengan tahun mulai.',
                            ]),
                        Toggle::make('is_active')
                            ->label('Periode Aktif')
                            ->helperText('Hanya satu periode yang dapat aktif pada satu waktu.')
                            ->default(false)
                            ->inline(false)
                            ->columnSpanFull(),
                    ]),
            ]);
    }
}
