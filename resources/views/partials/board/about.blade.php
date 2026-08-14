@php
    $aboutText = filled(trim(strip_tags((string) ($profile?->short_description ?? ''))))
        ? $profile->short_description
        : 'Pengurus IBGK Sumatera Selatan bekerja secara kolaboratif untuk merawat budaya, mendorong prestasi, dan memperluas dampak positif bagi generasi muda kampus.';

    $values = [
        [
            'title' => 'Kolaborasi',
            'text' => 'Membangun kerja sama lintas kampus, alumni, dan mitra untuk program yang berkelanjutan.',
            'icon' => 'people',
        ],
        [
            'title' => 'Prestasi',
            'text' => 'Mendorong pengurus dan alumni menorehkan karya yang mengangkat nama Sumatera Selatan.',
            'icon' => 'star',
        ],
        [
            'title' => 'Dampak',
            'text' => 'Menghadirkan kontribusi nyata bagi masyarakat melalui kegiatan sosial, budaya, dan kepemudaan.',
            'icon' => 'heart',
        ],
    ];
@endphp
<section class="relative bg-white py-14 sm:py-16 lg:py-20">
    <div class="site-container">
        <div class="rounded-xl border border-navy/8 bg-cream-muted/60 p-6 sm:p-8 lg:p-10">
            <div class="grid gap-10 lg:grid-cols-[1fr_1.15fr] lg:items-start lg:gap-14">
                <div>
                    <h2 class="section-title text-2xl sm:text-3xl">Tentang Kepengurusan</h2>
                    <div class="mt-3 h-px w-16 bg-gold"></div>
                    <p class="mt-5 text-sm leading-relaxed text-muted sm:text-base">
                        {{ $aboutText }}
                    </p>
                    <p class="mt-4 text-sm leading-relaxed text-muted sm:text-base">
                        Setiap periode, pengurus IBGK Sumsel merancang program yang menjaga semangat
                        <span class="font-medium text-navy">muda, berbudaya, berprestasi, dan menginspirasi</span>.
                    </p>
                </div>

                <div class="space-y-5">
                    @foreach ($values as $value)
                        <div class="flex gap-4">
                            <span class="mt-0.5 flex h-11 w-11 shrink-0 items-center justify-center rounded-lg bg-gold/15 text-gold">
                                @if ($value['icon'] === 'people')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/>
                                        <circle cx="9" cy="7" r="3"/>
                                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                                    </svg>
                                @elseif ($value['icon'] === 'star')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3.5l2.1 4.3 4.7.7-3.4 3.3.8 4.7L12 14.3 7.8 16.5l.8-4.7-3.4-3.3 4.7-.7L12 3.5z"/>
                                    </svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.4-7-10a4 4 0 017-2.6A4 4 0 0119 11c0 5.6-7 10-7 10z"/>
                                    </svg>
                                @endif
                            </span>
                            <div>
                                <h3 class="font-semibold text-navy">{{ $value['title'] }}</h3>
                                <p class="mt-1 text-sm leading-relaxed text-muted">{{ $value['text'] }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
