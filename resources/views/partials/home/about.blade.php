<section id="tentang" class="relative bg-white py-16 sm:py-20 lg:py-24 overflow-hidden">
    <div class="site-container grid items-center gap-12 lg:grid-cols-2 lg:gap-16">
        <div>
            <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Tentang Kami</p>
            <h2 class="section-title mt-3">
                Tentang IBGK Sumatera Selatan
            </h2>

            <div class="mt-6 space-y-4 text-sm leading-relaxed text-muted sm:text-base">
                <p>
                    {{ $profile->short_description ?? 'Ikatan Bujang Gadis Kampus Sumatera Selatan merupakan wadah pemersatu para alumni dan finalis Pemilihan Bujang Gadis Kampus Sumatera Selatan.' }}
                </p>
                <p>
                    {{ filled(trim(strip_tags($profile?->description ?? '')))
                        ? \Illuminate\Support\Str::limit(strip_tags($profile->description), 420)
                        : 'Sejak didirikan, IBGK Sumsel berperan mendorong generasi muda kampus untuk berkarya, menjaga budaya, dan memberikan kontribusi nyata bagi masyarakat Sumatera Selatan.' }}
                </p>
                <p>
                    Melalui pemilihan, pembinaan, dan jejaring alumni, IBGK Sumsel terus menumbuhkan semangat
                    <span class="font-medium text-navy">muda, berbudaya, berprestasi, dan menginspirasi</span>.
                </p>
            </div>

            <a href="{{ route('about') }}" class="btn-gold mt-8">
                Selengkapnya
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <video
            class="mx-auto w-1/2 bg-transparent object-contain"
            autoplay
            muted
            loop
            playsinline
            preload="metadata"
            aria-label="Animasi logo Ikatan Bujang Gadis Kampus Sumatera Selatan"
        >
            <source src="{{ asset('video/'.rawurlencode('IMG_4580.MP4')) }}" type="video/mp4">
        </video>
    </div>
</section>
