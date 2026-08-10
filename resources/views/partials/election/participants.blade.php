<section id="peserta" class="participants-section relative overflow-hidden bg-cream py-16 sm:py-20 lg:py-24">
    @include('partials.site.section-shapes', ['variant' => 'light'])

    <div class="site-container relative">
        <div class="participants-header participants-animate mx-auto max-w-3xl text-center">
            <h2 class="section-title">Peserta Pemilihan BGK {{ $election?->year ?? $activeElection?->year }}</h2>
            <div class="ornament-divider mt-4">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
            <p class="mt-5 text-sm leading-relaxed text-muted sm:text-base">
                Kenali peserta publik Pemilihan Bujang Gadis Kampus Sumatera Selatan yang siap
                menunjukkan potensi, karakter, dan semangat generasi muda kampus.
            </p>
        </div>

        @if ($participants->isNotEmpty())
            <div class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($participants as $index => $participant)
                    <article
                        class="participant-card participants-animate overflow-hidden border border-navy/8 bg-white shadow-sm"
                        style="--participants-delay: {{ ($index * 0.1) + 0.15 }}s"
                    >
                        <div class="participant-photo relative overflow-hidden">
                            {!! site_image_or_storage($participant->photo, 'images/home/alumni-placeholder.jpg', $participant->full_name, ['class' => 'aspect-[3/4] w-full object-cover']) !!}
                            <span class="participant-badge absolute top-3 right-3 rounded-full bg-navy/85 px-2 py-1 text-[10px] font-semibold tracking-wide text-gold uppercase backdrop-blur-sm">
                                {{ $participant->gender === 'female' ? 'Gadis' : 'Bujang' }}
                            </span>
                        </div>
                        <div class="px-4 py-4">
                            <p class="text-[10px] font-semibold tracking-[0.14em] text-gold uppercase">
                                {{ $participant->registration_number }}
                            </p>
                            <h3 class="mt-1 font-semibold text-navy">{{ $participant->full_name }}</h3>
                            <p class="mt-1 text-xs text-muted">{{ $participant->university ?: '—' }}</p>
                            @if ($participant->motto)
                                <p class="mt-2 line-clamp-2 text-[11px] leading-relaxed text-muted italic">
                                    “{{ $participant->motto }}”
                                </p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>
        @else
            <div class="participants-animate participants-empty mt-10 border border-dashed border-navy/15 bg-white px-6 py-12 text-center" style="--participants-delay: 0.2s">
                <p class="font-display text-xl text-navy">Daftar peserta segera diumumkan</p>
                <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">
                    Profil peserta publik akan tampil setelah proses verifikasi administrasi selesai.
                </p>
                <a href="{{ route('election.register') }}" class="btn-gold mt-6">
                    Daftar BGK {{ $election?->year ?? $activeElection?->year ?? now()->year }}
                    <span aria-hidden="true">→</span>
                </a>
            </div>
        @endif
    </div>
</section>
