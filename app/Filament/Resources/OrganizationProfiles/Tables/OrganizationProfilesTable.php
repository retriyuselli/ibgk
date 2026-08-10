<?php

namespace App\Filament\Resources\OrganizationProfiles\Tables;

use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class OrganizationProfilesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama Organisasi')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('short_name')
                    ->label('Nama Singkat')
                    ->searchable(),
                TextColumn::make('founded_at')
                    ->label('Tanggal Berdiri')
                    ->formatStateUsing(
                        fn ($state) => $state
                            ? $state->locale('id')->translatedFormat('d F Y')
                            : null
                    )
                    ->sortable(),
                TextColumn::make('founder')
                    ->label('Pendiri')
                    ->searchable(),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->since()
                    ->sortable(),
            ])
            ->filters([])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
            ])
            ->toolbarActions([]);
    }
}
