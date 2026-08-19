<section id="alumni" class="alumni-section relative overflow-hidden bg-navy py-16 text-white sm:py-20 lg:py-24">
    @include('partials.site.section-shapes', ['variant' => 'dark'])

    <div class="site-container relative">
        <div class="grid items-end gap-8 lg:grid-cols-[0.85fr_1.15fr]">
            <div>
                <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Alumni</p>
                <h2 class="section-title-light mt-3">
                    Keluarga Besar BGK Sumatera Selatan
                </h2>
                <p class="mt-4 max-w-md text-sm leading-relaxed text-white/70">
                    Rangkaian angkatan finalis dan alumni yang menjaga semangat kebersamaan, budaya, dan prestasi lintas generasi.
                </p>
                <a href="{{ route('alumni') }}" class="btn-gold mt-8">
                    Lihat Alumni
                    <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="relative min-w-0">
                <div class="mb-4 flex justify-end gap-2">
                    <button type="button" id="alumni-prev" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 text-white transition hover:border-gold hover:text-gold" aria-label="Sebelumnya">
                        ←
                    </button>
                    <button type="button" id="alumni-next" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/20 text-white transition hover:border-gold hover:text-gold" aria-label="Berikutnya">
                        →
                    </button>
                </div>

                <div id="alumni-track" class="alumni-track">
                    @forelse ($batches as $batch)
                        <a
                            href="{{ route('alumni.batch', $batch) }}"
                            class="alumni-card group w-52 shrink-0 overflow-hidden border border-white/10 bg-navy-soft transition hover:border-gold/50 sm:w-56"
                            aria-label="Lihat angkatan {{ $batch->year }}"
                        >
                            <div class="border-b border-white/10 px-4 py-3">
                                <p class="font-display text-2xl font-semibold text-gold">{{ $batch->year }}</p>
                                <p class="text-xs text-white/65">
                                    {{ $batch->displayMemberCount() ?: '—' }} Finalis
                                </p>
                            </div>
                            {!! site_image_or_storage($batch->photo, 'images/home/alumni-placeholder.jpg', 'Angkatan '.$batch->year, ['class' => 'aspect-[4/3] w-full object-cover transition duration-300 group-hover:scale-[1.03]']) !!}
                        </a>
                    @empty
                        <p class="text-sm text-white/60">Data angkatan belum tersedia.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</section>
