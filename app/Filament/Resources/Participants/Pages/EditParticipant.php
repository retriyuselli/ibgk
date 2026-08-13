<?php

namespace App\Filament\Resources\Participants\Pages;

use App\Filament\Actions\PromoteParticipantToAlumniAction;
use App\Filament\Resources\Participants\ParticipantResource;
use App\Filament\Resources\Participants\Schemas\ParticipantForm;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditParticipant extends EditRecord
{
    protected static string $resource = ParticipantResource::class;

    protected function getHeaderActions(): array
    {
        return [
            PromoteParticipantToAlumniAction::make(),
            ViewAction::make(),
            DeleteAction::make(),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return ParticipantForm::applyIdentityToData($data, $this->getRecord()->id);
    }
}
