@php
    $galleryImages = [
        'images/home/about-1.jpg',
        'images/home/about-2.jpg',
        'images/home/about-3.jpg',
        'images/home/about-4.jpg',
        'images/home/alumni-placeholder.jpg',
        'images/home/election-poster.jpg',
        'images/home/sejarah-grand-final.jpg',
        'images/home/news-1.jpg',
    ];
@endphp

<section id="galeri" class="relative overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    <div class="site-container">
        <div class="flex items-end justify-between gap-4">
            <div>
                <h2 class="section-title">Galeri Kegiatan</h2>
                <div class="mt-3 h-px w-16 bg-gold"></div>
            </div>
            <a href="{{ route('gallery') }}" class="shrink-0 text-xs font-semibold tracking-[0.14em] text-gold uppercase hover:text-navy">
                Lihat Semua Galeri →
            </a>
        </div>

        <div class="relative mt-8">
            <button type="button" id="gallery-prev" class="absolute top-1/2 left-0 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-navy/15 bg-white text-navy shadow-sm transition hover:border-gold hover:text-gold sm:-left-2" aria-label="Sebelumnya">
                ←
            </button>
            <button type="button" id="gallery-next" class="absolute top-1/2 right-0 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-navy/15 bg-white text-navy shadow-sm transition hover:border-gold hover:text-gold sm:-right-2" aria-label="Berikutnya">
                →
            </button>

            <div id="gallery-track" class="alumni-track px-8 sm:px-10">
                @forelse ($galleryAlbums as $index => $album)
                    <article class="alumni-card w-64 shrink-0 overflow-hidden border border-navy/8 bg-white shadow-sm sm:w-72">
                        <img
                            src="{{ $album->cover ? asset('storage/'.$album->cover) : asset($galleryImages[$index % count($galleryImages)]) }}"
                            alt="{{ $album->title }}"
                            class="aspect-[4/3] w-full object-cover"
                        >
                        <div class="px-4 py-3">
                            <p class="text-[10px] font-semibold tracking-[0.12em] text-gold uppercase">{{ $album->category ?: 'Galeri' }}</p>
                            <h3 class="mt-1 text-sm font-semibold text-navy">{{ $album->title }}</h3>
                        </div>
                    </article>
                @empty
                    @foreach (array_slice($galleryImages, 0, 5) as $image)
                        <article class="alumni-card w-64 shrink-0 overflow-hidden border border-navy/8 bg-white shadow-sm sm:w-72">
                            <img src="{{ asset($image) }}" alt="Galeri kegiatan" class="aspect-[4/3] w-full object-cover">
                            <div class="px-4 py-3">
                                <p class="text-[10px] font-semibold tracking-[0.12em] text-gold uppercase">Dokumentasi</p>
                                <h3 class="mt-1 text-sm font-semibold text-navy">Kegiatan IBGK Sumsel</h3>
                            </div>
                        </article>
                    @endforeach
                @endforelse
            </div>
        </div>
    </div>
</section>
