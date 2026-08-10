<?php

namespace App\Filament\Resources\HonoraryMembers\Pages;

use App\Filament\Resources\HonoraryMembers\HonoraryMemberResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;

class ViewHonoraryMember extends ViewRecord
{
    protected static string $resource = HonoraryMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
