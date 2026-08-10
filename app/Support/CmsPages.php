<?php

namespace App\Support;

use App\Models\Page;
use Illuminate\Support\Collection;

class CmsPages
{
    /** @var Collection<string, Page>|null */
    private ?Collection $pages = null;

    /** @return Collection<string, Page> */
    public function all(): Collection
    {
        if ($this->pages === null) {
            $this->pages = Page::query()->published()->get()->keyBy('slug');
        }

        return $this->pages;
    }

    public function get(string $slug): ?Page
    {
        return $this->all()->get($slug);
    }

    /**
     * @param  array{title?: string, subtitle?: ?string, excerpt?: ?string, quote?: ?string, image?: string, imageAlt?: string}  $fallbacks
     * @return array{title: string, subtitle: ?string, excerpt: ?string, quote: ?string, image: string, imageAlt: string}
     */
    public function hero(string $slug, array $fallbacks = []): array
    {
        $page = $this->get($slug);

        $title = filled($page?->title) ? $page->title : ($fallbacks['title'] ?? '');
        $subtitle = filled($page?->meta_title) ? $page->meta_title : ($fallbacks['subtitle'] ?? null);
        $excerpt = filled(trim(strip_tags((string) ($page?->excerpt ?? ''))))
            ? $page->excerpt
            : ($fallbacks['excerpt'] ?? null);
        $quote = filled($page?->meta_description) ? $page->meta_description : ($fallbacks['quote'] ?? null);
        $fallbackImage = $fallbacks['image'] ?? 'images/home/hero-ampera.jpg';

        return [
            'title' => $title,
            'subtitle' => $subtitle,
            'excerpt' => $excerpt,
            'quote' => $quote,
            'image' => $page?->banner ? asset('storage/'.$page->banner) : asset($fallbackImage),
            'imageAlt' => $fallbacks['imageAlt'] ?? $title,
        ];
    }
}
