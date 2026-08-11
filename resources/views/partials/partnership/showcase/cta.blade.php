<section class="relative overflow-hidden bg-navy py-14 text-white sm:py-16">
    <div class="site-container">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="font-display text-2xl font-semibold text-gold sm:text-3xl">
                Tertarik Berkolaborasi?
            </h2>
            <p class="mt-4 text-sm leading-relaxed text-white/80 sm:text-base">
                Kunjungi website resmi mitra atau kembali ke halaman kemitraan IBGK Sumsel untuk informasi lebih lanjut.
            </p>
            <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                @if ($partner->externalWebsiteUrl())
                    <a href="{{ $partner->externalWebsiteUrl() }}" target="_blank" rel="noopener noreferrer" class="btn-gold">
                        {{ $partner->external_cta_label ?: 'Kunjungi Website Mitra' }}
                        <span aria-hidden="true">↗</span>
                    </a>
                @endif
                <a href="{{ route('partnership') }}#ajukan" class="btn-outline-light">
                    Ajukan Kemitraan
                </a>
            </div>
        </div>
    </div>
</section>
