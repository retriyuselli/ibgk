@php
    $org = $org ?? org_profile($profile);

    $fallbackStages = [
        ['Pendaftaran', 'Pendaftaran online bagi mahasiswa/i Sumatera Selatan.'],
        ['Seleksi Administrasi', 'Verifikasi berkas dan kelengkapan persyaratan.'],
        ['Seleksi Wawancara', 'Penilaian kepribadian, wawasan, dan komunikasi.'],
        ['Karantina & Pembinaan', 'Workshop, pelatihan, dan pembentukan karakter.'],
        ['Grand Final', 'Malam puncak pemilihan Bujang dan Gadis Kampus.'],
    ];

    $stages = $election?->stages?->isNotEmpty()
        ? $election->stages
        : collect($fallbackStages)->map(fn ($item, $i) => (object) [
            'name' => $item[0],
            'description' => $item[1],
            'sort_order' => $i + 1,
        ]);
@endphp

<section id="tahapan" class="stages-section relative overflow-hidden bg-navy py-16 text-white sm:py-20 lg:py-24">
    @include('partials.site.section-shapes', ['variant' => 'dark'])

    <div class="pointer-events-none absolute inset-0 z-0 opacity-[0.06]" style="background-image: radial-gradient(circle at 20% 20%, var(--color-gold) 1px, transparent 1px); background-size: 26px 26px;"></div>

    <div class="site-container relative">
        <div class="stages-header stages-animate mx-auto max-w-3xl text-center">
            <h2 class="font-display text-3xl font-semibold text-gold sm:text-4xl">{{ $org->electionCopy('stages_title') }}</h2>
            <div class="ornament-divider mt-4">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
        </div>

        <div class="mt-12 overflow-x-auto pb-2">
            <ol class="mx-auto flex min-w-[820px] items-start justify-between gap-2 px-2 py-3 lg:min-w-0">
                @foreach ($stages as $index => $stage)
                    <li
                        class="stages-item stages-animate relative z-10 flex w-[9.5rem] flex-col items-center text-center sm:w-40"
                        style="--stages-delay: {{ $index * 0.12 }}s"
                    >
                        @if (! $loop->last)
                            <span
                                class="stages-connector pointer-events-none absolute top-[2.375rem] left-[calc(50%+2rem)] hidden h-px w-[calc(100%-1rem)] bg-gold/40 sm:block"
                                style="--stages-connector-delay: {{ ($index * 0.12) + 0.25 }}s"
                                aria-hidden="true"
                            ></span>
                            <span class="pointer-events-none absolute top-[2.15rem] left-[calc(100%-0.35rem)] hidden text-gold/70 sm:block" aria-hidden="true">›</span>
                        @endif

                        <span class="stages-icon-wrap relative z-10 flex h-[4.75rem] w-[4.75rem] shrink-0 items-center justify-center">
                            <span class="stages-icon-ring pointer-events-none absolute inset-0 rounded-full border border-gold/25" aria-hidden="true"></span>
                            <span class="stages-icon relative flex h-14 w-14 items-center justify-center rounded-full border-2 border-gold bg-navy-soft text-gold">
                                <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-gold text-[10px] font-bold text-navy-deep">
                                    {{ $index + 1 }}
                                </span>
                                @php $iconIndex = $index % 5; @endphp
                                @if ($iconIndex === 0)
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                @elseif ($iconIndex === 1)
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.3-4.3M11 18a7 7 0 100-14 7 7 0 000 14z"/></svg>
                                @elseif ($iconIndex === 2)
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 10h8M8 14h5M7 4h10a2 2 0 012 2v11l-4-2H7a2 2 0 01-2-2V6a2 2 0 012-2z"/></svg>
                                @elseif ($iconIndex === 3)
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/><path d="M21 20v-1a3 3 0 00-2-2.83M16 4.13a3 3 0 010 5.74"/></svg>
                                @else
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l2 4 4 .6-3 2.9.8 4.5L12 13.2 8.2 15l.8-4.5-3-2.9 4-.6L12 3z"/></svg>
                                @endif
                            </span>
                        </span>

                        <h3 class="mt-4 text-[11px] font-semibold tracking-[0.12em] text-gold uppercase sm:text-xs">
                            {{ $stage->name }}
                        </h3>
                        <p class="mt-2 text-[11px] leading-relaxed text-white/70">
                            {{ $stage->description }}
                        </p>
                    </li>
                @endforeach
            </ol>
        </div>
    </div>
</section>
