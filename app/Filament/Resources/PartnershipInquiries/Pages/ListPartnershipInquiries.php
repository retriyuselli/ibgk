<?php

namespace App\Filament\Resources\PartnershipInquiries\Pages;

use App\Filament\Resources\PartnershipInquiries\PartnershipInquiryResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListPartnershipInquiries extends ListRecords
{
    protected static string $resource = PartnershipInquiryResource::class;

    protected function getHeaderActions(): array
    {
        return [CreateAction::make()->label('Tambah Pengajuan')];
    }
}
