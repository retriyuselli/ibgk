@php
    $milestones = [
        [
            'year' => '1999',
            'title' => 'IBGK Sumsel Didirikan',
            'text' => 'Organisasi lahir sebagai wadah kebanggaan generasi muda kampus Sumatera Selatan.',
            'icon' => 'flag',
        ],
        [
            'year' => '2002',
            'title' => 'Pemilihan Pertama',
            'text' => 'Pemilihan Bujang Gadis Kampus Sumsel digelar untuk pertama kali.',
            'icon' => 'academic',
        ],
        [
            'year' => '2003–2004',
            'title' => 'Kolaborasi Diperkuat',
            'text' => 'Memperkuat jejaring dan kolaborasi lintas instansi serta mitra strategis.',
            'icon' => 'handshake',
        ],
        [
            'year' => '2005',
            'title' => 'Pembinaan Terstruktur',
            'text' => 'Pembinaan dan pengawasan program organisasi semakin terstruktur.',
            'icon' => 'building',
        ],
        [
            'year' => '2006–2011',
            'title' => 'Penguatan Organisasi',
            'text' => 'Penguatan budaya, kontribusi sosial, dan jejaring alumni lintas angkatan.',
            'icon' => 'users',
        ],
        [
            'year' => '2011',
            'title' => '282 Anggota',
            'text' => 'Jejaring alumni dan finalis terus tumbuh hingga ratusan anggota.',
            'icon' => 'star',
        ],
    ];
@endphp

<section class="journey-section relative overflow-hidden bg-cream py-16 sm:py-20 lg:py-24">
    @include('partials.site.section-shapes', ['variant' => 'light'])

    <div class="site-container relative">
        <div class="journey-header journey-animate mx-auto max-w-3xl text-center">
            <h2 class="section-title">Perjalanan IBGK Sumatera Selatan</h2>
            <div class="ornament-divider mt-4">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
        </div>

        <div class="mt-12 overflow-x-auto pb-2">
            <ol class="relative mx-auto flex min-w-[860px] justify-between gap-3 px-2 py-3 lg:min-w-0">
                <li class="journey-line pointer-events-none absolute top-[2.375rem] right-8 left-8 h-px bg-gold/35" aria-hidden="true"></li>

                @foreach ($milestones as $index => $item)
                    <li
                        class="journey-item journey-animate relative z-10 flex w-[8.5rem] flex-col items-center text-center sm:w-36"
                        style="--journey-delay: {{ $index * 0.12 }}s"
                    >
                        <span class="journey-icon-wrap relative z-10 flex h-[4.75rem] w-[4.75rem] shrink-0 items-center justify-center">
                            <span class="journey-icon-ring pointer-events-none absolute inset-0 rounded-full border border-gold/20" aria-hidden="true"></span>
                            <span class="journey-icon relative flex h-14 w-14 items-center justify-center rounded-full border border-gold/50 bg-white text-gold shadow-sm">
                                @switch($item['icon'])
                                    @case('flag')
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 21V4m0 0h10l-1.5 3L16 10H4"/></svg>
                                        @break
                                    @case('academic')
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z"/></svg>
                                        @break
                                    @case('handshake')
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3 3 7-7M4 14l3 3m13-5l-3-3"/></svg>
                                        @break
                                    @case('building')
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8l7-4 7 4v13M9 21v-6h6v6"/></svg>
                                        @break
                                    @case('users')
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/><path d="M21 20v-1a3 3 0 00-2-2.83M16 4.13a3 3 0 010 5.74"/></svg>
                                        @break
                                    @default
                                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.5l1.76 3.56 3.93.57-2.84 2.77.67 3.91-3.52-1.85-3.52 1.85.67-3.91-2.84-2.77 3.93-.57L11.48 3.5z"/></svg>
                                @endswitch
                            </span>
                        </span>
                        <p class="mt-4 font-display text-lg font-semibold text-navy">{{ $item['year'] }}</p>
                        <p class="mt-1 text-[11px] font-semibold tracking-wide text-gold uppercase">{{ $item['title'] }}</p>
                        <p class="mt-2 text-[11px] leading-relaxed text-muted">{{ $item['text'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>
