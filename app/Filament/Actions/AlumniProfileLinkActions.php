<?php

namespace App\Filament\Actions;

use App\Models\Alumni;
use App\Services\AlumniProfileInviteService;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Js;
use Livewire\Component;

class AlumniProfileLinkActions
{
    public static function copyPublicRegistrationLink(): Action
    {
        return Action::make('copyPublicRegistrationLink')
            ->label('Salin Link Formulir Umum')
            ->icon(Heroicon::OutlinedGlobeAlt)
            ->color('info')
            ->action(function (Component $livewire): void {
                self::copyUrlToClipboard($livewire, route('alumni.register'));
                self::notifyCopied('Link formulir umum disalin');
            });
    }

    public static function copyLink(): Action
    {
        return Action::make('copyProfileLink')
            ->label('Salin Link Formulir')
            ->icon(Heroicon::OutlinedLink)
            ->color('gray')
            ->action(function (Alumni $record, AlumniProfileInviteService $service, Component $livewire): void {
                $url = $service->ensureInvite($record);

                self::copyUrlToClipboard($livewire, $url);
                self::notifyCopied('Link formulir alumni disalin');
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
            ->action(function (Alumni $record, AlumniProfileInviteService $service, Component $livewire): void {
                $url = $service->regenerateInvite($record);

                self::copyUrlToClipboard($livewire, $url);
                self::notifyCopied('Link formulir baru disalin');
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

    private static function copyUrlToClipboard(Component $livewire, string $url): void
    {
        $livewire->js('window.navigator.clipboard.writeText('.Js::from($url).')');
    }

    private static function notifyCopied(string $title): void
    {
        Notification::make()
            ->title($title)
            ->body('Link telah disalin ke clipboard. Tempel (Ctrl+V / Cmd+V) untuk membagikannya.')
            ->success()
            ->send();
    }
}
