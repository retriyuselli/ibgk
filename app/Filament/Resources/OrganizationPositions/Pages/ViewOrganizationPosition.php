<?php

namespace App\Filament\Resources\OrganizationPositions\Pages;

use App\Filament\Resources\OrganizationPositions\OrganizationPositionResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewOrganizationPosition extends ViewRecord
{
    protected static string $resource = OrganizationPositionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
