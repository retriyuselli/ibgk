<section class="relative overflow-hidden bg-cream py-14 sm:py-16">
    <div class="site-container flex flex-col items-center gap-6 text-center lg:flex-row lg:items-center lg:justify-between lg:text-left">
        <div class="flex flex-col items-center gap-4 lg:flex-row lg:gap-5">
            <span class="flex h-14 w-14 items-center justify-center rounded-full border border-gold/40 text-gold">
                <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                    <path d="M12 3l2.2 4.4L19 8.2l-3.5 3.4.8 4.7L12 14.2 7.7 16.3l.8-4.7L5 8.2l4.8-.8L12 3z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                </svg>
            </span>
            <div>
                <h2 class="font-display text-2xl font-semibold text-navy sm:text-3xl">
                    Yuk, Bergabung & Berkontribusi!
                </h2>
                <p class="mt-2 max-w-xl text-sm leading-relaxed text-muted">
                    Jadilah bagian dari gerakan generasi muda kampus Sumatera Selatan yang berbudaya, berprestasi, dan menginspirasi.
                </p>
            </div>
        </div>

        <a href="{{ route('election.register') }}" class="inline-flex items-center gap-2 rounded-md bg-navy px-6 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-navy-soft">
            Gabung Sekarang
            <span aria-hidden="true">→</span>
        </a>
    </div>
</section>
