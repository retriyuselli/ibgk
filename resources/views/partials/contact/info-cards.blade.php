@php
    $cards = [
        ['Alamat Kantor', $contactInfo['address'], 'map'],
        ['Telepon', $contactInfo['phone'], 'phone'],
        ['Email', $contactInfo['email'].' / '.$contactInfo['partnership_email'], 'mail'],
        ['Jam Operasional', $contactInfo['hours'], 'clock'],
        ['Website', $contactInfo['website'], 'globe'],
    ];
@endphp

<section class="relative overflow-hidden bg-cream py-14 sm:py-16">
    <div class="site-container">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="section-title">Hubungi Kami</h2>
            <div class="ornament-divider mt-4">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
        </div>

        <div class="mt-10 grid gap-4 sm:grid-cols-2 xl:grid-cols-5">
            @foreach ($cards as [$title, $value, $icon])
                <article class="rounded-sm border border-navy/8 bg-white px-4 py-6 text-center shadow-sm">
                    <span class="mx-auto flex h-11 w-11 items-center justify-center rounded-full border border-gold/35 text-gold">
                        @if ($icon === 'map')
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.2 7-11a7 7 0 10-14 0c0 5.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                        @elseif ($icon === 'phone')
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h2.3a1 1 0 01.95.68l1.2 3.6a1 1 0 01-.45 1.16l-1.6 1.1a12 12 0 005.6 5.6l1.1-1.6a1 1 0 011.16-.45l3.6 1.2a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.2 21 3 14.8 3 7V5z"/></svg>
                        @elseif ($icon === 'mail')
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 7l8 6 8-6"/></svg>
                        @elseif ($icon === 'clock')
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="8"/><path stroke-linecap="round" d="M12 8v4l3 2"/></svg>
                        @else
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="8"/><path stroke-linecap="round" d="M2 12h20M12 2a15 15 0 010 20M12 2a15 15 0 000 20"/></svg>
                        @endif
                    </span>
                    <h3 class="mt-4 text-sm font-semibold text-navy">{{ $title }}</h3>
                    <p class="mt-2 text-xs leading-relaxed text-muted">{{ $value }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
