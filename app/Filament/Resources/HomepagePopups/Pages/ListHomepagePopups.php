<?php

namespace App\Filament\Resources\HomepagePopups\Pages;

use App\Filament\Resources\HomepagePopups\HomepagePopupResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHomepagePopups extends ListRecords
{
    protected static string $resource = HomepagePopupResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Tambah Popup')];
    }
}
