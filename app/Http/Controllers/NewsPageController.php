<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\OrganizationProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsPageController extends Controller
{
    public function show(News $news): View
    {
        abort_unless($this->isPublished($news), 404);

        $news->increment('views');

        $relatedNews = News::query()
            ->published()
            ->with('category')
            ->whereKeyNot($news->id)
            ->when($news->news_category_id, fn ($query) => $query->where('news_category_id', $news->news_category_id))
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($relatedNews->count() < 3) {
            $relatedNews = News::query()
                ->published()
                ->with('category')
                ->whereKeyNot($news->id)
                ->latest('published_at')
                ->take(3)
                ->get();
        }

        return view('pages.news-show', [
            'profile' => OrganizationProfile::query()->first(),
            'news' => $news->load('category'),
            'relatedNews' => $relatedNews,
        ]);
    }

    public function __invoke(Request $request): View
    {
        $categories = NewsCategory::query()
            ->where('is_active', true)
            ->withCount(['news' => fn ($query) => $query->published()])
            ->orderBy('sort_order')
            ->get();

        $totalNewsCount = News::query()->published()->count();
        $categorySlug = $request->string('kategori')->toString();
        $selectedCategory = $categories->firstWhere('slug', $categorySlug);
        $search = trim($request->string('q')->toString());
        $sort = $request->string('urut', 'terbaru')->toString();

        $newsQuery = News::query()
            ->published()
            ->with('category')
            ->when($selectedCategory, fn ($query) => $query->where('news_category_id', $selectedCategory->id))
            ->when($search !== '', function ($query) use ($search): void {
                $query->where(function ($builder) use ($search): void {
                    $builder
                        ->where('title', 'like', '%'.$search.'%')
                        ->orWhere('excerpt', 'like', '%'.$search.'%')
                        ->orWhere('location', 'like', '%'.$search.'%');
                });
            });

        $newsQuery = match ($sort) {
            'terlama' => $newsQuery->oldest('published_at'),
            'populer' => $newsQuery->orderByDesc('views')->orderByDesc('published_at'),
            default => $newsQuery->latest('published_at'),
        };

        $news = $newsQuery
            ->paginate(9)
            ->withQueryString();

        $popularNews = News::query()
            ->published()
            ->with('category')
            ->orderByDesc('views')
            ->orderByDesc('published_at')
            ->take(5)
            ->get();

        return view('pages.news', [
            'profile' => OrganizationProfile::query()->first(),
            'categories' => $categories,
            'selectedCategory' => $selectedCategory,
            'totalNewsCount' => $totalNewsCount,
            'news' => $news,
            'popularNews' => $popularNews,
            'search' => $search,
            'sort' => $sort,
        ]);
    }

    public function subscribe(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        ContactMessage::query()->create([
            'name' => 'Pelanggan Berita',
            'email' => $validated['email'],
            'subject' => 'Langganan Berita',
            'message' => 'Permintaan langganan newsletter berita IBGK Sumsel.',
            'status' => ContactMessage::STATUS_NEW,
        ]);

        return redirect()
            ->route('news')
            ->with('newsletter_success', 'Terima kasih! Anda telah terdaftar untuk menerima berita terbaru.');
    }

    private function isPublished(News $news): bool
    {
        if (! $news->is_published) {
            return false;
        }

        return $news->published_at === null || $news->published_at->lte(now());
    }
}
