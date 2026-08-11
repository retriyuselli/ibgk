<section class="relative border-b border-navy/5 bg-white overflow-hidden">
    <div class="site-container grid grid-cols-2 divide-x divide-navy/10 lg:grid-cols-4">
        @php
            use App\Models\AlumniBatch;

            $stats = [
                [
                    'value' => $profile?->founded_at?->format('Y') ?? '1999',
                    'label' => 'Berdiri',
                    'icon' => 'clock',
                ],
                [
                    'value' => (string) AlumniBatch::FIRST_ELECTION_YEAR,
                    'label' => 'Pemilihan Pertama',
                    'icon' => 'users',
                ],
                [
                    'value' => number_format($alumniCount),
                    'label' => 'Alumni',
                    'icon' => 'group',
                ],
                [
                    'value' => (string) $batchCount,
                    'label' => 'Angkatan',
                    'icon' => 'building',
                ],
            ];
        @endphp

        @foreach ($stats as $stat)
            <div class="flex flex-col items-center gap-3 px-4 py-8 text-center sm:py-10">
                <span class="text-gold">
                    @if ($stat['icon'] === 'clock')
                        <svg class="mx-auto h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="8"/><path stroke-linecap="round" d="M12 8v4l2.5 1.5"/></svg>
                    @elseif ($stat['icon'] === 'users')
                        <svg class="mx-auto h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M16 19v-1a3 3 0 00-3-3H7a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/><path stroke-linecap="round" d="M20 19v-1a3 3 0 00-2.5-2.95M15.5 5.1a3 3 0 010 5.8"/></svg>
                    @elseif ($stat['icon'] === 'group')
                        <svg class="mx-auto h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/><path d="M21 20v-1a3 3 0 00-2-2.83M16 4.13a3 3 0 010 5.74"/></svg>
                    @else
                        <svg class="mx-auto h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8l7-4 7 4v13M9 21v-6h6v6"/></svg>
                    @endif
                </span>
                <p class="font-display text-3xl font-semibold text-navy sm:text-4xl">{{ $stat['value'] }}</p>
                <p class="text-xs font-medium tracking-[0.14em] text-muted uppercase">{{ $stat['label'] }}</p>
            </div>
        @endforeach
    </div>
</section>
