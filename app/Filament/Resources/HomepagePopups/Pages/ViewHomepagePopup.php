<?php

namespace App\Filament\Resources\HomepagePopups\Pages;

use App\Filament\Resources\HomepagePopups\HomepagePopupResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHomepagePopup extends ViewRecord
{
    protected static string $resource = HomepagePopupResource::class;

    protected function getHeaderActions(): array
    {
        return [EditAction::make()];
    }
}
