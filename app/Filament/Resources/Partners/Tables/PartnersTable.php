<?php

namespace App\Filament\Resources\Partners\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class PartnersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('logo')
                    ->label('Logo')
                    ->disk('public')
                    ->square(),
                TextColumn::make('name')
                    ->label('Nama Mitra')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->placeholder('-')
                    ->sortable(),
                TextColumn::make('website')
                    ->label('Website')
                    ->searchable()
                    ->url(fn ($state) => $state)
                    ->openUrlInNewTab()
                    ->limit(30)
                    ->placeholder('-'),
                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('sort_order')
                    ->label('Urutan')
                    ->sortable(),
            ])
            ->defaultSort('sort_order')
            ->filters([
                SelectFilter::make('partner_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->trueLabel('Unggulan')
                    ->falseLabel('Biasa')
                    ->placeholder('Semua'),
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
                    BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_active' => true]);
                            Notification::make()->title('Mitra diaktifkan')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->color('warning')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_active' => false]);
                            Notification::make()->title('Mitra dinonaktifkan')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('feature')
                        ->label('Featured')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_featured' => true]);
                            Notification::make()->title('Mitra dijadikan unggulan')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('unfeature')
                        ->label('Unfeatured')
                        ->color('gray')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_featured' => false]);
                            Notification::make()->title('Status unggulan dihapus')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
