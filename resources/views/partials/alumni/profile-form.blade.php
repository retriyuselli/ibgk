<section class="auth-section relative isolate overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    @include('partials.auth.decorative-shapes', ['variant' => 'light', 'density' => 'rich'])

    <div class="pointer-events-none absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-navy/8 to-transparent" aria-hidden="true"></div>

    <div class="site-container relative z-[2]">
        <div class="mx-auto max-w-3xl">
            @if ($submitted)
                <div class="auth-form-card rounded-sm border border-gold/35 bg-white p-8 text-center shadow-lg shadow-navy/5">
                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gold/15 text-gold">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                    </span>
                    <h1 class="mt-5 font-display text-2xl font-semibold text-navy">Profil Berhasil Disimpan</h1>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Terima kasih, <strong class="text-navy">{{ $alumni->name }}</strong>.
                        Data profil alumni Anda telah kami terima. Pengurus IBGK Sumsel akan meninjau sebelum ditampilkan di website.
                    </p>
                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                        <a href="{{ route('alumni.profile.form', $alumni->profile_token) }}" class="btn-outline-gold">
                            Perbarui Data
                        </a>
                        <a href="{{ route('home') }}" class="btn-gold">Kembali ke Beranda</a>
                    </div>
                </div>
            @else
                <div class="auth-form-card rounded-sm border border-navy/8 bg-white p-6 shadow-lg shadow-navy/5 sm:p-8">
                    <div class="hero-animate">
                        <p class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">Formulir Alumni</p>
                        <h1 class="mt-3 font-display text-2xl font-semibold text-navy sm:text-3xl">Lengkapi Profil Alumni</h1>
                        <div class="mt-3 h-px w-12 bg-gold"></div>
                        <p class="mt-4 text-sm leading-relaxed text-muted">
                            Halo <strong class="text-navy">{{ $alumni->name }}</strong>,
                            silakan lengkapi data profil Anda sebagai alumni
                            @if ($alumni->batch)
                                <strong class="text-navy">{{ $alumni->batch->name }}</strong>
                            @endif
                            ({{ $alumni->gender === 'gadis' ? 'Gadis Kampus' : 'Bujang Kampus' }}).
                        </p>
                    </div>

                    <form method="POST" action="{{ route('alumni.profile.form.submit', $alumni->profile_token) }}" enctype="multipart/form-data" class="mt-8 space-y-6">
                        @csrf

                        @include('partials.alumni.profile-form-fields', ['alumni' => $alumni])

                        <div class="auth-field-animate" style="--auth-delay: 0.52s">
                            <button type="submit" class="btn-gold w-full justify-center transition-transform duration-300 hover:scale-[1.01] active:scale-[0.99]">
                                Simpan Profil Alumni
                            </button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    </div>
</section>
