@php
    $placeholders = [
        'images/home/about-1.jpg',
        'images/home/about-2.jpg',
        'images/home/about-3.jpg',
        'images/home/about-4.jpg',
        'images/home/news-1.jpg',
        'images/home/news-2.jpg',
        'images/home/election-poster.jpg',
        'images/home/sejarah-grand-final.jpg',
    ];

    $displayAlbums = $showAll && $albums ? $albums : $featuredAlbums;
@endphp

<section id="album" class="relative overflow-hidden bg-white py-14 sm:py-16 lg:py-20">
    <div class="site-container">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="section-title">{{ $showAll ? 'Semua Album' : 'Galeri Unggulan' }}</h2>
                <div class="mt-3 h-px w-16 bg-gold"></div>
            </div>
            @unless ($showAll)
                <a href="{{ route('gallery', array_filter(['kategori' => $selectedCategory['slug'] ?: null, 'q' => $search ?: null, 'urut' => $sort !== 'terbaru' ? $sort : null, 'semua' => 1])) }}" class="shrink-0 text-xs font-semibold tracking-[0.14em] text-gold uppercase hover:text-navy">
                    Lihat Semua Album →
                </a>
            @endunless
        </div>

        @if ($displayAlbums->isNotEmpty())
            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($displayAlbums as $index => $album)
                    <article class="group overflow-hidden rounded-sm border border-navy/8 bg-cream/30 shadow-sm transition hover:border-gold/35 hover:shadow-md">
                        <div class="relative overflow-hidden">
                            <img
                                src="{{ $album->cover ? asset('storage/'.$album->cover) : asset($placeholders[$index % count($placeholders)]) }}"
                                alt="{{ $album->title }}"
                                class="aspect-[4/3] w-full object-cover transition duration-500 group-hover:scale-105"
                            >
                            <span class="absolute top-3 right-3 rounded bg-navy/80 px-2 py-1 text-[10px] font-semibold tracking-wide text-gold uppercase">
                                {{ $album->photos_count ?: 0 }} Foto
                            </span>
                        </div>
                        <div class="px-4 py-4">
                            <h3 class="font-display text-base font-semibold leading-snug text-navy">{{ $album->title }}</h3>
                            <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-muted">
                                {{ $album->description ?: 'Dokumentasi kegiatan IBGK Sumatera Selatan.' }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($showAll && $albums && $albums->hasPages())
                <div class="mt-10">
                    {{ $albums->onEachSide(1)->links('partials.news.pagination') }}
                </div>
            @endif
        @else
            <div class="mt-10 border border-dashed border-navy/15 bg-cream/50 px-6 py-12 text-center">
                <p class="font-display text-xl text-navy">Album tidak ditemukan</p>
                <p class="mt-2 text-sm text-muted">Coba kata kunci lain atau pilih kategori berbeda.</p>
                <a href="{{ route('gallery') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-gold hover:text-navy">
                    Lihat semua galeri →
                </a>
            </div>
        @endif
    </div>
</section>
