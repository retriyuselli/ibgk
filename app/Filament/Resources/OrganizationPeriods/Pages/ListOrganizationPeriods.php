<?php

namespace App\Filament\Resources\OrganizationPeriods\Pages;

use App\Filament\Resources\OrganizationPeriods\OrganizationPeriodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationPeriods extends ListRecords
{
    protected static string $resource = OrganizationPeriodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Periode'),
        ];
    }
}
