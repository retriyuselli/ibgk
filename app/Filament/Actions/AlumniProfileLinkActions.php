<?php

namespace App\Filament\Actions;

use App\Models\Alumni;
use App\Services\AlumniProfileInviteService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Collection;

class AlumniProfileLinkActions
{
    public static function copyLink(): Action
    {
        return Action::make('copyProfileLink')
            ->label('Salin Link Formulir')
            ->icon(Heroicon::OutlinedLink)
            ->color('gray')
            ->action(function (Alumni $record, AlumniProfileInviteService $service): void {
                $url = $service->ensureInvite($record);

                Notification::make()
                    ->title('Link formulir alumni')
                    ->body($url)
                    ->success()
                    ->persistent()
                    ->send();
            });
    }

    public static function regenerateLink(): Action
    {
        return Action::make('regenerateProfileLink')
            ->label('Buat Ulang Link')
            ->icon(Heroicon::OutlinedArrowPath)
            ->color('warning')
            ->requiresConfirmation()
            ->modalHeading('Buat ulang link formulir?')
            ->modalDescription('Link lama tidak akan bisa dipakai lagi. Alumni perlu menggunakan link baru.')
            ->action(function (Alumni $record, AlumniProfileInviteService $service): void {
                $url = $service->regenerateInvite($record);

                Notification::make()
                    ->title('Link formulir baru')
                    ->body($url)
                    ->success()
                    ->persistent()
                    ->send();
            });
    }

    public static function bulkGenerateLinks(): \Filament\Actions\BulkAction
    {
        return \Filament\Actions\BulkAction::make('generateProfileLinks')
            ->label('Buat Link Formulir')
            ->icon(Heroicon::OutlinedLink)
            ->action(function (Collection $records, AlumniProfileInviteService $service): void {
                $count = 0;

                $records->each(function (Alumni $record) use ($service, &$count): void {
                    $service->ensureInvite($record);
                    $count++;
                });

                Notification::make()
                    ->title("Link formulir dibuat untuk {$count} alumni")
                    ->body('Buka masing-masing alumni lalu salin link formulirnya.')
                    ->success()
                    ->send();
            })
            ->deselectRecordsAfterCompletion();
    }
}
