<?php

namespace App\Filament\Resources\HonoraryMembers\Pages;

use App\Filament\Resources\HonoraryMembers\HonoraryMemberResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditHonoraryMember extends EditRecord
{
    protected static string $resource = HonoraryMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }
}
