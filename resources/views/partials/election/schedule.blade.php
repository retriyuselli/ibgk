@php
    $org = $org ?? org_profile($profile);
    $year = $election?->year ?? now()->year;

    $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    $formatDate = function ($date) use ($months): ?string {
        if (! $date) {
            return null;
        }

        return $date->format('j').' '.$months[(int) $date->format('n')].' '.$date->format('Y');
    };

    $formatRange = function ($start, $end) use ($formatDate, $org): string {
        if ($start && $end) {
            if ($start->isSameDay($end)) {
                return $formatDate($start);
            }

            return $formatDate($start).' – '.$formatDate($end);
        }

        return $org->electionCopy('schedule_tbd_label');
    };

    $cards = $election?->stages?->isNotEmpty()
        ? $election->stages->sortBy('sort_order')->values()
        : collect([
            (object) ['name' => 'Pendaftaran', 'start_date' => null, 'end_date' => null],
            (object) ['name' => 'Seleksi Administrasi', 'start_date' => null, 'end_date' => null],
            (object) ['name' => 'Seleksi Wawancara', 'start_date' => null, 'end_date' => null],
            (object) ['name' => 'Karantina & Pembinaan', 'start_date' => null, 'end_date' => null],
            (object) ['name' => 'Grand Final', 'start_date' => $election?->grand_final_date, 'end_date' => $election?->grand_final_date],
        ]);
@endphp

<section id="jadwal" class="relative bg-cream-muted py-16 sm:py-20 lg:py-24 overflow-hidden">
    <div class="site-container">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="section-title">{{ $org->electionCopy('schedule_title', ['year' => $year]) }}</h2>
            <div class="ornament-divider mt-4">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
        </div>

        <div class="relative mt-10">
            <button type="button" id="schedule-prev" class="absolute top-1/2 left-0 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-navy/15 bg-white text-navy shadow-sm transition hover:border-gold hover:text-gold sm:-left-1" aria-label="Sebelumnya">
                ←
            </button>
            <button type="button" id="schedule-next" class="absolute top-1/2 right-0 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-navy/15 bg-white text-navy shadow-sm transition hover:border-gold hover:text-gold sm:-right-1" aria-label="Berikutnya">
                →
            </button>

            <div id="schedule-track" class="alumni-track items-stretch px-10 sm:px-12">
                @foreach ($cards as $index => $card)
                    @php
                        $isFinal = str_contains(strtolower($card->name), 'grand');
                    @endphp
                    <article @class([
                        'schedule-card alumni-card flex w-56 shrink-0 flex-col items-center px-5 py-6 text-center shadow-sm sm:w-64',
                        'border border-gold/30 bg-white text-navy' => ! $isFinal,
                        'bg-navy text-white' => $isFinal,
                    ])>
                        <span @class([
                            'flex h-11 w-11 shrink-0 items-center justify-center rounded-full border',
                            'border-gold/40 text-gold' => ! $isFinal,
                            'border-gold text-gold' => $isFinal,
                        ])>
                            @if ($isFinal)
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l2 4 4 .6-3 2.9.8 4.5L12 13.2 8.2 15l.8-4.5-3-2.9 4-.6L12 3z"/></svg>
                            @else
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M6 5h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                            @endif
                        </span>

                        <h3 @class([
                            'mt-3 w-full text-[11px] font-semibold leading-snug tracking-[0.12em] uppercase',
                            'text-navy' => ! $isFinal,
                            'text-gold' => $isFinal,
                        ])>
                            {{ $card->name }}
                        </h3>

                        @if (filled($card->location ?? null))
                            <p @class([
                                'mt-2 text-[11px] leading-snug',
                                'text-muted' => ! $isFinal,
                                'text-white/70' => $isFinal,
                            ])>
                                {{ $card->location }}
                            </p>
                        @endif

                        <p @class([
                            'mt-2 text-sm font-medium',
                            'text-muted' => ! $isFinal,
                            'text-gold-light' => $isFinal,
                        ])>
                            {{ $formatRange($card->start_date ?? null, $card->end_date ?? null) }}
                        </p>
                    </article>
                @endforeach
            </div>
        </div>

        <p class="mt-6 text-center text-xs text-muted italic">
            {{ $org->electionCopy('schedule_footnote') }}
        </p>
    </div>
</section>
