<?php

namespace App\Filament\Resources\HomepagePopups\Pages;

use App\Filament\Resources\HomepagePopups\HomepagePopupResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditHomepagePopup extends EditRecord
{
    protected static string $resource = HomepagePopupResource::class;

    protected function getHeaderActions(): array
    {
        return [ViewAction::make(), DeleteAction::make()];
    }
}
