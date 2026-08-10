<?php

namespace App\Filament\Resources\PartnerCategories\Pages;

use App\Filament\Resources\PartnerCategories\PartnerCategoryResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditPartnerCategory extends EditRecord
{
    protected static string $resource = PartnerCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [ViewAction::make(), DeleteAction::make()];
    }
}
