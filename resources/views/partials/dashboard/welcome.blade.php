<section class="relative isolate overflow-hidden bg-navy text-white">
    @include('partials.auth.decorative-shapes', ['variant' => 'dark', 'density' => 'rich'])

    <div class="site-container relative z-[2] py-12 sm:py-14 lg:py-16">
        <div class="hero-animate flex flex-col gap-6 sm:flex-row sm:items-center sm:justify-between">
            <div class="max-w-2xl">
                <p class="text-xs font-semibold tracking-[0.18em] text-gold uppercase">
                    {{ ($participant ?? null) ? 'Dashboard Peserta' : 'Dashboard Pengguna' }}
                </p>
                <h1 class="mt-3 font-display text-3xl font-semibold tracking-tight sm:text-4xl">
                    Selamat datang, {{ $user->name }}
                </h1>
                <p class="mt-4 text-sm leading-relaxed text-white/80 sm:text-base">
                    @if ($participant ?? null)
                        Pantau status seleksi Pemilihan BGK dan pengumuman lulus tahap selanjutnya dari sini.
                    @else
                        Kelola akses akun Anda dan lanjutkan ke fitur IBGK Sumsel dari sini.
                    @endif
                </p>
            </div>

            @if ($participant ?? null)
                @include('partials.dashboard.profile-photo', [
                    'subject' => $participant,
                    'size' => 'lg',
                    'borderClass' => 'border-gold/40 bg-white/5 shadow-black/20',
                ])
            @elseif ($alumni ?? null)
                @include('partials.dashboard.profile-photo', [
                    'subject' => $alumni,
                    'size' => 'lg',
                    'borderClass' => 'border-gold/40 bg-white/5 shadow-black/20',
                ])
            @endif
        </div>
    </div>
</section>
