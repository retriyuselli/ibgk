<?php

namespace App\Support;

use App\Models\Page;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Schema;

class CmsPages
{
    /** @var Collection<string, Page>|null */
    private ?Collection $pages = null;

    /** @return Collection<string, Page> */
    public function all(): Collection
    {
        if ($this->pages === null) {
            if (! $this->pagesTableExists()) {
                $this->pages = collect();
            } else {
                try {
                    $this->pages = Page::query()->published()->get()->keyBy('slug');
                } catch (\Throwable) {
                    $this->pages = collect();
                }
            }
        }

        return $this->pages;
    }

    private function pagesTableExists(): bool
    {
        try {
            return Schema::hasTable('pages');
        } catch (\Throwable) {
            return false;
        }
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

    /**
     * @return list<array{src: ?string, fallback: string, alt: string, class: string}>
     */
    public function aboutCollage(): array
    {
        $page = $this->get('about');

        return [
            [
                'src' => $page?->about_image_1,
                'fallback' => 'images/home/about-1.jpg',
                'alt' => 'Kegiatan IBGK',
                'class' => 'aspect-[4/5] w-full rounded-sm object-cover shadow-sm',
            ],
            [
                'src' => $page?->about_image_2,
                'fallback' => 'images/home/about-2.jpg',
                'alt' => 'Pengabdian masyarakat',
                'class' => 'aspect-[4/3] w-full rounded-sm object-cover shadow-sm',
            ],
            [
                'src' => $page?->about_image_3,
                'fallback' => 'images/home/about-3.jpg',
                'alt' => 'Acara budaya',
                'class' => 'aspect-[4/3] w-full rounded-sm object-cover shadow-sm',
            ],
            [
                'src' => $page?->about_image_4,
                'fallback' => 'images/home/about-4.jpg',
                'alt' => 'Keluarga besar IBGK',
                'class' => 'aspect-[4/5] w-full rounded-sm object-cover shadow-sm',
            ],
        ];
    }
}
