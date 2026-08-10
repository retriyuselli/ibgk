<?php

namespace App\Filament\Resources\News\Tables;

use Filament\Actions\BulkAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
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

class NewsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('thumbnail')->label('Thumbnail')->disk('public')->square(),
                TextColumn::make('title')->label('Judul')->searchable()->sortable()->limit(40),
                TextColumn::make('category.name')->label('Kategori')->badge()->placeholder('-'),
                TextColumn::make('author.name')->label('Penulis')->placeholder('-'),
                IconColumn::make('is_featured')->label('Utama')->boolean(),
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
                TextColumn::make('published_at')
                    ->label('Publikasi')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->placeholder('-'),
                TextColumn::make('views')->label('Views')->numeric()->sortable(),
                TextColumn::make('excerpt')->searchable()->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('location')->searchable()->toggleable(isToggledHiddenByDefault: true),
                IconColumn::make('is_published')->boolean()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('published_at', 'desc')
            ->filters([
                SelectFilter::make('news_category_id')
                    ->label('Kategori')
                    ->relationship('category', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('user_id')
                    ->label('Penulis')
                    ->relationship('author', 'name')
                    ->searchable()
                    ->preload(),
                TernaryFilter::make('is_published')->label('Published')->trueLabel('Terbit')->falseLabel('Draft')->placeholder('Semua'),
                TernaryFilter::make('is_featured')->label('Featured')->trueLabel('Utama')->falseLabel('Biasa')->placeholder('Semua'),
                Filter::make('published_at')
                    ->label('Tanggal Publikasi')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('published_at', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('published_at', '<=', $date));
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()->requiresConfirmation(),
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
                        Notification::make()->title('Berita dipublikasikan')->success()->send();
                    })->deselectRecordsAfterCompletion(),
                    BulkAction::make('unpublish')->label('Unpublish')->color('warning')->action(function (Collection $records): void {
                        $records->each->update(['is_published' => false]);
                        Notification::make()->title('Berita di-unpublish')->success()->send();
                    })->deselectRecordsAfterCompletion(),
                    BulkAction::make('feature')->label('Featured')->action(function (Collection $records): void {
                        $records->each->update(['is_featured' => true]);
                        Notification::make()->title('Berita dijadikan utama')->success()->send();
                    })->deselectRecordsAfterCompletion(),
                    BulkAction::make('unfeature')->label('Unfeatured')->color('gray')->action(function (Collection $records): void {
                        $records->each->update(['is_featured' => false]);
                        Notification::make()->title('Status utama dihapus')->success()->send();
                    })->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
