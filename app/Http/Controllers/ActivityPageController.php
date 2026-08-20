<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\ActivityCategory;
use App\Models\GalleryAlbum;
use App\Models\OrganizationProfile;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityPageController extends Controller
{
    public function show(Activity $activity): View
    {
        abort_unless($this->isPublished($activity), 404);

        $relatedActivities = Activity::query()
            ->published()
            ->with('category')
            ->whereKeyNot($activity->id)
            ->when($activity->activity_category_id, fn ($query) => $query->where('activity_category_id', $activity->activity_category_id))
            ->orderByDesc('activity_date')
            ->take(3)
            ->get();

        return view('pages.activity-show', [
            'profile' => OrganizationProfile::query()->first(),
            'activity' => $activity->load('category'),
            'relatedActivities' => $relatedActivities,
        ]);
    }

    public function __invoke(Request $request): View|JsonResponse
    {
        $categories = ActivityCategory::query()
            ->where('is_active', true)
            ->orderBy('sort_order')
            ->get();

        $categorySlug = $request->string('kategori')->toString();
        $selectedCategory = $categories->firstWhere('slug', $categorySlug);

        $featuredActivities = Activity::query()
            ->published()
            ->with('category')
            ->when($selectedCategory, fn ($query) => $query->where('activity_category_id', $selectedCategory->id))
            ->orderByDesc('is_featured')
            ->orderByDesc('activity_date')
            ->paginate(8)
            ->withQueryString();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('partials.activities.card-items', [
                    'featuredActivities' => $featuredActivities,
                    'placeholderOffset' => ($featuredActivities->currentPage() - 1) * $featuredActivities->perPage(),
                ])->render(),
                'has_more' => $featuredActivities->hasMorePages(),
                'next_page' => $featuredActivities->hasMorePages() ? $featuredActivities->currentPage() + 1 : null,
            ]);
        }

        $galleryAlbums = GalleryAlbum::query()
            ->published()
            ->orderByDesc('event_date')
            ->take(8)
            ->get();

        $activityCount = Activity::query()->published()->count();

        return view('pages.activities', [
            'profile' => OrganizationProfile::query()->first(),
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'featuredActivities' => $featuredActivities,
            'galleryAlbums' => $galleryAlbums,
            'stats' => [
                'since' => '2002',
                'programs' => max($activityCount, 200),
                'beneficiaries' => 'Ribuan',
                'partners' => '50+',
                'regions' => '17',
            ],
        ]);
    }

    private function isPublished(Activity $activity): bool
    {
        if (! $activity->is_published) {
            return false;
        }

        return $activity->published_at === null || $activity->published_at->lte(now());
    }
}
