@php
    $networkLabels = [
        'instagram' => 'IG',
        'tiktok' => 'TT',
        'youtube' => 'YT',
        'facebook' => 'FB',
        'email' => '@',
    ];
@endphp

<section class="relative overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    <div class="site-container grid gap-8 lg:grid-cols-2 lg:gap-10">
        <div>
            <h2 class="section-title">Terhubung Bersama Kami</h2>
            <div class="mt-3 h-px w-16 bg-gold"></div>
            <p class="mt-4 max-w-lg text-sm leading-relaxed text-muted">
                Ikuti media sosial resmi IBGK Sumsel untuk update kegiatan, berita,
                dan momen inspiratif generasi muda kampus Sumatera Selatan.
            </p>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($socialLinks as $network => $social)
                    @php
                        $href = $network === 'email'
                            ? safe_url($social['url'])
                            : safe_url($social['url']);
                        $isExternal = filled($href) && $network !== 'email';
                    @endphp
                    @if (filled($href))
                    <a
                        href="{{ $href }}"
                        @if ($isExternal) target="_blank" rel="noopener noreferrer" @endif
                        @class([
                            'flex flex-col items-center rounded-sm border px-4 py-5 text-center transition',
                            filled($social['url']) ? 'border-navy/8 bg-white hover:border-gold/35 hover:shadow-sm' : 'border-navy/8 bg-white/70 opacity-70',
                        ])
                    >
                        <span class="flex h-11 w-11 items-center justify-center rounded-full bg-navy text-sm font-semibold text-gold">
                            {{ $networkLabels[$network] ?? strtoupper(substr($network, 0, 2)) }}
                        </span>
                        <span class="mt-3 text-[11px] font-semibold tracking-wide text-navy uppercase">{{ ucfirst($network) }}</span>
                        <span class="mt-1 text-xs text-muted">{{ $social['label'] }}</span>
                    </a>
                    @endif
                @endforeach
            </div>
        </div>

        <div class="rounded-sm border border-gold/35 bg-navy p-6 text-white shadow-lg sm:p-8">
            <span class="flex h-12 w-12 items-center justify-center rounded-full border border-gold/40 text-gold">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/><path d="M21 20v-1a3 3 0 00-2-2.83M16 4.13a3 3 0 010 5.74"/></svg>
            </span>
            <h2 class="mt-5 font-display text-2xl font-semibold text-gold">Narahubung Kemitraan</h2>
            <p class="mt-3 text-sm leading-relaxed text-white/80">
                Untuk sponsorship, kolaborasi program, dan kerja sama strategis,
                silakan hubungi tim kemitraan IBGK Sumsel.
            </p>
            <ul class="mt-6 space-y-3 text-sm">
                <li class="flex items-center gap-3">
                    <svg class="h-4 w-4 shrink-0 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h2.3a1 1 0 01.95.68l1.2 3.6a1 1 0 01-.45 1.16l-1.6 1.1a12 12 0 005.6 5.6l1.1-1.6a1 1 0 011.16-.45l3.6 1.2a1 1 0 01.68.95V19a2 2 0 01-2 2h-1C9.2 21 3 14.8 3 7V5z"/></svg>
                    <span>{{ $contactInfo['partnership_phone'] }}</span>
                </li>
                <li class="flex items-center gap-3">
                    <svg class="h-4 w-4 shrink-0 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4z"/><path stroke-linecap="round" stroke-linejoin="round" d="M4 7l8 6 8-6"/></svg>
                    <a href="mailto:{{ $contactInfo['partnership_email'] }}" class="hover:text-gold">{{ $contactInfo['partnership_email'] }}</a>
                </li>
            </ul>
            <a href="{{ route('partnership') }}#ajukan" class="btn-outline-gold mt-8 inline-flex">
                Ajukan Kerja Sama
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</section>
