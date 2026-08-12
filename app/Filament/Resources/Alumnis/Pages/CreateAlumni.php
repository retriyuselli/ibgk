<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Filament\Resources\Alumnis\AlumniResource;
use App\Filament\Resources\Alumnis\Schemas\AlumniForm;
use Filament\Resources\Pages\CreateRecord;

class CreateAlumni extends CreateRecord
{
    protected static string $resource = AlumniResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        return AlumniForm::applySlugToData($data);
    }
}
