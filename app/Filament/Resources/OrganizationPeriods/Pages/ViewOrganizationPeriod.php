<?php

namespace App\Filament\Resources\OrganizationPeriods\Pages;

use App\Filament\Resources\OrganizationPeriods\OrganizationPeriodResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrganizationPeriod extends ViewRecord
{
    protected static string $resource = OrganizationPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
