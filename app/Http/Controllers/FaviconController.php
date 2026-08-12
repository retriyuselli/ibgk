<?php

namespace App\Http\Controllers;

use App\Models\OrganizationProfile;
use App\Services\RenderOrganizationFavicon;
use Illuminate\Http\Response;

class FaviconController extends Controller
{
    public function __construct(
        private RenderOrganizationFavicon $faviconRenderer,
    ) {}

    public function favicon(): Response
    {
        return $this->pngResponse(32);
    }

    public function appleTouchIcon(): Response
    {
        return $this->pngResponse(180);
    }

    private function pngResponse(int $size): Response
    {
        $profile = OrganizationProfile::query()->first();
        $png = $this->faviconRenderer->png($profile, $size);

        return response($png, 200, [
            'Content-Type' => 'image/png',
            'Cache-Control' => 'public, max-age=86400',
        ]);
    }
}
