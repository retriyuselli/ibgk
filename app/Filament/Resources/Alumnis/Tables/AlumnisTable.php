<?php

namespace App\Filament\Resources\Alumnis\Tables;

use App\Filament\Actions\AlumniProfileLinkActions;
use App\Models\Alumni;
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

class AlumnisTable
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
                    })
                    ->sortable(),
                TextColumn::make('batch.name')
                    ->label('Keanggotaan')
                    ->badge()
                    ->sortable(),
                TextColumn::make('university')
                    ->label('Perguruan Tinggi')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('profession')
                    ->label('Profesi')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('company')
                    ->label('Instansi')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('profile_submitted_at')
                    ->label('Formulir')
                    ->badge()
                    ->formatStateUsing(fn ($state, Alumni $record): string => $record->profileFormStatusLabel())
                    ->color(fn ($state, Alumni $record): string => match (true) {
                        (bool) $record->profile_submitted_at => 'success',
                        $record->hasValidProfileToken() => 'warning',
                        filled($record->profile_token) => 'danger',
                        default => 'gray',
                    })
                    ->sortable(),
                IconColumn::make('is_public')
                    ->label('Publik')
                    ->boolean(),
                IconColumn::make('is_active')
                    ->label('Aktif')
                    ->boolean(),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('alumni_batch_id')
                    ->label('Keanggotaan')
                    ->relationship('batch', 'name', fn ($query) => $query->orderByDesc('year'))
                    ->searchable()
                    ->preload(),
                SelectFilter::make('gender')
                    ->label('Kategori')
                    ->options([
                        'bujang' => 'Bujang',
                        'gadis' => 'Gadis',
                    ]),
                TernaryFilter::make('is_public')
                    ->label('Tampil di Website')
                    ->trueLabel('Publik')
                    ->falseLabel('Privat')
                    ->placeholder('Semua'),
                TernaryFilter::make('is_active')
                    ->label('Aktif')
                    ->trueLabel('Aktif')
                    ->falseLabel('Tidak Aktif')
                    ->placeholder('Semua'),
            ])
            ->recordActions([
                AlumniProfileLinkActions::copyLink(),
                ViewAction::make(),
                EditAction::make(),
                DeleteAction::make()
                    ->requiresConfirmation()
                    ->modalHeading('Hapus Alumni')
                    ->modalDescription('Data alumni adalah arsip penting. Pertimbangkan menonaktifkan daripada menghapus. Lanjutkan hapus?'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    AlumniProfileLinkActions::bulkGenerateLinks(),
                    BulkAction::make('activate')
                        ->label('Aktifkan')
                        ->icon('heroicon-o-check-circle')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_active' => true]);
                            Notification::make()->title('Alumni diaktifkan')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('deactivate')
                        ->label('Nonaktifkan')
                        ->icon('heroicon-o-x-circle')
                        ->color('warning')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_active' => false]);
                            Notification::make()->title('Alumni dinonaktifkan')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('makePublic')
                        ->label('Tampilkan di Website')
                        ->icon('heroicon-o-eye')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_public' => true]);
                            Notification::make()->title('Alumni ditampilkan di website')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                    BulkAction::make('makePrivate')
                        ->label('Sembunyikan dari Website')
                        ->icon('heroicon-o-eye-slash')
                        ->color('gray')
                        ->action(function (Collection $records): void {
                            $records->each->update(['is_public' => false]);
                            Notification::make()->title('Alumni disembunyikan dari website')->success()->send();
                        })
                        ->deselectRecordsAfterCompletion(),
                ]),
            ]);
    }
}
