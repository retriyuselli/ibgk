<section class="relative overflow-hidden bg-navy py-14 text-white sm:py-16">
    <div class="site-container grid grid-cols-2 gap-6 lg:grid-cols-5 lg:gap-4">
        @php
            $items = [
                [$stats['since'], 'Sejak Tahun Program Aktif', 'calendar'],
                [$stats['programs'].'+', 'Program & Kegiatan', 'flag'],
                [$stats['beneficiaries'], 'Masyarakat Penerima Manfaat', 'users'],
                [$stats['partners'], 'Mitra Kolaborasi', 'handshake'],
                [$stats['regions'], 'Kab/Kota Terjangkau', 'map'],
            ];
        @endphp

        @foreach ($items as [$value, $label, $icon])
            <div class="text-center">
                <span class="mx-auto flex h-10 w-10 items-center justify-center text-gold">
                    @if ($icon === 'calendar')
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M6 5h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                    @elseif ($icon === 'flag')
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 21V4m0 0h10l-1.5 3L16 10H4"/></svg>
                    @elseif ($icon === 'users')
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/><path d="M21 20v-1a3 3 0 00-2-2.83M16 4.13a3 3 0 010 5.74"/></svg>
                    @elseif ($icon === 'handshake')
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3 3 7-7M4 14l3 3m13-5l-3-3"/></svg>
                    @else
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.2 7-11a7 7 0 10-14 0c0 5.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                    @endif
                </span>
                <p class="mt-3 font-display text-2xl font-semibold text-gold sm:text-3xl">{{ $value }}</p>
                <p class="mt-1 text-[11px] leading-relaxed text-white/70 sm:text-xs">{{ $label }}</p>
            </div>
        @endforeach
    </div>
</section>
