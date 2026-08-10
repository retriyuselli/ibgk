@php
    $profile = $profile ?? null;
@endphp

<footer id="kontak" class="bg-navy-deep text-white">
    <div class="site-container grid gap-10 py-14 lg:grid-cols-[1.2fr_2fr] lg:gap-16">
        <div>
            <a href="{{ route('home') }}" class="group inline-flex items-center gap-3" aria-label="{{ $profile->short_name ?? 'IBGK Sumatera Selatan' }}">
                @if (filled($profile?->logo))
                    <img
                        src="{{ asset('storage/'.$profile->logo) }}"
                        alt="{{ $profile->short_name ?? 'IBGK Sumatera Selatan' }}"
                        class="h-11 w-auto max-w-[12rem] object-contain transition group-hover:opacity-90"
                    >
                @else
                    <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full border border-gold/40 text-gold">
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
                @foreach ([
                    'instagram' => $profile?->instagram,
                    'youtube' => $profile?->youtube,
                    'tiktok' => $profile?->tiktok,
                    'facebook' => $profile?->facebook,
                ] as $network => $url)
                    @if (filled($url))
                        <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                           class="flex h-9 w-9 items-center justify-center rounded-full border border-white/15 text-white/80 transition hover:border-gold hover:text-gold"
                           aria-label="{{ ucfirst($network) }}">
                            <span class="text-xs font-semibold uppercase">{{ substr($network, 0, 2) }}</span>
                        </a>
                    @endif
                @endforeach

                @if (! filled($profile?->instagram) && ! filled($profile?->youtube) && ! filled($profile?->tiktok) && ! filled($profile?->facebook))
                    <span class="text-xs text-white/40">Media sosial segera tersedia</span>
                @endif
            </div>
        </div>

        <div class="grid gap-8 sm:grid-cols-2 lg:grid-cols-5">
            <div>
                <h3 class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">Tentang IBGK</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-white/70">
                    <li><a href="{{ route('about') }}" class="hover:text-gold">Profil</a></li>
                    <li><a href="{{ route('about') }}#visi-misi" class="hover:text-gold">Visi & Misi</a></li>
                    <li><a href="{{ route('about') }}" class="hover:text-gold">Sejarah</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">Pemilihan BGK</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-white/70">
                    <li><a href="{{ route('election') }}" class="hover:text-gold">Informasi</a></li>
                    <li><a href="{{ route('election') }}#peserta" class="hover:text-gold">Peserta</a></li>
                    <li><a href="{{ route('election') }}#tahapan" class="hover:text-gold">Jadwal</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">Alumni</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-white/70">
                    <li><a href="{{ route('alumni') }}" class="hover:text-gold">Angkatan</a></li>
                    <li><a href="{{ route('alumni') }}" class="hover:text-gold">Direktori</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">Kegiatan</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-white/70">
                    <li><a href="{{ route('activities') }}" class="hover:text-gold">Program</a></li>
                    <li><a href="{{ route('gallery') }}" class="hover:text-gold">Dokumentasi</a></li>
                </ul>
            </div>
            <div>
                <h3 class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">Informasi</h3>
                <ul class="mt-4 space-y-2.5 text-sm text-white/70">
                    <li><a href="{{ route('news') }}" class="hover:text-gold">Berita</a></li>
                    <li><a href="{{ route('partnership') }}" class="hover:text-gold">Kemitraan</a></li>
                    <li><a href="{{ route('contact') }}" class="hover:text-gold">Kontak</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="border-t border-white/10">
        <div class="site-container py-5 text-center text-xs text-white/45 sm:text-left">
            &copy; {{ now()->year }} Ikatan Bujang Gadis Kampus Sumatera Selatan | IBGK Sumsel. All Rights Reserved.
        </div>
    </div>
</footer>
