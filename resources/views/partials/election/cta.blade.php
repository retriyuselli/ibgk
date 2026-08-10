@php
    $year = $election?->year ?? now()->year;
@endphp

<section id="daftar" class="election-cta-section relative overflow-hidden bg-navy py-12 text-white sm:py-14">
    @include('partials.site.section-shapes', ['variant' => 'dark'])

    <div class="site-container relative flex flex-col items-start justify-between gap-6 lg:flex-row lg:items-center">
        <div class="max-w-2xl">
            <h2 class="font-display text-2xl font-semibold text-balance sm:text-3xl">
                Siap Menjadi Bagian dari Generasi Muda Berdampak?
            </h2>
            <p class="mt-3 text-sm leading-relaxed text-white/75 sm:text-base">
                Daftarkan dirimu sekarang dan wujudkan potensi terbaikmu bersama IBGK Sumsel
                pada Pemilihan BGK {{ $year }}.
            </p>
        </div>

        <a href="{{ route('election.register') }}" class="btn-gold shrink-0">
            Daftar Sekarang
            <span aria-hidden="true">→</span>
        </a>
    </div>
</section>
