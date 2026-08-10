<section class="border-b border-navy/8 bg-cream py-12 sm:py-14">
    <div class="site-container grid gap-8 sm:grid-cols-2 lg:grid-cols-4">
        @php
            $items = [
                [$stats['partners'], 'Mitra & Instansi', 'Kolaborasi strategis lintas sektor untuk program berkelanjutan.', 'handshake'],
                [$stats['since'], 'Sejak Tahun 2002', 'Perjalanan kemitraan IBGK Sumsel bersama mitra terpercaya.', 'calendar'],
                [$stats['sectors'], 'Beragam Sektor', 'Pemerintah, kampus, BUMN, corporate, media, dan komunitas.', 'layers'],
                [$stats['goal'], 'Satu Tujuan', 'Mewujudkan generasi muda yang berbudaya, berprestasi, dan berdampak.', 'target'],
            ];
        @endphp

        @foreach ($items as [$value, $label, $description, $icon])
            <article class="text-center">
                <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-full border border-gold/35 text-gold">
                    @if ($icon === 'handshake')
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3 3 7-7M4 14l3 3m13-5l-3-3"/></svg>
                    @elseif ($icon === 'calendar')
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M6 5h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                    @elseif ($icon === 'layers')
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 2l8 4-8 4-8-4 8-4zm0 8l8 4-8 4-8-4 8-4z"/></svg>
                    @else
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/></svg>
                    @endif
                </span>
                <p class="mt-4 font-display text-2xl font-semibold text-navy">{{ $value }}</p>
                <p class="mt-1 text-sm font-semibold text-navy">{{ $label }}</p>
                <p class="mt-2 text-xs leading-relaxed text-muted">{{ $description }}</p>
            </article>
        @endforeach
    </div>
</section>
