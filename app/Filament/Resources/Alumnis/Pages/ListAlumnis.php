<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Filament\Actions\AlumniProfileLinkActions;
use App\Filament\Resources\Alumnis\AlumniResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlumnis extends ListRecords
{
    protected static string $resource = AlumniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            AlumniProfileLinkActions::copyPublicRegistrationLink(),
            CreateAction::make()
                ->label('Tambah Alumni'),
        ];
    }
}
