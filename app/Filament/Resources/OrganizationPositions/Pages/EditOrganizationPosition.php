<?php

namespace App\Filament\Resources\OrganizationPositions\Pages;

use App\Filament\Resources\OrganizationPositions\OrganizationPositionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationPosition extends EditRecord
{
    protected static string $resource = OrganizationPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->before(function (DeleteAction $action): void {
                    if ($this->getRecord()->members()->exists()) {
                        Notification::make()
                            ->title('Jabatan tidak dapat dihapus')
                            ->body('Jabatan masih digunakan oleh data pengurus.')
                            ->danger()
                            ->send();

                        $action->cancel();
                    }
                }),
        ];
    }
}
