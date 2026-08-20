<?php

namespace App\Filament\Resources\AlumniBatches\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;

class AlumniBatchesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama Angkatan')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('year')
                    ->label('Tahun')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('election.name')
                    ->label('Pemilihan BGK')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('alumni_count')
                    ->label('Alumni Terinput')
                    ->counts('alumni')
                    ->sortable(),
                TextColumn::make('historical_member_count')
                    ->label('Arsip Finalis')
                    ->placeholder('-')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('year', 'desc')
            ->filters([
                TrashedFilter::make()
                    ->label('Terhapus'),
                TernaryFilter::make('is_active')
                    ->label('Aktif')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->placeholder('Semua'),
                SelectFilter::make('year')
                    ->label('Tahun')
                    ->options(fn (): array => \App\Models\AlumniBatch::query()
                        ->orderByDesc('year')
                        ->pluck('year', 'year')
                        ->all()),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                RestoreAction::make()
                    ->label('Pulihkan'),
            ])
            ->toolbarActions([]);
    }
}
