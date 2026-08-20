<?php

namespace App\Filament\Resources\AlumniBatches\Pages;

use App\Filament\Resources\AlumniBatches\AlumniBatchResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\RestoreAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditAlumniBatch extends EditRecord
{
    protected static string $resource = AlumniBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            RestoreAction::make()
                ->label('Pulihkan'),
            DeleteAction::make()
                ->before(function (DeleteAction $action): void {
                    if ($this->getRecord()->alumni()->exists()) {
                        Notification::make()
                            ->title('Angkatan tidak dapat dihapus')
                            ->body('Angkatan masih memiliki data alumni. Nonaktifkan angkatan jika tidak ingin ditampilkan.')
                            ->danger()
                            ->send();

                        $action->cancel();
                    }
                })
                ->requiresConfirmation()
                ->modalHeading('Hapus Angkatan')
                ->modalDescription('Hanya angkatan tanpa alumni yang dapat dihapus. Angkatan yang dihapus tidak akan dibuat ulang otomatis.'),
        ];
    }
}
