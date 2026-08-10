@php
    $resolveImage = function (?string $path): string {
        if (blank($path)) {
            return asset('images/home/about-1.jpg');
        }

        return str_starts_with($path, 'images/')
            ? asset($path)
            : asset('storage/'.$path);
    };
@endphp

<section class="relative overflow-hidden bg-cream py-14 sm:py-16">
    <div class="site-container">
        <h2 class="section-title">Preview Galeri</h2>
        <div class="mt-3 h-px w-16 bg-gold"></div>

        <div class="relative mt-8">
            <button type="button" id="preview-prev" class="absolute top-1/2 left-0 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-navy/15 bg-white text-navy shadow-sm transition hover:border-gold hover:text-gold sm:-left-2" aria-label="Sebelumnya">
                ←
            </button>
            <button type="button" id="preview-next" class="absolute top-1/2 right-0 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-navy/15 bg-white text-navy shadow-sm transition hover:border-gold hover:text-gold sm:-right-2" aria-label="Berikutnya">
                →
            </button>

            <div id="preview-track" class="alumni-track px-8 sm:px-10">
                @forelse ($previewPhotos as $photo)
                    <figure class="alumni-card w-56 shrink-0 overflow-hidden rounded-sm border border-navy/8 bg-white shadow-sm sm:w-64">
                        <img
                            src="{{ $resolveImage($photo->image) }}"
                            alt="{{ $photo->caption ?: $photo->album?->title }}"
                            class="aspect-[16/10] w-full object-cover"
                        >
                    </figure>
                @empty
                    @foreach (['about-1.jpg', 'about-2.jpg', 'about-3.jpg', 'about-4.jpg', 'news-1.jpg', 'news-2.jpg'] as $image)
                        <figure class="alumni-card w-56 shrink-0 overflow-hidden rounded-sm border border-navy/8 bg-white shadow-sm sm:w-64">
                            <img src="{{ asset('images/home/'.$image) }}" alt="Preview galeri" class="aspect-[16/10] w-full object-cover">
                        </figure>
                    @endforeach
                @endforelse
            </div>
        </div>
    </div>
</section>
