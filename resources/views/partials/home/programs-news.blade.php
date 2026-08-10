@php
    $programIcons = [
        '<path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z"/>',
        '<path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>',
        '<path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-8 8h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v11a2 2 0 002 2z"/>',
        '<path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0"/>',
        '<path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/>',
    ];

    $fallbackNews = [
        ['title' => 'IBGK Sumsel gelar kegiatan pembinaan karakter generasi muda', 'date' => '20 Mei 2024', 'image' => 'news-1.jpg'],
        ['title' => 'Kolaborasi budaya dan pariwisata bersama mitra daerah', 'date' => '12 April 2024', 'image' => 'news-2.jpg'],
        ['title' => 'Jejaring alumni memperkuat kontribusi sosial di Sumsel', 'date' => '28 Maret 2024', 'image' => 'news-3.jpg'],
    ];
@endphp

<section class="relative bg-white py-16 sm:py-20 lg:py-24 overflow-hidden">
    <div class="site-container grid gap-12 lg:grid-cols-[1.1fr_0.9fr] lg:gap-14">
        <div id="program">
            <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Program</p>
            <h2 class="section-title mt-3">Program & Kegiatan</h2>

            <ul class="mt-8 space-y-3">
                @forelse ($activityCategories as $index => $category)
                    <li>
                        <a href="{{ route('activities', ['kategori' => $category->slug]) }}" class="group flex items-center gap-4 border border-navy/8 bg-cream/60 px-4 py-4 transition hover:border-gold/40 hover:bg-cream">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-white text-gold shadow-sm">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">{!! $programIcons[$index % count($programIcons)] !!}</svg>
                            </span>
                            <span class="font-medium text-navy group-hover:text-navy-deep">{{ $category->name }}</span>
                        </a>
                    </li>
                @empty
                    <li class="text-sm text-muted">Belum ada kategori kegiatan.</li>
                @endforelse
            </ul>
        </div>

        <div id="berita">
            <div class="flex items-end justify-between gap-4">
                <div>
                    <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Informasi</p>
                    <h2 class="section-title mt-3">Berita Terbaru</h2>
                </div>
                <a href="{{ route('news') }}" class="shrink-0 text-xs font-semibold tracking-[0.14em] text-gold uppercase hover:text-navy">
                    Lihat Semua
                </a>
            </div>

            <ul class="mt-8 space-y-5">
                @if ($latestNews->isNotEmpty())
                    @foreach ($latestNews as $index => $news)
                        <li>
                            <a href="{{ route('news.show', $news) }}" class="group flex gap-4">
                                <img
                                    src="{{ $news->thumbnail ? asset('storage/'.$news->thumbnail) : asset('images/home/news-'.(($index % 3) + 1).'.jpg') }}"
                                    alt="{{ $news->title }}"
                                    class="h-20 w-24 shrink-0 rounded-sm object-cover"
                                >
                                <div>
                                    <h3 class="text-sm font-semibold text-navy transition group-hover:text-gold sm:text-base">
                                        {{ $news->title }}
                                    </h3>
                                    <p class="mt-1.5 text-xs text-muted">
                                        {{ optional($news->published_at)->translatedFormat('d F Y') ?? '—' }}
                                    </p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @else
                    @foreach ($fallbackNews as $news)
                        <li>
                            <a href="{{ route('news') }}" class="group flex gap-4">
                                <img src="{{ asset('images/home/'.$news['image']) }}" alt="{{ $news['title'] }}" class="h-20 w-24 shrink-0 rounded-sm object-cover">
                                <div>
                                    <h3 class="text-sm font-semibold text-navy transition group-hover:text-gold sm:text-base">
                                        {{ $news['title'] }}
                                    </h3>
                                    <p class="mt-1.5 text-xs text-muted">{{ $news['date'] }}</p>
                                </div>
                            </a>
                        </li>
                    @endforeach
                @endif
            </ul>
        </div>
    </div>
</section>
