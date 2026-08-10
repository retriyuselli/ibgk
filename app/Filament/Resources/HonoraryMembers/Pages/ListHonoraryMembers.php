<?php

namespace App\Filament\Resources\HonoraryMembers\Pages;

use App\Filament\Resources\HonoraryMembers\HonoraryMemberResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListHonoraryMembers extends ListRecords
{
    protected static string $resource = HonoraryMemberResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Anggota Kehormatan'),
        ];
    }
}
