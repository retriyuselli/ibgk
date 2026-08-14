<?php

namespace App\Filament\Resources\OrganizationDivisions\Pages;

use App\Filament\Resources\OrganizationDivisions\OrganizationDivisionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListOrganizationDivisions extends ListRecords
{
    protected static string $resource = OrganizationDivisionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Bidang'),
        ];
    }
}
