<?php

namespace App\Http\Controllers;

use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use App\Models\OrganizationProfile;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GalleryPageController extends Controller
{
    /** @var array<int, array{slug: string, name: string, match: string|null}> */
    public const CATEGORIES = [
        ['slug' => '', 'name' => 'Semua Galeri', 'match' => null],
        ['slug' => 'pemilihan-bgk', 'name' => 'Pemilihan BGK', 'match' => 'Pemilihan BGK'],
        ['slug' => 'kegiatan', 'name' => 'Kegiatan', 'match' => 'Kegiatan'],
        ['slug' => 'kegiatan-sosial', 'name' => 'Kegiatan Sosial', 'match' => 'Kegiatan Sosial'],
        ['slug' => 'budaya-pariwisata', 'name' => 'Budaya & Pariwisata', 'match' => 'Budaya & Pariwisata'],
        ['slug' => 'internal-ibgk', 'name' => 'Internal IBGK', 'match' => 'Internal IBGK'],
        ['slug' => 'event-kolaborasi', 'name' => 'Event & Kolaborasi', 'match' => 'Event & Kolaborasi'],
    ];

    public function __invoke(Request $request): View
    {
        $profile = OrganizationProfile::query()->first();
        $categorySlug = $request->string('kategori')->toString();
        $selectedCategory = collect(self::CATEGORIES)->firstWhere('slug', $categorySlug) ?? self::CATEGORIES[0];
        $search = trim($request->string('q')->toString());
        $sort = $request->string('urut', 'terbaru')->toString();
        $showAll = $request->boolean('semua');

        $baseQuery = GalleryAlbum::query()
            ->published()
            ->withCount('photos')
            ->when(filled($selectedCategory['match']), fn ($query) => $query->where('category', $selectedCategory['match']))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($builder) use ($search): void {
                    $builder
                        ->where('title', 'like', '%'.$search.'%')
                        ->orWhere('description', 'like', '%'.$search.'%')
                        ->orWhere('location', 'like', '%'.$search.'%')
                        ->orWhere('category', 'like', '%'.$search.'%');
                });
            });

        $sortedQuery = match ($sort) {
            'terlama' => (clone $baseQuery)->oldest('event_date'),
            'a-z' => (clone $baseQuery)->orderBy('title'),
            default => (clone $baseQuery)->latest('event_date'),
        };

        $totalAlbumCount = GalleryAlbum::query()->published()->count();
        $totalPhotoCount = GalleryPhoto::query()->count();

        $categoryCounts = collect(self::CATEGORIES)->map(function (array $category) use ($totalAlbumCount): array {
            $count = filled($category['match'])
                ? GalleryAlbum::query()->published()->where('category', $category['match'])->count()
                : $totalAlbumCount;

            return array_merge($category, ['count' => $count]);
        });

        $featuredAlbums = (clone $sortedQuery)
            ->when(! $showAll, fn ($query) => $query->where('is_featured', true))
            ->take($showAll ? 1000 : 8)
            ->get();

        if ($featuredAlbums->isEmpty()) {
            $featuredAlbums = (clone $sortedQuery)->take($showAll ? 1000 : 8)->get();
        }

        $albums = $showAll
            ? $sortedQuery->paginate(8)->withQueryString()
            : null;

        $previewPhotos = GalleryPhoto::query()
            ->whereHas('album', fn ($query) => $query->published())
            ->with('album')
            ->latest('id')
            ->take(12)
            ->get();

        $yearsActive = $profile?->founded_at
            ? max(1, (int) now()->format('Y') - (int) $profile->founded_at->format('Y'))
            : 10;

        return view('pages.gallery', [
            'profile' => $profile,
            'categories' => $categoryCounts,
            'selectedCategory' => $selectedCategory,
            'totalAlbumCount' => $totalAlbumCount,
            'featuredAlbums' => $featuredAlbums,
            'albums' => $albums,
            'previewPhotos' => $previewPhotos,
            'search' => $search,
            'sort' => $sort,
            'showAll' => $showAll,
            'stats' => [
                'albums' => max($totalAlbumCount, 156),
                'photos' => max($totalPhotoCount, 2540),
                'years' => $yearsActive,
                'since' => '2002',
            ],
        ]);
    }
}
