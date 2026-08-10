<?php

namespace App\Filament\Resources\Activities\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Carbon;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')
                    ->label('Thumbnail')
                    ->disk('public')
                    ->square(),
                TextColumn::make('title')
                    ->label('Judul')
                    ->searchable()
                    ->sortable()
                    ->limit(40),
                TextColumn::make('category.name')
                    ->label('Kategori')
                    ->badge()
                    ->sortable(),
                TextColumn::make('activity_date')
                    ->label('Tanggal')
                    ->date('d M Y')
                    ->sortable(),
                TextColumn::make('location')
                    ->label('Lokasi')
                    ->searchable()
                    ->toggleable()
                    ->placeholder('-'),
                TextColumn::make('publication_status')
                    ->label('Status')
                    ->badge()
                    ->state(function ($record): string {
                        if (! $record->is_published) {
                            return 'Draft';
                        }

                        if ($record->published_at && $record->published_at->isFuture()) {
                            return 'Terjadwal';
                        }

                        return 'Terbit';
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'Terbit' => 'success',
                        'Terjadwal' => 'warning',
                        default => 'gray',
                    }),
                IconColumn::make('is_featured')
                    ->label('Unggulan')
                    ->boolean(),
                IconColumn::make('is_published')
                    ->label('Publish')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('published_at')
                    ->label('Publikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('excerpt')
                    ->label('Ringkasan')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('activity_date', 'desc')
            ->filters([
                SelectFilter::make('activity_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('is_published')
                    ->label('Published')
                    ->trueLabel('Terbit')
                    ->falseLabel('Draft')
                    ->placeholder('Semua'),
                TernaryFilter::make('is_featured')
                    ->label('Featured')
                    ->trueLabel('Unggulan')
                    ->falseLabel('Biasa')
                    ->placeholder('Semua'),
                Filter::make('activity_date')
                    ->label('Tanggal')
                    ->form([
                        \Filament\Forms\Components\DatePicker::make('from')->label('Dari'),
                        \Filament\Forms\Components\DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('activity_date', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('activity_date', '<=', $date));
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('publish')->label('Publish')->action(function (Collection $records): void {
                        $records->each(function ($record): void {
                            $record->update([
                                'is_published' => true,
                                'published_at' => $record->published_at ?? now(),
                            ]);
                        });
                        Notification::make()->title('Kegiatan dipublikasikan')->success()->send();
                    })->deselectRecordsAfterCompletion(),
                    BulkAction::make('unpublish')->label('Unpublish')->color('warning')->action(function (Collection $records): void {
                        $records->each->update(['is_published' => false]);
                        Notification::make()->title('Kegiatan di-unpublish')->success()->send();
                    })->deselectRecordsAfterCompletion(),
                    BulkAction::make('feature')->label('Featured')->action(function (Collection $records): void {
                        $records->each->update(['is_featured' => true]);
                        Notification::make()->title('Kegiatan dijadikan unggulan')->success()->send();
                    })->deselectRecordsAfterCompletion(),
                    BulkAction::make('unfeature')->label('Unfeatured')->color('gray')->action(function (Collection $records): void {
                        $records->each->update(['is_featured' => false]);
                        Notification::make()->title('Status unggulan dihapus')->success()->send();
                    })->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
