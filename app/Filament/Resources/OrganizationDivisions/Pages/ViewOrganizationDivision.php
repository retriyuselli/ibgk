<?php

namespace App\Filament\Resources\OrganizationDivisions\Pages;

use App\Filament\Resources\OrganizationDivisions\OrganizationDivisionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrganizationDivision extends ViewRecord
{
    protected static string $resource = OrganizationDivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
