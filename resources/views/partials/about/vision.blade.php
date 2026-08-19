@php
    $defaultVision = 'Menjadi organisasi pemuda kampus terdepan di Sumatera Selatan yang berbudaya, berprestasi, dan menginspirasi.';
    $defaultMissionItems = [
        'Menyelenggarakan Pemilihan Bujang Gadis Kampus sebagai ajang pembinaan generasi muda.',
        'Memperkuat jejaring alumni dan kolaborasi lintas angkatan.',
        'Melestarikan budaya serta nilai-nilai kearifan lokal Sumatera Selatan.',
        'Memberikan kontribusi sosial yang bermanfaat bagi masyarakat.',
    ];

    $hasVision = filled(trim(strip_tags($profile?->vision ?? '')));
    $hasMission = filled(trim(strip_tags($profile?->mission ?? '')));

    $missionItems = $defaultMissionItems;

    if ($hasMission) {
        $parsedMissionItems = [];

        if (preg_match_all('/<li[^>]*>(.*?)<\/li>/is', $profile->mission, $matches)) {
            $parsedMissionItems = collect($matches[1])
                ->map(fn (string $item) => trim(strip_tags($item)))
                ->filter()
                ->values()
                ->all();
        } elseif (preg_match_all('/<p[^>]*>(.*?)<\/p>/is', $profile->mission, $matches)) {
            $parsedMissionItems = collect($matches[1])
                ->map(fn (string $item) => trim(strip_tags($item)))
                ->filter()
                ->values()
                ->all();
        }

        if ($parsedMissionItems !== []) {
            $missionItems = $parsedMissionItems;
        }
    }
@endphp

<section id="visi-misi" class="relative bg-cream py-16 sm:py-20 lg:py-24 overflow-hidden">
    <div class="site-container">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="section-title">Visi & Misi IBGK Sumsel</h2>
            <div class="ornament-divider mt-4">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
        </div>

        <div class="mt-10 grid gap-6 lg:grid-cols-2">
            <div class="rounded-lg border border-navy/8 bg-white p-7 sm:p-8">
                <p class="text-xs font-semibold tracking-[0.18em] text-gold uppercase">Visi</p>
                @if ($hasVision)
                    <div class="mt-4 text-sm leading-relaxed text-muted sm:text-base [&_p+p]:mt-4">
                        {!! clean_html($profile->vision) !!}
                    </div>
                @else
                    <p class="mt-4 text-sm leading-relaxed text-muted sm:text-base">
                        {{ $defaultVision }}
                    </p>
                @endif
            </div>

            <div class="rounded-lg border border-navy/8 bg-white p-7 sm:p-8">
                <p class="text-xs font-semibold tracking-[0.18em] text-gold uppercase">Misi</p>
                <ul class="mt-4 space-y-3">
                    @foreach ($missionItems as $item)
                        @continue(blank($item))
                        <li class="flex gap-3 text-sm leading-relaxed text-muted sm:text-base">
                            <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-gold"></span>
                            <span>{{ $item }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>
