<?php

namespace App\Filament\Resources\Documents\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class DocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('category')
                    ->label('Kategori')
                    ->searchable()
                    ->badge()
                    ->placeholder('-'),
                TextColumn::make('description')
                    ->label('Deskripsi')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(40),
                IconColumn::make('is_public')
                    ->label('Publik')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Dibuat')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Organisasi' => 'Organisasi',
                        'Pemilihan BGK' => 'Pemilihan BGK',
                        'Panduan' => 'Panduan',
                        'Proposal' => 'Proposal',
                        'Media Kit' => 'Media Kit',
                        'Formulir' => 'Formulir',
                        'Lainnya' => 'Lainnya',
                    ]),
                TernaryFilter::make('is_public')
                    ->label('Publik')
                    ->trueLabel('Publik')
                    ->falseLabel('Internal')
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
                            Notification::make()->title('Dokumen diaktifkan')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->color('warning')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_active' => false]);
                            Notification::make()->title('Dokumen dinonaktifkan')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
