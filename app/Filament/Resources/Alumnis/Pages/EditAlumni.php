<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Filament\Actions\AlumniProfileLinkActions;
use App\Filament\Resources\Alumnis\AlumniResource;
use App\Filament\Resources\Alumnis\Schemas\AlumniForm;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAlumni extends EditRecord
{
    protected static string $resource = AlumniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            AlumniProfileLinkActions::copyLink(),
            AlumniProfileLinkActions::regenerateLink(),
            ViewAction::make(),
            DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Alumni')
                ->modalDescription('Data alumni adalah arsip penting. Pertimbangkan menonaktifkan daripada menghapus. Lanjutkan hapus?'),
        ];
    }

    protected function mutateFormDataBeforeSave(array $data): array
    {
        return AlumniForm::applySlugToData($data, $this->getRecord()->id);
    }
}
