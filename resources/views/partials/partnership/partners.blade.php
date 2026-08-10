@php
    $fallbackPartners = [
        'Dinas Pendidikan',
        'Universitas Sriwijaya',
        'POLSRI',
        'Bank Sumsel Babel',
        'Bank Indonesia',
        'Telkomsel',
        'Wardah',
        'Aston Palembang',
        'Palembang Indah Mall',
        'Sriwijaya Post',
        'Sonora FM',
        'Pemprov Sumsel',
    ];
@endphp

<section class="relative overflow-hidden bg-white py-14 sm:py-16 lg:py-20">
    <div class="site-container">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="section-title">Mitra IBGK Sumatera Selatan</h2>
            <div class="ornament-divider mt-4">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
        </div>

        <div id="partner-carousel" class="relative mt-10">
            @if ($partnerPages->isNotEmpty())
                @foreach ($partnerPages as $pageIndex => $pagePartners)
                    <div
                        @class(['partner-page grid gap-3 sm:grid-cols-3 lg:grid-cols-4 sm:gap-4', $pageIndex === 0 ? '' : 'hidden'])
                        data-partner-page="{{ $pageIndex }}"
                    >
                        @foreach ($pagePartners as $partner)
                            <div class="flex min-h-28 flex-col items-center justify-center rounded-sm border border-navy/8 bg-cream/40 px-4 py-6 text-center shadow-sm transition hover:border-gold/35 hover:shadow-md">
                                @if ($partner->logo)
                                    <img src="{{ asset('storage/'.$partner->logo) }}" alt="{{ $partner->name }}" class="max-h-12 max-w-full object-contain">
                                @else
                                    <span class="text-[11px] font-semibold leading-snug tracking-wide text-navy/75 uppercase">{{ $partner->name }}</span>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @endforeach
            @else
                <div class="grid gap-3 sm:grid-cols-3 lg:grid-cols-4 sm:gap-4">
                    @foreach ($fallbackPartners as $name)
                        <div class="flex min-h-28 items-center justify-center rounded-sm border border-navy/8 bg-cream/40 px-4 py-6 text-center shadow-sm">
                            <span class="text-[11px] font-semibold tracking-wide text-navy/75 uppercase">{{ $name }}</span>
                        </div>
                    @endforeach
                </div>
            @endif

            @if ($partnerPages->count() > 1)
                <div class="mt-8 flex items-center justify-center gap-4">
                    <button type="button" id="partner-prev" class="flex h-9 w-9 items-center justify-center rounded-full border border-navy/15 text-navy transition hover:border-gold hover:text-gold" aria-label="Mitra sebelumnya">
                        ←
                    </button>
                    <div id="partner-dots" class="flex items-center gap-2">
                        @foreach ($partnerPages as $pageIndex => $pagePartners)
                            <button
                                type="button"
                                class="partner-dot h-2.5 w-2.5 rounded-full transition {{ $pageIndex === 0 ? 'bg-gold' : 'bg-navy/20' }}"
                                data-partner-dot="{{ $pageIndex }}"
                                aria-label="Halaman mitra {{ $pageIndex + 1 }}"
                            ></button>
                        @endforeach
                    </div>
                    <button type="button" id="partner-next" class="flex h-9 w-9 items-center justify-center rounded-full border border-navy/15 text-navy transition hover:border-gold hover:text-gold" aria-label="Mitra berikutnya">
                        →
                    </button>
                </div>
            @endif
        </div>
    </div>
</section>
