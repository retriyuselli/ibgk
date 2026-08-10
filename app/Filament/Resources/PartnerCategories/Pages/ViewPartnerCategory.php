<?php

namespace App\Filament\Resources\PartnerCategories\Pages;

use App\Filament\Resources\PartnerCategories\PartnerCategoryResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewPartnerCategory extends ViewRecord
{
    protected static string $resource = PartnerCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }
}
