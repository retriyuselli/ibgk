<?php

namespace App\Http\Controllers;

use App\Models\ActivityCategory;
use App\Models\AlumniBatch;
use App\Models\HomepagePopup;
use App\Models\News;
use App\Models\OrganizationProfile;
use App\Models\Partner;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $profile = OrganizationProfile::query()->first();

        if (config('site.under_development') && ! auth()->check()) {
            return view('pages.home-gate', [
                'profile' => $profile,
            ]);
        }

        $batches = AlumniBatch::electionBatchesOrdered();

        $yearsActive = $profile?->founded_at
            ? max(1, (int) now()->format('Y') - (int) $profile->founded_at->format('Y'))
            : 27;

        return view('pages.home', [
            'profile' => $profile,
            'yearsActive' => $yearsActive,
            'batches' => $batches,
            'alumniCount' => AlumniBatch::totalPublicMembersUpToCurrentYear(),
            'batchCount' => AlumniBatch::activeBatchCountUpToCurrentYear(),
            'activityCategories' => ActivityCategory::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->get(),
            'latestNews' => News::query()
                ->published()
                ->latest('published_at')
                ->take(3)
                ->get(),
            'partners' => Partner::query()
                ->where('is_active', true)
                ->orderBy('sort_order')
                ->with('category')
                ->get(),
            'homepagePopup' => rescue(fn () => HomepagePopup::current()),
        ]);
    }
}
