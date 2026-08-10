<section class="relative isolate overflow-hidden bg-navy py-16 text-white sm:py-20">
    <img
        src="{{ asset('images/home/sejarah-grand-final.jpg') }}"
        alt="Bergabung dengan IBGK Sumsel"
        class="absolute inset-0 h-full w-full object-cover opacity-35"
    >
    <div class="absolute inset-0 bg-gradient-to-r from-navy-deep/95 via-navy/85 to-navy-deep/90"></div>

    <div class="site-container relative flex flex-col items-center gap-6 text-center lg:flex-row lg:items-center lg:justify-between lg:text-left">
        <div class="max-w-2xl">
            <h2 class="font-display text-2xl font-semibold text-gold sm:text-3xl lg:text-4xl">
                Jadilah Bagian dari Perubahan!
            </h2>
            <p class="mt-3 text-sm leading-relaxed text-white/80 sm:text-base">
                Bergabunglah dengan generasi muda kampus Sumatera Selatan yang berbudaya,
                berprestasi, dan memberi dampak nyata bagi masyarakat.
            </p>
        </div>

        <a href="{{ route('election.register') }}" class="btn-gold shrink-0">
            Daftar BGK {{ $activeElection?->year ?? now()->year }}
            <span aria-hidden="true">→</span>
        </a>
    </div>
</section>
