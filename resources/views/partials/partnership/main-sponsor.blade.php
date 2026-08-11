@if ($mainSponsor)
    <section class="relative overflow-hidden border-b border-navy/8 bg-white py-14 sm:py-16">
        <div class="site-container">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Sponsor Utama</p>
                <h2 class="section-title mt-3">Official Banking Partner</h2>
                <p class="mt-4 text-sm leading-relaxed text-muted">
                    Mitra strategis yang mendukung pemilihan Bujang Gadis Kampus Sumatera Selatan {{ $mainSponsor->showcase_year ?? now()->year }}.
                </p>
            </div>

            <a
                href="{{ $mainSponsor->showcaseUrl() ?? $mainSponsor->externalWebsiteUrl() ?? '#' }}"
                @if (! $mainSponsor->showcaseUrl() && $mainSponsor->externalWebsiteUrl()) target="_blank" rel="noopener noreferrer" @endif
                class="group mx-auto mt-10 block max-w-5xl overflow-hidden rounded-sm border border-banking/15 bg-white shadow-lg transition duration-300 hover:-translate-y-1 hover:border-gold/40 hover:shadow-xl"
            >
                <div class="grid lg:grid-cols-[1fr_auto_1fr] lg:items-stretch">
                    <div class="flex items-center justify-center border-b border-banking/10 bg-[#f4faf9] px-8 py-8 lg:border-b-0 lg:border-r">
                        @if ($mainSponsor->usesOfficeIcon())
                            @include('partials.partnership.showcase.partner-brand', [
                                'partner' => $mainSponsor,
                                'boxClass' => 'h-16 w-16 rounded-lg',
                                'iconClass' => 'h-8 w-8',
                            ])
                        @elseif ($mainSponsor->logoUrl())
                            <img src="{{ $mainSponsor->logoUrl() }}" alt="Logo {{ $mainSponsor->name }}" class="max-h-16 w-full max-w-[14rem] object-contain transition group-hover:scale-[1.02]">
                        @else
                            <span class="font-display text-xl font-semibold text-banking">{{ $mainSponsor->name }}</span>
                        @endif
                    </div>

                    <div class="flex flex-col justify-center bg-banking px-8 py-8 text-center text-white lg:min-w-[18rem] lg:px-10">
                        @if ($mainSponsor->tierLabel())
                            <span class="text-[10px] font-semibold tracking-[0.16em] text-gold uppercase">{{ $mainSponsor->tierLabel() }}</span>
                        @endif
                        <p class="mt-3 font-display text-lg font-semibold text-gold sm:text-xl">
                            {{ $mainSponsor->showcaseShortName() }} × BGK Sumsel
                        </p>
                        @if ($mainSponsor->tagline)
                            <p class="mt-2 text-[11px] font-semibold tracking-[0.14em] text-white/85 uppercase">{{ $mainSponsor->tagline }}</p>
                        @endif
                    </div>

                    <div class="flex flex-col justify-center border-t border-banking/10 px-8 py-8 lg:border-t-0 lg:border-l lg:px-10">
                        <p class="text-sm leading-relaxed text-muted">
                            {{ str($mainSponsor->showcase_intro ?: $mainSponsor->description)->limit(140) }}
                        </p>
                        <span class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-banking transition group-hover:text-gold">
                            Lihat Program Kolaborasi
                            <span aria-hidden="true">→</span>
                        </span>
                    </div>
                </div>
            </a>
        </div>
    </section>
@endif
