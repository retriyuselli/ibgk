<aside class="space-y-5">
    <div class="border border-navy/8 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between gap-3">
            <h3 class="font-display text-xl font-semibold text-navy">Angkatan</h3>
            <p class="text-[11px] font-medium tracking-wide text-muted">
                {{ $sidebarPage }} / {{ $sidebarPages }}
            </p>
        </div>
        <div class="mt-2 h-px w-12 bg-gold"></div>

        <nav class="mt-5 space-y-2" aria-label="Daftar angkatan">
            @foreach ($sidebarBatches as $batch)
                @php
                    $isActive = $selectedBatch?->id === $batch->id;
                    $url = route('alumni', array_filter([
                        'angkatan' => $batch->slug,
                        'halaman' => $sidebarPage,
                        'q' => $search ?: null,
                        'gender' => $gender ?: null,
                    ]));
                @endphp
                <a
                    href="{{ $url }}"
                    @class([
                        'flex items-center justify-between gap-3 rounded-md px-3 py-2.5 text-sm transition',
                        'bg-navy text-gold' => $isActive,
                        'bg-cream text-navy hover:bg-cream-muted' => ! $isActive,
                    ])
                >
                    <span class="flex items-center gap-2 font-medium">
                        <span @class(['text-gold', 'opacity-70' => ! $isActive])>
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 2M12 21a9 9 0 100-18 9 9 0 000 18z"/></svg>
                        </span>
                        {{ $batch->name }}
                    </span>
                    @if ($isActive)
                        <span aria-hidden="true">→</span>
                    @endif
                </a>
            @endforeach
        </nav>

        <div class="mt-4 flex items-center justify-between gap-2">
            @if ($sidebarPage > 1)
                <a
                    href="{{ route('alumni', array_filter([
                        'angkatan' => $prevPageBatch?->slug,
                        'halaman' => $sidebarPage - 1,
                        'q' => $search ?: null,
                        'gender' => $gender ?: null,
                    ])) }}"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-navy/15 text-navy transition hover:border-gold hover:text-gold"
                    aria-label="Angkatan sebelumnya"
                >
                    ←
                </a>
            @else
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-navy/8 text-navy/25" aria-hidden="true">←</span>
            @endif

            @if ($sidebarPage < $sidebarPages)
                <a
                    href="{{ route('alumni', array_filter([
                        'angkatan' => $nextPageBatch?->slug,
                        'halaman' => $sidebarPage + 1,
                        'q' => $search ?: null,
                        'gender' => $gender ?: null,
                    ])) }}"
                    class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-navy/15 text-navy transition hover:border-gold hover:text-gold"
                    aria-label="Angkatan berikutnya"
                >
                    →
                </a>
            @else
                <span class="inline-flex h-9 w-9 items-center justify-center rounded-full border border-navy/8 text-navy/25" aria-hidden="true">→</span>
            @endif
        </div>
    </div>

    <div class="rounded-md bg-navy px-5 py-5 text-white">
        <div class="flex items-center gap-3">
            <span class="flex h-10 w-10 items-center justify-center rounded-full border border-gold/40 text-gold">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/><path d="M21 20v-1a3 3 0 00-2-2.83M16 4.13a3 3 0 010 5.74"/></svg>
            </span>
            <div>
                <p class="text-[11px] font-semibold tracking-[0.14em] text-gold uppercase">Total Alumni</p>
                <p class="font-display text-2xl font-semibold">{{ number_format($totalAlumni) }} Finalis</p>
            </div>
        </div>
    </div>
</aside>
