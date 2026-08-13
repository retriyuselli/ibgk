@php
    $org = $org ?? org_profile($profile);

    $fallbackRequirements = [
        'Mahasiswa/i aktif perguruan tinggi di Sumatera Selatan',
        'Usia 18–25 tahun pada tahun pemilihan',
        'Memiliki IPK minimal sesuai ketentuan panitia',
        'Berpenampilan menarik, beretika, dan berwawasan luas',
        'Bersedia mengikuti seluruh rangkaian kegiatan hingga selesai',
        'Tidak sedang terlibat kasus hukum',
    ];

    $requirements = $election?->requirements?->isNotEmpty()
        ? $election->requirements->pluck('requirement')
        : collect($fallbackRequirements);

    $fallbackBenefits = [
        ['Pembinaan', 'Pelatihan kepemimpinan, komunikasi, dan soft skill.'],
        ['Jaringan & Relasi', 'Terhubung dengan alumni dan mitra lintas sektor.'],
        ['Pengalaman Berharga', 'Pengalaman panggung, kerja tim, dan manajemen diri.'],
        ['Prestasi & Penghargaan', 'Pengakuan resmi sebagai Bujang/Gadis Kampus Sumsel.'],
    ];

    $benefits = $election?->benefits?->isNotEmpty()
        ? $election->benefits->map(fn ($b) => [$b->title, $b->description])
        : collect($fallbackBenefits);
@endphp

<section id="persyaratan" class="election-requirements-section relative overflow-hidden bg-white py-16 sm:py-20 lg:py-24">
    @include('partials.site.section-shapes', ['variant' => 'light'])

    <div class="site-container relative grid gap-10 lg:grid-cols-2 lg:gap-14">
        <div>
            <h2 class="section-title">{{ $org->electionCopy('requirements_title') }}</h2>
            <div class="mt-3 h-px w-16 bg-gold"></div>

            <ul class="mt-8 space-y-3">
                @foreach ($requirements as $requirement)
                    <li class="flex gap-3 text-sm leading-relaxed text-navy sm:text-base">
                        <span class="mt-0.5 flex h-5 w-5 shrink-0 items-center justify-center rounded-full bg-gold/15 text-gold">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                            </svg>
                        </span>
                        <span>{{ $requirement }}</span>
                    </li>
                @endforeach
            </ul>

            @if ($guideDocument ?? null)
                <a href="{{ route('documents.download', $guideDocument) }}" class="btn-outline-gold mt-8">
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    {{ $org->electionCopy('download_guide_full_label') }}
                </a>
            @else
                <p class="mt-8 text-sm text-muted">{{ $org->electionCopy('guide_unavailable_text') }}</p>
            @endif
        </div>

        <div class="grid items-start gap-6 sm:grid-cols-[1fr_0.85fr]">
            <div>
                <h2 class="section-title">{{ $org->electionCopy('benefits_title') }}</h2>
                <div class="mt-3 h-px w-16 bg-gold"></div>

                <ul class="mt-8 space-y-5">
                    @foreach ($benefits as $benefit)
                        <li class="flex gap-3">
                            <span class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-full border border-gold/40 text-gold">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.5l1.76 3.56 3.93.57-2.84 2.77.67 3.91-3.52-1.85-3.52 1.85.67-3.91-2.84-2.77 3.93-.57L11.48 3.5z"/>
                                </svg>
                            </span>
                            <div>
                                <h3 class="font-semibold text-navy">{{ $benefit[0] }}</h3>
                                <p class="mt-1 text-sm leading-relaxed text-muted">{{ $benefit[1] }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>

            <figure class="overflow-hidden rounded-lg shadow-md shadow-navy/10">
                {!! site_image_or_storage(
                    $org->electionBenefitsImageStoragePath(),
                    $org->electionBenefitsImagePath(),
                    'Suasana Grand Final BGK',
                    ['class' => 'aspect-[3/4] h-full w-full object-cover']
                ) !!}
            </figure>
        </div>
    </div>
</section>
