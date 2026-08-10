<?php

namespace App\Filament\Resources\Pages\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Collection;

class PagesTable
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
                TextColumn::make('slug')
                    ->label('Slug')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('excerpt')
                    ->label('Ringkasan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true)
                    ->limit(40),
                IconColumn::make('is_published')
                    ->label('Publish')
                    ->boolean(),
                TextColumn::make('published_at')
                    ->label('Publikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('-'),
                TextColumn::make('updated_at')
                    ->label('Diperbarui')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('updated_at', 'desc')
            ->filters([
                TernaryFilter::make('is_published')
                    ->label('Published')
                    ->trueLabel('Terbit')
                    ->falseLabel('Draft')
                    ->placeholder('Semua'),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('publish')
                        ->label('Publish')
                        ->action(function (Collection $records): void {
                            $records->each(function ($record): void {
                                $record->update([
                                    'is_published' => true,
                                    'published_at' => $record->published_at ?? now(),
                                ]);
                            });
                            Notification::make()->title('Halaman dipublikasikan')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('unpublish')
                        ->label('Unpublish')
                        ->color('warning')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_published' => false]);
                            Notification::make()->title('Halaman di-unpublish')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
