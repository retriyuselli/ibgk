<section class="auth-section relative isolate overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    @include('partials.auth.decorative-shapes', ['variant' => 'light', 'density' => 'rich'])

    <div class="pointer-events-none absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-navy/8 to-transparent" aria-hidden="true"></div>

    <div class="site-container relative z-[2]">
        <div class="mx-auto max-w-3xl">
            <div class="auth-form-card rounded-sm border border-navy/8 bg-white p-6 shadow-lg shadow-navy/5 sm:p-8">
                <div class="hero-animate">
                    <p class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">Dashboard Alumni</p>
                    <h1 class="mt-3 font-display text-2xl font-semibold text-navy sm:text-3xl">Perbaiki Profil Alumni</h1>
                    <div class="mt-3 h-px w-12 bg-gold"></div>
                    <p class="mt-4 text-sm leading-relaxed text-muted">
                        Perbarui data profil alumni Anda. Perubahan akan ditinjau pengurus sebelum ditampilkan di website.
                    </p>
                </div>

                @if (session('alumni_profile_updated'))
                    <div class="mt-6 rounded-sm border border-gold/35 bg-gold/5 px-4 py-3 text-sm text-navy">
                        Profil alumni berhasil diperbarui.
                    </div>
                @endif

                <div class="mt-6 grid gap-3 rounded-sm border border-navy/8 bg-cream/40 px-4 py-3 text-sm sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-semibold tracking-[0.12em] text-muted uppercase">Angkatan</p>
                        <p class="mt-1 font-medium text-navy">{{ $alumni->batch?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-semibold tracking-[0.12em] text-muted uppercase">Kategori</p>
                        <p class="mt-1 font-medium text-navy">{{ $alumni->genderLabel() }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('alumni.profile.update') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
                    @csrf
                    @method('PUT')

                    @include('partials.alumni.profile-form-fields', ['alumni' => $alumni, 'emailRequired' => true])

                    <div class="auth-field-animate flex flex-col gap-3 sm:flex-row sm:items-center" style="--auth-delay: 0.52s">
                        <button type="submit" class="btn-gold w-full justify-center sm:w-auto">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('dashboard') }}" class="btn-outline-gold w-full justify-center sm:w-auto">
                            Kembali ke Dashboard
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
