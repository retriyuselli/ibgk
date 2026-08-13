<div
    id="development-gate"
    class="development-gate fixed inset-0 z-[200] flex items-center justify-center overflow-hidden p-4 sm:p-6"
    role="dialog"
    aria-modal="true"
    aria-labelledby="development-gate-title"
>
    <div class="development-gate-backdrop absolute inset-0 overflow-hidden bg-navy-deep/75 backdrop-blur-sm" aria-hidden="true">
        @include('partials.auth.decorative-shapes', ['variant' => 'dark', 'density' => 'rich'])
    </div>

    <div class="development-gate-panel relative w-full max-w-md overflow-hidden rounded-sm border border-white/10 bg-white p-6 shadow-2xl sm:p-8">
        @include('partials.auth.decorative-shapes', ['variant' => 'light', 'density' => 'default'])

        <div class="relative z-10">
        <div class="auth-field-animate text-center" style="--auth-delay: 0s">
            <span class="development-gate-icon mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gold/15 text-gold">
                <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>
            </span>

            <h2 id="development-gate-title" class="mt-5 font-display text-2xl font-semibold text-navy">
                Situs Sedang Dalam Pengembangan
            </h2>
            <div class="mx-auto mt-3 h-px w-12 bg-gold"></div>
            <p class="mt-4 text-sm leading-relaxed text-muted">
                Halaman website IBGK Sumatera Selatan saat ini masih dalam tahap pengembangan.
                Pendaftaran Peserta BGK tetap dibuka. Silakan daftar, atau masuk jika sudah punya akun.
            </p>
        </div>

        <div class="auth-field-animate mt-6" style="--auth-delay: 0.06s">
            <a href="{{ route('election.register') }}" class="btn-gold w-full justify-center">
                Daftar Peserta BGK
                <span aria-hidden="true">→</span>
            </a>
            <p class="mt-3 text-center text-xs text-muted">
                <a href="{{ route('election') }}" class="font-semibold text-gold hover:text-navy">Lihat info Pemilihan BGK</a>
            </p>
        </div>

        <form method="POST" action="{{ route('login.store') }}" class="mt-8 space-y-4">
            @csrf

            <div class="auth-field-animate" style="--auth-delay: 0.1s">
                <label for="gate-email" class="mb-1.5 block text-sm font-medium text-navy">Email</label>
                <input
                    id="gate-email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autocomplete="email"
                    class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold focus:shadow-[0_0_0_3px_color-mix(in_oklab,var(--color-gold)_18%,transparent)]"
                >
                @error('email')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field-animate" style="--auth-delay: 0.18s">
                <label for="gate-password" class="mb-1.5 block text-sm font-medium text-navy">Kata Sandi</label>
                <input
                    id="gate-password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold focus:shadow-[0_0_0_3px_color-mix(in_oklab,var(--color-gold)_18%,transparent)]"
                >
                @error('password')
                    <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="auth-field-animate" style="--auth-delay: 0.26s">
            <button type="submit" class="btn-gold w-full justify-center transition-transform duration-300 hover:scale-[1.01] active:scale-[0.99]">
                Masuk
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                </svg>
            </button>
            </div>
        </form>

        @if (filled(config('services.google.client_id')))
            <div class="auth-field-animate mt-4" style="--auth-delay: 0.34s">
                @include('partials.auth.divider')
                <a href="{{ route('auth.google') }}" class="btn-google mt-4">
                    <svg class="h-5 w-5 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92a5.06 5.06 0 01-2.2 3.32v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.1z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                    </svg>
                    Lanjutkan dengan Google
                </a>
            </div>
        @endif
        </div>
    </div>
</div>
