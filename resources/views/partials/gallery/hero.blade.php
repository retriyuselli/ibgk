<section class="relative isolate overflow-hidden bg-navy text-white">
    @include('partials.site.section-shapes', ['variant' => 'dark'])
    <img
        src="{{ asset('images/home/sejarah-grand-final.jpg') }}"
        alt="Galeri IBGK Sumatera Selatan"
        class="absolute inset-0 h-full w-full object-cover opacity-40"
    >
    <div class="absolute inset-0 bg-gradient-to-b from-navy-deep/85 via-navy/80 to-navy-deep/90"></div>

    <div class="site-container relative py-16 text-center sm:py-20 lg:py-24">
        <nav class="hero-animate text-xs text-white/65" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center justify-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-gold">Beranda</a></li>
                <li aria-hidden="true">›</li>
                <li class="text-white/90">Galeri</li>
            </ol>
        </nav>

        <h1 class="hero-animate-delay mt-8 font-display text-3xl font-semibold tracking-tight text-gold sm:text-4xl lg:text-5xl">
            Galeri IBGK Sumatera Selatan
        </h1>

        <div class="ornament-divider hero-animate-delay mt-5">
            <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
            </svg>
        </div>

        <p class="hero-animate-delay-2 mx-auto mt-6 max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base">
            Abadikan momen perjalanan IBGK Sumsel — dari pemilihan BGK, kegiatan sosial,
            budaya, hingga kolaborasi yang menginspirasi generasi muda kampus.
        </p>
    </div>
</section>
