<?php

namespace App\Filament\Resources\AlumniBatches\RelationManagers;

use App\Filament\Resources\Alumnis\AlumniResource;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AlumniRelationManager extends RelationManager
{
    protected static string $relationship = 'alumni';

    protected static ?string $relatedResource = AlumniResource::class;

    protected static ?string $title = 'Alumni';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('gender')
                    ->label('Kategori')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'bujang' => 'Bujang',
                        'gadis' => 'Gadis',
                        default => $state,
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'bujang' => 'info',
                        'gadis' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('university')
                    ->label('Perguruan Tinggi')
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('profession')
                    ->label('Profesi')
                    ->placeholder('-')
                    ->toggleable(),
                IconColumn::make('is_public')
                    ->label('Publik')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('name')
            ->headerActions([
                CreateAction::make()
                    ->label('Tambah Alumni'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([]);
    }
}
