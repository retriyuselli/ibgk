<?php

namespace App\Filament\Resources\OrganizationMembers\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class OrganizationMembersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(function (Builder $query): Builder {
                return $query
                    ->leftJoin('organization_periods', 'organization_members.organization_period_id', '=', 'organization_periods.id')
                    ->leftJoin('organization_positions', 'organization_members.organization_position_id', '=', 'organization_positions.id')
                    ->select('organization_members.*')
                    ->orderByDesc('organization_periods.start_year')
                    ->orderBy('organization_positions.sort_order')
                    ->orderBy('organization_members.sort_order');
            })
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('position.name')
                    ->label('Jabatan')
                    ->badge()
                    ->sortable(),
                TextColumn::make('period.name')
                    ->label('Periode')
                    ->badge()
                    ->color('info')
                    ->sortable(),
                TextColumn::make('alumni.name')
                    ->label('Alumni')
                    ->placeholder('-')
                    ->toggleable(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('organization_period_id')
                    ->label('Periode')
                    ->relationship('period', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('organization_position_id')
                    ->label('Jabatan')
                    ->relationship('position', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('is_active')
                    ->label('Status Aktif')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
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
