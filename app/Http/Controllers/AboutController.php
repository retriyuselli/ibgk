<?php

namespace App\Http\Controllers;

use App\Models\HonoraryMember;
use App\Models\OrganizationProfile;
use Illuminate\View\View;

class AboutController extends Controller
{
    public function __invoke(): View
    {
        $profile = OrganizationProfile::query()->first();

        return view('pages.about', [
            'profile' => $profile,
            'yearsActive' => $profile?->founded_at
                ? max(1, (int) now()->format('Y') - (int) $profile->founded_at->format('Y'))
                : 27,
            'honoraryMembers' => HonoraryMember::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
        ]);
    }
}
