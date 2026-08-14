<?php

namespace App\Filament\Resources\OrganizationDivisions\Pages;

use App\Filament\Resources\OrganizationDivisions\OrganizationDivisionResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationDivision extends EditRecord
{
    protected static string $resource = OrganizationDivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->before(function (DeleteAction $action): void {
                    if ($this->getRecord()->members()->exists()) {
                        Notification::make()
                            ->title('Bidang tidak dapat dihapus')
                            ->body('Bidang masih digunakan oleh data pengurus.')
                            ->danger()
                            ->send();

                        $action->cancel();
                    }
                }),
        ];
    }
}
