@php
    $hero = $cmsPages->hero('kepengurusan', [
        'title' => 'Kepengurusan IBGK Sumsel',
        'subtitle' => 'Struktur Organisasi',
        'excerpt' => 'Muda, Berbudaya, Berprestasi, dan Menginspirasi.',
        'image' => 'images/home/hero-ampera.jpg',
        'imageAlt' => 'Kepengurusan IBGK Sumatera Selatan',
    ]);
@endphp
<section class="relative isolate overflow-hidden bg-navy text-white">
    @include('partials.site.section-shapes', ['variant' => 'dark'])
    {!! site_image_from_src($hero['image'], $hero['imageAlt'], ['class' => 'absolute inset-0 h-full w-full object-cover opacity-30', 'lazy' => false]) !!}
    <div class="absolute inset-0 bg-gradient-to-r from-navy-deep via-navy-deep/92 to-navy/75"></div>

    <div class="site-container relative grid items-center gap-10 py-16 lg:grid-cols-[1.15fr_0.85fr] lg:gap-14 lg:py-20">
        <div class="max-w-2xl">
            <nav class="hero-animate text-xs text-white/65" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="hover:text-gold">Beranda</a></li>
                    <li aria-hidden="true">›</li>
                    <li><a href="{{ route('about') }}" class="hover:text-gold">Tentang IBGK</a></li>
                    <li aria-hidden="true">›</li>
                    <li class="text-gold">Kepengurusan</li>
                </ol>
            </nav>

            <p class="hero-animate-delay mt-8 text-xs font-semibold tracking-[0.2em] text-gold uppercase">
                {{ $hero['subtitle'] ?: 'Struktur Organisasi' }}
            </p>
            <h1 class="hero-animate-delay mt-3 font-display text-3xl font-semibold tracking-tight text-balance text-white sm:text-4xl lg:text-5xl">
                {{ $hero['title'] }}
            </h1>
        </div>

        <aside class="hero-animate-delay-2 mx-auto w-full max-w-sm border border-gold/40 bg-navy-deep/75 p-6 text-center backdrop-blur-sm lg:mx-0 lg:justify-self-end">
            <p class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">Periode</p>
            <p class="mt-3 font-display text-3xl font-semibold text-gold sm:text-4xl">
                {{ $period?->yearRange() ?? '—' }}
            </p>
            <p class="mt-4 text-sm leading-relaxed text-white/70">
                {{ $hero['excerpt'] ?: 'Muda, Berbudaya, Berprestasi, dan Menginspirasi.' }}
            </p>
        </aside>
    </div>
</section>
