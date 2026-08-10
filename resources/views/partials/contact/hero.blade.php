@php
    $hero = $cmsPages->hero('contact', [
        'title' => 'Kontak',
        'subtitle' => 'IBGK Sumatera Selatan',
        'excerpt' => 'Kami terbuka untuk pertanyaan, informasi kegiatan, dan kolaborasi. Hubungi tim IBGK Sumsel melalui kanal resmi berikut.',
        'quote' => 'Bersama, Berbudaya, Berprestasi, Menginspirasi.',
        'image' => 'images/home/about-4.jpg',
        'imageAlt' => 'Kontak IBGK Sumatera Selatan',
    ]);
@endphp
<section class="relative isolate overflow-hidden bg-navy text-white">
    @include('partials.site.section-shapes', ['variant' => 'dark'])
    <img
        src="{{ $hero['image'] }}"
        alt="{{ $hero['imageAlt'] }}"
        class="absolute inset-0 h-full w-full object-cover opacity-35"
    >
    <div class="absolute inset-0 bg-gradient-to-r from-navy-deep/95 via-navy/88 to-navy-deep/80"></div>
    <div class="absolute inset-y-0 right-0 w-1/2 opacity-15" aria-hidden="true" style="background-image: repeating-linear-gradient(45deg, color-mix(in oklab, var(--color-gold) 12%, transparent) 0 2px, transparent 2px 12px), repeating-linear-gradient(-45deg, color-mix(in oklab, var(--color-gold) 8%, transparent) 0 2px, transparent 2px 12px);"></div>

    <div class="site-container relative py-16 text-center sm:py-20 lg:py-24">
        <nav class="hero-animate text-xs text-white/65" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center justify-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-gold">Beranda</a></li>
                <li aria-hidden="true">›</li>
                <li class="text-white/90">Kontak</li>
            </ol>
        </nav>

        <h1 class="hero-animate-delay mt-8 font-display text-4xl font-semibold tracking-tight text-white sm:text-5xl">
            {{ $hero['title'] }}
        </h1>
        @if ($hero['subtitle'])
            <p class="hero-animate-delay mt-2 font-display text-xl text-gold sm:text-2xl">
                {{ $hero['subtitle'] }}
            </p>
        @endif

        <div class="ornament-divider hero-animate-delay mt-5">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
            </svg>
        </div>

        <p class="hero-animate-delay-2 mx-auto mt-6 max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base">
            {{ $hero['excerpt'] }}
        </p>

        @if ($hero['quote'])
            <p class="hero-animate-delay-2 mt-5 font-display text-lg italic text-gold sm:text-xl">
                "{{ $hero['quote'] }}"
            </p>

            <div class="ornament-divider hero-animate-delay-2 mt-5">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
        @endif
    </div>
</section>
