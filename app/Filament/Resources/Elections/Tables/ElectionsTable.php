<?php

namespace App\Filament\Resources\Elections\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class ElectionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(50),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'open' => 'Dibuka',
                        'closed' => 'Ditutup',
                        'finished' => 'Selesai',
                        default => 'Draft',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'open' => 'success',
                        'closed' => 'warning',
                        'finished' => 'gray',
                        default => 'gray',
                    }),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('registration_start')
                    ->label('Mulai Daftar')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('registration_end')
                    ->label('Akhir Daftar')
                    ->dateTime('d M Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('grand_final_date')
                    ->label('Grand Final')
                    ->date('d M Y')
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('year', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options([
                        'draft' => 'Draft',
                        'open' => 'Dibuka',
                        'closed' => 'Ditutup',
                        'finished' => 'Selesai',
                    ]),
                TernaryFilter::make('is_active')
                    ->label('Aktif')
                    ->trueLabel('Aktif')
                    ->falseLabel('Nonaktif')
                    ->placeholder('Semua'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
