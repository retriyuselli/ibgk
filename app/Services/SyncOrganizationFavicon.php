<?php

namespace App\Services;

use App\Models\OrganizationProfile;

class SyncOrganizationFavicon
{
    public function __construct(
        private RenderOrganizationFavicon $faviconRenderer,
    ) {}

    public function handle(?OrganizationProfile $profile = null): bool
    {
        $profile ??= OrganizationProfile::query()->first();

        $favicon = $this->faviconRenderer->png($profile, 32);
        $appleTouch = $this->faviconRenderer->png($profile, 180);

        $faviconPath = public_path('favicon.ico');
        $appleTouchPath = public_path('apple-touch-icon.png');

        if (file_put_contents($faviconPath, $favicon) === false) {
            return false;
        }

        if (file_put_contents($appleTouchPath, $appleTouch) === false) {
            return false;
        }

        return true;
    }
}
