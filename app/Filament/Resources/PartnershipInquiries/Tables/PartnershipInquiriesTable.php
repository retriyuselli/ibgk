<?php

namespace App\Filament\Resources\PartnershipInquiries\Tables;

use App\Models\PartnershipInquiry;
use Filament\Actions\Action;
use Filament\Actions\EditAction;
use Filament\Actions\ViewAction;
use Filament\Forms\Components\DatePicker;
use Filament\Notifications\Notification;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class PartnershipInquiriesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Nama')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('organization')
                    ->label('Organisasi')
                    ->searchable()
                    ->placeholder('-')
                    ->limit(30),
                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('phone')
                    ->label('Telepon')
                    ->searchable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('partnership_type')
                    ->label('Jenis Kerja Sama')
                    ->placeholder('-')
                    ->limit(25),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn (?string $state): string => PartnershipInquiry::STATUSES[$state] ?? (string) $state)
                    ->color(fn (?string $state): string => match ($state) {
                        'new' => 'warning',
                        'contacted', 'follow_up' => 'info',
                        'approved' => 'success',
                        'rejected' => 'danger',
                        'closed' => 'gray',
                        default => 'gray',
                    })
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('Tanggal Masuk')
                    ->dateTime('d M Y H:i')
                    ->sortable(),
            ])
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->label('Status')
                    ->options(PartnershipInquiry::STATUSES),
                SelectFilter::make('partnership_type')
                    ->label('Jenis Kerja Sama')
                    ->options(fn (): array => PartnershipInquiry::query()
                        ->whereNotNull('partnership_type')
                        ->where('partnership_type', '!=', '')
                        ->distinct()
                        ->orderBy('partnership_type')
                        ->pluck('partnership_type', 'partnership_type')
                        ->all()),
                Filter::make('created_at')
                    ->label('Tanggal Masuk')
                    ->form([
                        DatePicker::make('from')->label('Dari'),
                        DatePicker::make('until')->label('Sampai'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when($data['from'] ?? null, fn (Builder $q, $date) => $q->whereDate('created_at', '>=', $date))
                            ->when($data['until'] ?? null, fn (Builder $q, $date) => $q->whereDate('created_at', '<=', $date));
                    }),
            ])
            ->recordActions([
                ViewAction::make(),
                EditAction::make(),
                Action::make('markContacted')
                    ->label('Tandai Sudah Dihubungi')
                    ->icon('heroicon-o-phone')
                    ->visible(fn (PartnershipInquiry $record): bool => $record->status === PartnershipInquiry::STATUS_NEW)
                    ->action(function (PartnershipInquiry $record): void {
                        $record->update(['status' => PartnershipInquiry::STATUS_CONTACTED]);
                        Notification::make()->title('Status diubah menjadi Sudah Dihubungi')->success()->send();
                    }),
            ])
            ->toolbarActions([]);
    }
}
