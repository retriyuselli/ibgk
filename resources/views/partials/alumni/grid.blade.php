<div>
    <div class="flex flex-wrap items-center gap-3">
        <h3 class="font-display text-2xl font-semibold text-navy">
            {{ $selectedBatch?->name ?? 'Alumni' }}
        </h3>
        <span class="rounded-full bg-navy px-3 py-1 text-xs font-semibold tracking-wide text-gold">
            {{ $selectedBatch?->historical_member_count ?: $alumni->total() }} Finalis
        </span>
    </div>

    @if ($alumni->isNotEmpty())
        <div class="mt-6 grid gap-5 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4">
            @foreach ($alumni as $person)
                <article class="overflow-hidden border border-navy/8 bg-white shadow-sm transition hover:border-gold/35">
                    <div class="relative">
                        {!! site_image_or_storage($person->photo, 'images/home/alumni-placeholder.jpg', $person->name, ['class' => 'aspect-[3/4] w-full object-cover']) !!}
                        <span class="absolute top-3 right-3 flex h-8 w-8 items-center justify-center rounded-full bg-navy/85 text-gold backdrop-blur-sm" title="{{ $person->gender === 'female' ? 'Gadis' : 'Bujang' }}">
                            @if ($person->gender === 'female')
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="10" r="5"/><path stroke-linecap="round" d="M14 14l6 6M16 20h4v-4"/></svg>
                            @else
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><circle cx="10" cy="14" r="5"/><path stroke-linecap="round" d="M14 6l4-4m0 0h-4m4 0v4"/></svg>
                            @endif
                        </span>
                    </div>
                    <div class="px-4 py-4">
                        <h4 class="font-semibold text-navy">{{ $person->name }}</h4>
                        <p class="mt-1 text-xs text-muted">{{ $person->university ?: '—' }}</p>
                        <p class="mt-0.5 text-xs font-medium text-navy/70">{{ $person->profession ?: 'Alumni IBGK' }}</p>
                        <a href="{{ route('alumni.show', $person) }}" class="mt-3 inline-flex items-center gap-1 text-xs font-semibold tracking-[0.12em] text-gold uppercase hover:text-navy">
                            Lihat Profil
                            <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </article>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $alumni->links() }}
        </div>
    @else
        <div class="mt-6 border border-dashed border-navy/15 bg-white px-6 py-12 text-center">
            <p class="font-display text-xl text-navy">Data alumni sedang dilengkapi</p>
            <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">
                Profil publik untuk {{ $selectedBatch?->name ?? 'angkatan ini' }} belum tersedia.
                Historis tercatat {{ $selectedBatch?->historical_member_count ?? 0 }} finalis.
            </p>
        </div>
    @endif
</div>
