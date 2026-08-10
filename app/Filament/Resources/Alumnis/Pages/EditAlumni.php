<?php

namespace App\Filament\Resources\Alumnis\Pages;

use App\Filament\Resources\Alumnis\AlumniResource;
use Filament\Actions\DeleteAction;
use Filament\Actions\ViewAction;
use Filament\Resources\Pages\EditRecord;

class EditAlumni extends EditRecord
{
    protected static string $resource = AlumniResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ViewAction::make(),
            DeleteAction::make()
                ->requiresConfirmation()
                ->modalHeading('Hapus Alumni')
                ->modalDescription('Data alumni adalah arsip penting. Pertimbangkan menonaktifkan daripada menghapus. Lanjutkan hapus?'),
        ];
    }
}
