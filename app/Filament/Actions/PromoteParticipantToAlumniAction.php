<?php

namespace App\Filament\Actions;

use App\Models\AlumniBatch;
use App\Models\Participant;
use App\Services\PromoteParticipantToAlumni;
use Filament\Actions\Action;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Throwable;

class PromoteParticipantToAlumniAction
{
    public static function make(): Action
    {
        return Action::make('promoteToAlumni')
            ->label('Jadikan Alumni')
            ->icon(Heroicon::OutlinedAcademicCap)
            ->color('success')
            ->requiresConfirmation()
            ->modalHeading('Jadikan Alumni')
            ->modalDescription('Peserta akan disalin menjadi data Alumni. Data Peserta tetap dipertahankan.')
            ->modalSubmitActionLabel('Ya, Jadikan Alumni')
            ->visible(function (Participant $record): bool {
                return in_array($record->status, ['finalist', 'winner'], true)
                    && ! $record->alumni()->exists();
            })
            ->form([
                Select::make('alumni_batch_id')
                    ->label('Angkatan')
                    ->options(fn (): array => AlumniBatch::query()
                        ->orderByDesc('year')
                        ->pluck('name', 'id')
                        ->all())
                    ->default(function (Participant $record): ?int {
                        return AlumniBatch::query()
                            ->where('election_id', $record->election_id)
                            ->orderByDesc('year')
                            ->value('id');
                    })
                    ->searchable()
                    ->required()
                    ->helperText(function (Participant $record): ?string {
                        $hasBatch = AlumniBatch::query()
                            ->where('election_id', $record->election_id)
                            ->exists();

                        return $hasBatch
                            ? null
                            : 'Angkatan untuk Pemilihan ini belum tersedia. Buat Angkatan terlebih dahulu atau pilih angkatan lain.';
                    }),
            ])
            ->action(function (Participant $record, array $data): void {
                try {
                    $alumni = app(PromoteParticipantToAlumni::class)->handle($record, [
                        'alumni_batch_id' => $data['alumni_batch_id'] ?? null,
                        'is_public' => false,
                        'is_active' => true,
                    ]);

                    Notification::make()
                        ->title('Alumni berhasil dibuat')
                        ->body("{$alumni->name} telah ditambahkan ke angkatan terkait.")
                        ->success()
                        ->send();
                } catch (Throwable $exception) {
                    Notification::make()
                        ->title('Gagal menjadikan alumni')
                        ->body($exception->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
