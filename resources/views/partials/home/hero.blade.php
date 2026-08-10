<section class="relative isolate min-h-[88vh] overflow-hidden bg-navy text-white lg:min-h-[92vh]">
    @include('partials.site.section-shapes', ['variant' => 'dark'])
    <img
        src="{{ asset('images/home/hero-ampera.jpg') }}"
        alt="Suasana Palembang — IBGK Sumatera Selatan"
        class="absolute inset-0 h-full w-full object-cover"
    >

    <div class="absolute inset-0 bg-gradient-to-r from-navy-deep/95 via-navy/85 to-navy/55"></div>
    <div class="absolute inset-0 bg-gradient-to-t from-navy-deep/80 via-transparent to-navy/30"></div>

    <div class="site-container relative flex min-h-[88vh] items-center py-16 lg:min-h-[92vh] lg:py-20">
        <div class="grid w-full items-center gap-10 lg:grid-cols-[minmax(0,1.4fr)_minmax(240px,0.55fr)]">
            <div class="max-w-3xl">
                <p class="hero-animate text-xs font-semibold tracking-[0.22em] text-gold uppercase">
                    {{ $profile->short_name ?? 'IBGK Sumsel' }}
                </p>

                <h1 class="hero-animate-delay mt-4 font-display text-4xl leading-[1.12] font-semibold text-balance sm:text-5xl lg:text-[3.35rem]">
                    Ikatan Bujang Gadis Kampus<br class="hidden sm:block"> Sumatera Selatan
                </h1>

                <p class="hero-animate-delay mt-5 font-display text-lg text-gold-light italic sm:text-xl">
                    Muda, Berbudaya, Berprestasi, dan Menginspirasi.
                </p>

                <p class="hero-animate-delay-2 mt-5 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base">
                    {{ $profile->short_description ?? 'Wadah pemersatu para alumni dan finalis Pemilihan Bujang Gadis Kampus Sumatera Selatan.' }}
                </p>

                <div class="hero-animate-delay-2 mt-8 flex flex-wrap gap-3">
                    <a href="#tentang" class="btn-gold">
                        Kenali IBGK Sumsel
                        <span aria-hidden="true">→</span>
                    </a>
                    <a href="{{ route('election') }}" class="btn-outline-light">
                        Pemilihan BGK Sumsel
                        <span aria-hidden="true">→</span>
                    </a>
                </div>
            </div>

            <aside class="hero-animate-delay-2 mx-auto w-full max-w-xs border border-gold/40 bg-navy-deep/70 p-6 backdrop-blur-sm lg:mx-0 lg:justify-self-end">
                <p class="font-display text-3xl font-semibold text-gold sm:text-4xl">
                    {{ $yearsActive }} Tahun
                </p>
                <p class="mt-1 text-sm font-semibold tracking-[0.12em] text-white uppercase">
                    IBGK Sumsel
                </p>
                <p class="mt-4 text-sm leading-relaxed text-white/70">
                    Perjalanan panjang membangun generasi muda Sumatera Selatan yang berbudaya dan berprestasi sejak
                    {{ $profile?->founded_at?->format('Y') ?? '1999' }}.
                </p>
            </aside>
        </div>
    </div>
</section>
