<?php

namespace App\Observers;

use App\Models\OrganizationProfile;
use App\Services\SyncOrganizationFavicon;

class OrganizationProfileObserver
{
    public function __construct(
        private SyncOrganizationFavicon $syncOrganizationFavicon,
    ) {}

    public function saved(OrganizationProfile $organizationProfile): void
    {
        if (! $organizationProfile->wasChanged('logo')) {
            return;
        }

        $this->syncOrganizationFavicon->handle($organizationProfile);
    }
}
