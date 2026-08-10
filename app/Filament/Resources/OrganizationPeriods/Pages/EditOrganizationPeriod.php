<?php

namespace App\Filament\Resources\OrganizationPeriods\Pages;

use App\Filament\Resources\OrganizationPeriods\OrganizationPeriodResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditOrganizationPeriod extends EditRecord
{
    protected static string $resource = OrganizationPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Periode Kepengurusan')
                ->modalDescription('Menghapus periode ini juga akan menghapus seluruh data pengurus pada periode tersebut. Lanjutkan?')
                ->modalSubmitActionLabel('Ya, Hapus'),
        ];
    }
}
