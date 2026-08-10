<section class="relative isolate overflow-hidden bg-navy py-14 text-white sm:py-16">
    <img
        src="{{ asset('images/home/about-3.jpg') }}"
        alt=""
        aria-hidden="true"
        class="absolute inset-0 h-full w-full object-cover opacity-15"
    >
    <div class="absolute inset-0 bg-navy/90"></div>

    <div class="site-container relative flex flex-col items-center gap-6 text-center lg:flex-row lg:items-center lg:justify-between lg:text-left">
        <div class="max-w-2xl">
            <h2 class="font-display text-2xl font-semibold text-gold sm:text-3xl">
                Abadikan Momen, Jaga Kenangan
            </h2>
            <p class="mt-3 text-sm leading-relaxed text-white/80 sm:text-base">
                Punya dokumentasi kegiatan IBGK Sumsel? Kirimkan foto atau album Anda
                agar momen berharga generasi muda kampus tetap terjaga.
            </p>
        </div>

        <a href="{{ route('contact') }}" class="btn-outline-gold shrink-0">
            Kirim Dokumentasi
            <span aria-hidden="true">→</span>
        </a>
    </div>
</section>
