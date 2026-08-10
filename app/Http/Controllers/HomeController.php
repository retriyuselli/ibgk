<?php

namespace App\Http\Controllers;

use App\Models\ActivityCategory;
use App\Models\AlumniBatch;
use App\Models\News;
use App\Models\OrganizationProfile;
use App\Models\Partner;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $profile = OrganizationProfile::query()->first();
        $batches = AlumniBatch::query()
            ->where('is_active', true)
            ->orderBy('year')
            ->get();

        $yearsActive = $profile?->founded_at
            ? max(1, (int) now()->format('Y') - (int) $profile->founded_at->format('Y'))
            : 27;

        return view('pages.home', [
            'profile' => $profile,
            'yearsActive' => $yearsActive,
            'batches' => $batches,
            'alumniCount' => (int) $batches->sum('historical_member_count'),
            'batchCount' => $batches->count(),
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
        ]);
    }
}
