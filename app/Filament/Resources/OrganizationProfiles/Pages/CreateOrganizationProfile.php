<?php

namespace App\Filament\Resources\OrganizationProfiles\Pages;

use App\Filament\Resources\OrganizationProfiles\OrganizationProfileResource;
use App\Models\OrganizationProfile;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateOrganizationProfile extends CreateRecord
{
    protected static string $resource = OrganizationProfileResource::class;

    public function mount(): void
    {
        abort_unless(OrganizationProfileResource::canCreate(), 403);

        parent::mount();
    }

    public function getTitle(): string|Htmlable
    {
        return 'Buat Profil IBGK';
    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (OrganizationProfile::query()->exists()) {
            abort(403, 'Profil IBGK sudah tersedia.');
        }

        return $data;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('edit', ['record' => $this->getRecord()]);
    }
}
