<?php

namespace App\Filament\Resources\OrganizationPeriods\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrganizationPeriodsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama Periode')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_year')
                    ->label('Tahun Mulai')
                    ->sortable(),
                TextColumn::make('end_year')
                    ->label('Tahun Selesai')
                    ->sortable(),
                TextColumn::make('is_active')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (bool $state): string => $state ? 'Aktif' : 'Tidak Aktif')
                    ->color(fn (bool $state): string => $state ? 'success' : 'gray'),
                TextColumn::make('members_count')
                    ->label('Jumlah Pengurus')
                    ->counts('members')
                    ->sortable(),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('start_year', 'desc')
            ->filters([])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
