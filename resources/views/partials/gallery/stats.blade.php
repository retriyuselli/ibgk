<section class="relative overflow-hidden bg-navy py-14 text-white sm:py-16">
    <div class="site-container grid grid-cols-2 gap-6 lg:grid-cols-4 lg:divide-x lg:divide-gold/25">
        @php
            $items = [
                [$stats['albums'].'+', 'Album Foto', 'album'],
                [number_format($stats['photos']).'+', 'Foto Dokumentasi', 'photos'],
                [$stats['years'].'+', 'Tahun Perjalanan', 'years'],
                [$stats['since'].' – Sekarang', 'Periode Kegiatan', 'period'],
            ];
        @endphp

        @foreach ($items as [$value, $label, $icon])
            <div class="text-center lg:px-4">
                <span class="mx-auto flex h-10 w-10 items-center justify-center text-gold">
                    @if ($icon === 'album')
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16v14H4zM8 5V3h8v2"/></svg>
                    @elseif ($icon === 'photos')
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4-4 4 4 6-8 2 2v6H4z"/><circle cx="8.5" cy="8.5" r="1.5"/></svg>
                    @elseif ($icon === 'years')
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M6 5h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
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
