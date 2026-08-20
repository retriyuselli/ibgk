<?php

namespace App\Filament\Resources\AlumniBatches\Pages;

use App\Filament\Resources\AlumniBatches\AlumniBatchResource;
use App\Filament\Resources\AlumniBatches\Widgets\AlumniBatchStatsOverview;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListAlumniBatches extends ListRecords
{
    protected static string $resource = AlumniBatchResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('Tambah Angkatan'),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            AlumniBatchStatsOverview::class,
        ];
    }
}
