@php
    $fallbackPartners = [
        'Dinas Pendidikan',
        'Universitas Sriwijaya',
        'POLSRI',
        'Bank Sumsel Babel',
        'Telkomsel',
        'BUMN Partner',
    ];
@endphp

<section id="kemitraan" class="relative bg-cream py-16 sm:py-20 lg:py-24 overflow-hidden">
    <div class="site-container grid items-center gap-12 lg:grid-cols-[0.95fr_1.05fr] lg:gap-16">
        <div>
            <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Kemitraan</p>
            <h2 class="section-title mt-3">
                Kolaborasi Bersama Kami
            </h2>
            <p class="mt-5 max-w-md text-sm leading-relaxed text-muted sm:text-base">
                IBGK Sumsel terbuka untuk kerja sama dengan pemerintah, perguruan tinggi, dunia usaha, media, dan komunitas dalam program pembinaan, budaya, serta kontribusi sosial.
            </p>
            <a href="{{ route('partnership') }}#ajukan" class="btn-gold mt-8">
                Ajukan Kerja Sama
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <div class="grid grid-cols-2 gap-3 sm:grid-cols-3 sm:gap-4">
            @if ($partners->isNotEmpty())
                @foreach ($partners->take(6) as $partner)
                    <div class="flex min-h-24 items-center justify-center border border-navy/8 bg-white px-4 py-6 text-center shadow-sm">
                        @if ($partner->logo)
                            <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}" class="max-h-12 max-w-full object-contain">
                        @else
                            <span class="text-xs font-semibold tracking-wide text-navy/70 uppercase">{{ $partner->name }}</span>
                        @endif
                    </div>
                @endforeach
            @else
                @foreach ($fallbackPartners as $name)
                    <div class="flex min-h-24 items-center justify-center border border-navy/8 bg-white px-4 py-6 text-center shadow-sm">
                        <span class="text-xs font-semibold tracking-wide text-navy/70 uppercase">{{ $name }}</span>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</section>
