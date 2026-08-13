<?php

namespace App\Filament\Resources\Participants\Tables;

use App\Filament\Actions\PromoteParticipantToAlumniAction;
use App\Filament\Resources\Participants\Schemas\ParticipantForm;
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

class ParticipantsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('photo')
                    ->label('Foto')
                    ->disk('public')
                    ->circular(),
                TextColumn::make('registration_number')
                    ->label('No. Registrasi')
                    ->searchable()
                    ->sortable()
                    ->copyable(),
                TextColumn::make('full_name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('nickname')
                    ->label('Panggilan')
                    ->searchable()
                    ->toggleable(),
                TextColumn::make('gender')
                    ->label('Jenis Kelamin')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => match ($state) {
                        'male' => 'Bujang',
                        'female' => 'Gadis',
                        default => $state ?? '-',
                    })
                    ->color(fn (?string $state): string => match ($state) {
                        'male' => 'info',
                        'female' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('election.name')
                    ->label('Pemilihan')
                    ->searchable()
                    ->sortable()
                    ->wrap()
                    ->limit(40),
                TextColumn::make('university')
                    ->label('Perguruan Tinggi')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(),
                TextColumn::make('city')
                    ->label('Kota')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->placeholder('-')
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => ParticipantForm::statusOptions()[$state] ?? $state ?? '-')
                    ->color(fn (?string $state): string => match ($state) {
                        'winner' => 'success',
                        'finalist' => 'warning',
                        'active' => 'info',
                        default => 'gray',
                    }),
                IconColumn::make('is_public')
                    ->label('Publik')
                    ->boolean(),
                TextColumn::make('created_at')
                    ->label('Didaftarkan')
                    ->dateTime('d M Y H:i')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
            ->filters([
                SelectFilter::make('election_id')
                    ->label('Pemilihan')
                    ->relationship('election', 'name', fn ($query) => $query->orderByDesc('year'))
                    ->searchable()
                    ->preload(),
                SelectFilter::make('gender')
                    ->label('Kategori')
                    ->options([
                        'male' => 'Bujang',
                        'female' => 'Gadis',
                    ]),
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(ParticipantForm::statusOptions()),
                TernaryFilter::make('is_public')
                    ->label('Tampil di Website')
                    ->trueLabel('Publik')
                    ->falseLabel('Privat')
                    ->placeholder('Semua'),
            ])
            ->recordActions([
                PromoteParticipantToAlumniAction::make(),
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
