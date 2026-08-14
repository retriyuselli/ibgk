@php
    $profile = $profile ?? null;

    $footerColumns = [
        [
            'title' => 'Tentang IBGK',
            'links' => [
                ['Profil', route('about')],
                ['Visi & Misi', route('about').'#visi-misi'],
                ['Sejarah', route('about')],
            ],
        ],
        [
            'title' => 'Pemilihan BGK',
            'links' => [
                ['Informasi', route('election')],
                ['Peserta', route('election').'#peserta'],
                ['Jadwal', route('election').'#tahapan'],
            ],
        ],
    ];

    if (\App\Support\Roles::canAccessAlumniDirectory()) {
        $footerColumns[] = [
            'title' => 'Alumni',
            'links' => [
                ['Angkatan', route('alumni')],
                ['Direktori', route('alumni')],
            ],
        ];
    }

    $footerColumns = array_merge($footerColumns, [
        [
            'title' => 'Kegiatan',
            'links' => [
                ['Program', route('activities')],
                ['Dokumentasi', route('gallery')],
            ],
        ],
        [
            'title' => 'Informasi',
            'links' => [
                ['Berita', route('news')],
                ['Kemitraan', route('partnership')],
                ['Kontak', route('contact')],
            ],
        ],
    ]);
@endphp

<footer id="kontak" class="site-footer footer-section relative isolate overflow-hidden bg-navy-deep text-white">
    @include('partials.partnership.showcase.shapes', ['variant' => 'dark', 'density' => 'rich', 'section' => 'site-footer'])

    <div
        class="pointer-events-none absolute inset-0 z-0 opacity-[0.06]"
        style="background-image: radial-gradient(circle at 15% 25%, #c9a227 0.8px, transparent 1px), radial-gradient(circle at 85% 70%, #c9a227 0.8px, transparent 1px); background-size: 30px 30px;"
        aria-hidden="true"
    ></div>

    <div class="site-container relative z-[2] grid gap-10 py-14 lg:grid-cols-[1.2fr_2fr] lg:gap-16">
        <div class="footer-animate" style="--footer-delay: 0s">
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-3 transition duration-300 hover:opacity-90" aria-label="{{ $profile->short_name ?? 'IBGK Sumatera Selatan' }}">
                @if (filled($profile?->logo))
                    <img
                        src="{{ asset('storage/'.$profile->logo) }}"
                        alt="{{ $profile->short_name ?? 'IBGK Sumatera Selatan' }}"
                        class="h-11 w-auto max-w-[12rem] object-contain transition group-hover:opacity-90"
                    >
                @else
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-gold/40 text-gold transition duration-300 group-hover:border-gold group-hover:shadow-[0_0_0_4px_color-mix(in_oklab,var(--color-gold)_12%,transparent)]">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                            <path d="M12 3l2.2 4.4L19 8.2l-3.5 3.4.8 4.7L12 14.2 7.7 16.3l.8-4.7L5 8.2l4.8-.8L12 3z" stroke="currentColor" stroke-width="1.4" stroke-linejoin="round"/>
                        </svg>
                    </span>
                    <div>
                        <p class="font-display text-lg font-semibold">IBGK Sumsel</p>
                        <p class="text-xs tracking-[0.12em] text-white/60 uppercase">Sumatera Selatan</p>
                    </div>
                @endif
            </a>

            <p class="mt-5 max-w-sm text-sm leading-relaxed text-white/70">
                Muda, Berbudaya, Berprestasi, dan Menginspirasi.
            </p>

            <div class="mt-6 flex items-center gap-3">
                <a href="https://www.instagram.com/bgksumsel?igsh=MWJtZjlmNHMwdXlqbA=="
                   target="_blank"
                   rel="noopener noreferrer"
                   class="flex h-9 w-9 items-center justify-center rounded-full border border-white/15 text-white/80 transition duration-300 hover:-translate-y-0.5 hover:border-gold hover:text-gold hover:shadow-[0_0_0_4px_color-mix(in_oklab,var(--color-gold)_10%,transparent)]"
                   aria-label="Instagram IBGK Sumsel">
                    <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
            </div>
        </div>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-5">
            @foreach ($footerColumns as $index => $column)
                <div class="footer-animate" style="--footer-delay: {{ 0.08 + ($index * 0.06) }}s">
                    <h3 class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">{{ $column['title'] }}</h3>
                    <ul class="mt-4 space-y-2.5 text-sm text-white/70">
                        @foreach ($column['links'] as [$label, $href])
                            <li>
                                <a href="{{ $href }}" class="transition duration-300 hover:translate-x-0.5 hover:text-gold">{{ $label }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>
    </div>

    <div class="relative z-[2] border-t border-white/10">
        <div class="footer-animate site-container py-5 text-center text-xs text-white/45 sm:text-left" style="--footer-delay: 0.42s">
            &copy; {{ now()->year }} Ikatan Bujang Gadis Kampus Sumatera Selatan | IBGK Sumsel. All Rights Reserved.
        </div>
    </div>
</footer>
