@php
    $org = $org ?? org_profile($profile ?? null);
    $year = $election?->year ?? now()->year;

    $fallbackRequirements = [
        'Mahasiswa/i aktif perguruan tinggi di Sumatera Selatan',
        'Usia 18–25 tahun pada tahun pemilihan',
        'Memiliki IPK minimal sesuai ketentuan panitia',
        'Berpenampilan menarik, beretika, dan berwawasan luas',
        'Bersedia mengikuti seluruh rangkaian kegiatan hingga selesai',
    ];

    $items = $requirements->isNotEmpty()
        ? $requirements->pluck('requirement')
        : collect($fallbackRequirements);

    $stages = $election?->stages ?? collect();
@endphp

<aside class="space-y-6">
    <div class="rounded-sm border border-navy/8 bg-white p-5 shadow-sm">
        <h2 class="font-display text-lg font-semibold text-navy">{{ $org->registrationCopy('sidebar_info_title') }}</h2>
        <div class="mt-3 h-px w-10 bg-gold"></div>
        <dl class="mt-5 space-y-3 text-sm">
            <div>
                <dt class="text-xs font-semibold tracking-wide text-gold uppercase">Tahun</dt>
                <dd class="mt-1 text-navy">{{ $year }}</dd>
            </div>
            @if ($election?->theme)
                <div>
                    <dt class="text-xs font-semibold tracking-wide text-gold uppercase">Tema</dt>
                    <dd class="mt-1 text-muted">{{ $election->theme }}</dd>
                </div>
            @endif
            @if ($election?->location)
                <div>
                    <dt class="text-xs font-semibold tracking-wide text-gold uppercase">Lokasi</dt>
                    <dd class="mt-1 text-muted">{{ $election->location }}</dd>
                </div>
            @endif
            @if ($election?->grand_final_date)
                <div>
                    <dt class="text-xs font-semibold tracking-wide text-gold uppercase">Grand Final</dt>
                    <dd class="mt-1 text-muted">{{ $election->grand_final_date->translatedFormat('d F Y') }}</dd>
                </div>
            @endif
        </dl>
        <a href="{{ route('election') }}" class="mt-5 inline-flex text-sm font-semibold text-gold hover:text-navy">
            {{ $org->registrationCopy('sidebar_election_link') }}
        </a>
    </div>

    <div class="rounded-sm border border-navy/8 bg-white p-5 shadow-sm">
        <h2 class="font-display text-lg font-semibold text-navy">{{ $org->registrationCopy('sidebar_requirements_title') }}</h2>
        <div class="mt-3 h-px w-10 bg-gold"></div>
        <ul class="mt-5 space-y-3">
            @foreach ($items as $requirement)
                <li class="flex gap-2 text-xs leading-relaxed text-muted">
                    <span class="mt-0.5 text-gold">•</span>
                    <span>{{ $requirement }}</span>
                </li>
            @endforeach
        </ul>
    </div>

    @if ($stages->isNotEmpty())
        <div class="rounded-sm border border-navy/8 bg-white p-5 shadow-sm">
            <h2 class="font-display text-lg font-semibold text-navy">{{ $org->registrationCopy('sidebar_stages_title') }}</h2>
            <div class="mt-3 h-px w-10 bg-gold"></div>
            <ol class="mt-5 space-y-3">
                @foreach ($stages->take(5) as $index => $stage)
                    <li class="flex gap-3">
                        <span class="flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-cream text-xs font-semibold text-gold">{{ $index + 1 }}</span>
                        <div>
                            <p class="text-sm font-semibold text-navy">{{ $stage->name }}</p>
                            @if ($stage->description)
                                <p class="mt-0.5 text-xs text-muted">{{ $stage->description }}</p>
                            @endif
                        </div>
                    </li>
                @endforeach
            </ol>
        </div>
    @endif

    <div class="rounded-sm bg-navy p-5 text-white shadow-sm">
        <h2 class="font-display text-lg font-semibold text-gold">{{ $org->registrationCopy('sidebar_help_title') }}</h2>
        <p class="mt-3 text-xs leading-relaxed text-white/75">
            {{ $org->registrationCopy('sidebar_help_text', ['year' => $year]) }}
        </p>
        <a href="{{ route('contact') }}" class="btn-outline-gold mt-5 inline-flex text-xs">
            {{ $org->registrationCopy('sidebar_help_button') }}
        </a>
    </div>
</aside>
