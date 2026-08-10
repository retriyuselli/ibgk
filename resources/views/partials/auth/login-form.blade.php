<section class="auth-section relative isolate overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    @include('partials.auth.decorative-shapes', ['variant' => 'light', 'density' => 'rich'])

    <div
        class="pointer-events-none absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-navy/8 to-transparent"
        aria-hidden="true"
    ></div>

    <div class="site-container relative z-[2]">
        <div class="mx-auto max-w-md">
            <div class="auth-form-card rounded-sm border border-navy/8 bg-white p-6 shadow-lg shadow-navy/5 sm:p-8">
                <div class="auth-field-animate" style="--auth-delay: 0s">
                    <h2 class="font-display text-2xl font-semibold text-navy">Masuk ke Akun</h2>
                    <div class="mt-3 h-px w-12 bg-gold"></div>
                    <p class="mt-4 text-sm text-muted">
                        Masukkan email dan kata sandi yang telah diberikan oleh pengurus IBGK Sumsel.
                    </p>
                </div>

                @include('partials.auth.google-button', ['delay' => '0.04s'])

                @include('partials.auth.divider', ['delay' => '0.06s'])

                <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                    @csrf

                    <div class="auth-field-animate" style="--auth-delay: 0.08s">
                        <label for="login-email" class="mb-1.5 block text-sm font-medium text-navy">Email *</label>
                        <input
                            id="login-email"
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            autofocus
                            class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold focus:shadow-[0_0_0_3px_color-mix(in_oklab,var(--color-gold)_18%,transparent)]"
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field-animate" style="--auth-delay: 0.16s">
                        <label for="login-password" class="mb-1.5 block text-sm font-medium text-navy">Kata Sandi *</label>
                        <input
                            id="login-password"
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

                    <div class="auth-field-animate" style="--auth-delay: 0.24s">
                        <label class="flex items-center gap-2 text-sm text-navy">
                            <input
                                type="checkbox"
                                name="remember"
                                value="1"
                                @checked(old('remember'))
                                class="rounded border-navy/20 text-gold focus:ring-gold"
                            >
                            Ingat saya
                        </label>
                    </div>

                    <div class="auth-field-animate" style="--auth-delay: 0.32s">
                        <button type="submit" class="btn-gold w-full justify-center transition-transform duration-300 hover:scale-[1.01] active:scale-[0.99]">
                            Masuk
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <p class="auth-field-animate mt-6 text-center text-sm text-muted" style="--auth-delay: 0.4s">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-semibold text-navy underline decoration-gold/50 underline-offset-2 transition hover:text-gold">
                        Daftar di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
