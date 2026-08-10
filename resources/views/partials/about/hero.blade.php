@php
    $hero = $cmsPages->hero('about', [
        'title' => 'Tentang IBGK Sumatera Selatan',
        'excerpt' => $profile->short_description ?? 'Ikatan Bujang Gadis Kampus Sumatera Selatan merupakan wadah pemersatu para alumni dan finalis Pemilihan Bujang Gadis Kampus Sumatera Selatan.',
        'image' => 'images/home/hero-ampera.jpg',
        'imageAlt' => 'Palembang — Tentang IBGK Sumatera Selatan',
    ]);
@endphp
<section class="relative isolate overflow-hidden bg-navy text-white">
    @include('partials.site.section-shapes', ['variant' => 'dark'])
    {!! site_image_from_src($hero['image'], $hero['imageAlt'], ['class' => 'absolute inset-0 h-full w-full object-cover', 'lazy' => false]) !!}
    <div class="absolute inset-0 bg-navy-deep/80"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-navy-deep via-navy/40 to-navy/50"></div>

    <div class="site-container relative py-16 sm:py-20 lg:py-24">
        <nav class="hero-animate text-xs text-white/70" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-gold">Beranda</a></li>
                <li aria-hidden="true">›</li>
                <li class="text-gold">Tentang IBGK</li>
            </ol>
        </nav>

        <div class="mx-auto mt-10 max-w-3xl text-center sm:mt-14">
            <h1 class="hero-animate-delay font-display text-3xl font-semibold tracking-tight text-balance text-white sm:text-4xl lg:text-5xl">
                {{ $hero['title'] }}
            </h1>

            <div class="ornament-divider hero-animate-delay mt-5">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>

            <p class="hero-animate-delay-2 mx-auto mt-6 max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base">
                {{ $hero['excerpt'] }}
                Selama {{ $yearsActive }} tahun, IBGK Sumsel terus berkomitmen membina generasi muda yang berbudaya, berprestasi, dan menginspirasi.
            </p>
        </div>
    </div>
</section>
