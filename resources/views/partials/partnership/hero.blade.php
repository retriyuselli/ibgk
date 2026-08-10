<section class="relative isolate overflow-hidden bg-navy text-white">
    @include('partials.site.section-shapes', ['variant' => 'dark'])
    <div class="absolute inset-0 opacity-20" aria-hidden="true" style="background-image: radial-gradient(circle at 20% 20%, color-mix(in oklab, var(--color-gold) 35%, transparent) 0, transparent 45%), radial-gradient(circle at 80% 0%, color-mix(in oklab, var(--color-gold) 20%, transparent) 0, transparent 40%), repeating-linear-gradient(45deg, color-mix(in oklab, var(--color-gold) 8%, transparent) 0 2px, transparent 2px 14px);"></div>
    <div class="absolute inset-0 bg-gradient-to-r from-navy-deep/95 via-navy/90 to-navy-deep/85"></div>

    <div class="site-container relative grid items-center gap-10 py-16 lg:grid-cols-2 lg:gap-14 lg:py-20">
        <div>
            <nav class="hero-animate text-xs text-white/65" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="hover:text-gold">Beranda</a></li>
                    <li aria-hidden="true">›</li>
                    <li class="text-white/90">Kemitraan</li>
                </ol>
            </nav>

            <h1 class="hero-animate-delay mt-8 font-display text-4xl font-semibold tracking-tight text-gold sm:text-5xl">
                Kemitraan
            </h1>
            <p class="hero-animate-delay mt-2 font-display text-xl text-gold/90 sm:text-2xl">
                IBGK Sumatera Selatan
            </p>

            <div class="ornament-divider hero-animate-delay mt-5 justify-start">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>

            <p class="hero-animate-delay-2 mt-6 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base">
                Kolaborasi bersama mitra strategis memperkuat peran generasi muda kampus
                Sumatera Selatan dalam pendidikan, sosial, budaya, dan kepemimpinan.
            </p>
        </div>

        <div class="hero-animate-delay-2 relative">
            <div class="relative overflow-hidden rounded-sm border border-gold/25 shadow-2xl">
                <img
                    src="{{ asset('images/home/about-2.jpg') }}"
                    alt="Kolaborasi kemitraan IBGK Sumsel"
                    class="aspect-[4/3] w-full object-cover"
                >
                <div class="absolute inset-0 bg-gradient-to-t from-navy-deep/70 via-navy/20 to-transparent"></div>
                <span class="absolute top-4 left-1/2 flex h-14 w-14 -translate-x-1/2 items-center justify-center rounded-full border border-gold/50 bg-navy/80 text-gold">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                        <path d="M12 3l2.2 4.4L19 8.2l-3.5 3.4.8 4.7L12 14.2 7.7 16.3l.8-4.7L5 8.2l4.8-.8L12 3z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                    </svg>
                </span>
            </div>
        </div>
    </div>
</section>
