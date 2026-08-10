<?php

namespace App\Filament\Resources\GalleryAlbums\Tables;

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

class GalleryAlbumsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('cover')->label('Cover')->disk('public')->square(),
                TextColumn::make('title')->label('Judul')->searchable()->sortable(),
                TextColumn::make('category')->label('Kategori')->badge()->placeholder('-')->searchable(),
                TextColumn::make('event_date')->label('Tanggal')->date('d M Y')->sortable(),
                TextColumn::make('location')->label('Lokasi')->searchable()->placeholder('-')->toggleable(),
                TextColumn::make('photos_count')->label('Jumlah Foto')->counts('photos')->sortable(),
                IconColumn::make('is_featured')->label('Unggulan')->boolean(),
                IconColumn::make('is_published')->label('Publish')->boolean(),
            ])
            ->defaultSort('event_date', 'desc')
            ->filters([
                TernaryFilter::make('is_published')->label('Published')->trueLabel('Terbit')->falseLabel('Draft')->placeholder('Semua'),
                TernaryFilter::make('is_featured')->label('Featured')->trueLabel('Unggulan')->falseLabel('Biasa')->placeholder('Semua'),
                SelectFilter::make('category')
                    ->label('Kategori')
                    ->options([
                        'Pemilihan BGK' => 'Pemilihan BGK',
                        'Kegiatan' => 'Kegiatan',
                        'Sosial' => 'Sosial',
                        'Budaya' => 'Budaya',
                        'Alumni' => 'Alumni',
                        'Internal' => 'Internal',
                        'Kemitraan' => 'Kemitraan',
                    ]),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    BulkAction::make('publish')->label('Publish')->action(function (Collection $records): void {
                        $records->each->update(['is_published' => true]);
                        Notification::make()->title('Album dipublikasikan')->success()->send();
                    })->deselectRecordsAfterCompletion(),
                    BulkAction::make('unpublish')->label('Unpublish')->color('warning')->action(function (Collection $records): void {
                        $records->each->update(['is_published' => false]);
                        Notification::make()->title('Album di-unpublish')->success()->send();
                    })->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
