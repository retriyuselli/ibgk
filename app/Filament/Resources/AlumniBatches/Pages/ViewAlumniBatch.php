<?php

namespace App\Filament\Resources\AlumniBatches\Pages;

use App\Filament\Resources\AlumniBatches\AlumniBatchResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewAlumniBatch extends ViewRecord
{
    protected static string $resource = AlumniBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
