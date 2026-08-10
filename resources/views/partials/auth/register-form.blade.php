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
                    <h2 class="font-display text-2xl font-semibold text-navy">Buat Akun Baru</h2>
                    <div class="mt-3 h-px w-12 bg-gold"></div>
                    <p class="mt-4 text-sm text-muted">
                        Lengkapi data berikut untuk membuat akun akses panel admin IBGK Sumsel.
                    </p>
                </div>

                @include('partials.auth.google-button', ['delay' => '0.04s'])

                @include('partials.auth.divider', ['delay' => '0.06s'])

                <form method="POST" action="{{ route('register.store') }}" class="space-y-5">
                    @csrf

                    <div class="auth-field-animate" style="--auth-delay: 0.08s">
                        <label for="register-name" class="mb-1.5 block text-sm font-medium text-navy">Nama Lengkap *</label>
                        <input
                            id="register-name"
                            type="text"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            autocomplete="name"
                            autofocus
                            class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold focus:shadow-[0_0_0_3px_color-mix(in_oklab,var(--color-gold)_18%,transparent)]"
                        >
                        @error('name')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field-animate" style="--auth-delay: 0.14s">
                        <label for="register-email" class="mb-1.5 block text-sm font-medium text-navy">Email *</label>
                        <input
                            id="register-email"
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

                    <div class="auth-field-animate" style="--auth-delay: 0.2s">
                        <label for="register-password" class="mb-1.5 block text-sm font-medium text-navy">Kata Sandi *</label>
                        <input
                            id="register-password"
                            type="password"
                            name="password"
                            required
                            autocomplete="new-password"
                            class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold focus:shadow-[0_0_0_3px_color-mix(in_oklab,var(--color-gold)_18%,transparent)]"
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field-animate" style="--auth-delay: 0.26s">
                        <label for="register-password-confirmation" class="mb-1.5 block text-sm font-medium text-navy">Konfirmasi Kata Sandi *</label>
                        <input
                            id="register-password-confirmation"
                            type="password"
                            name="password_confirmation"
                            required
                            autocomplete="new-password"
                            class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold focus:shadow-[0_0_0_3px_color-mix(in_oklab,var(--color-gold)_18%,transparent)]"
                        >
                    </div>

                    <div class="auth-field-animate" style="--auth-delay: 0.32s">
                        <label class="flex items-start gap-3 text-sm leading-relaxed text-navy">
                            <input
                                type="checkbox"
                                name="terms"
                                value="1"
                                @checked(old('terms'))
                                required
                                class="mt-0.5 rounded border-navy/20 text-gold focus:ring-gold"
                            >
                            <span>Saya setuju data yang saya daftarkan digunakan untuk keperluan administrasi IBGK Sumsel.</span>
                        </label>
                        @error('terms')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="auth-field-animate" style="--auth-delay: 0.38s">
                        <button type="submit" class="btn-gold w-full justify-center transition-transform duration-300 hover:scale-[1.01] active:scale-[0.99]">
                            Daftar Akun
                            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8.5 11a4 4 0 100-8 4 4 0 000 8zM20 8v6m3-3h-6"/>
                            </svg>
                        </button>
                    </div>
                </form>

                <p class="auth-field-animate mt-6 text-center text-sm text-muted" style="--auth-delay: 0.44s">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="font-semibold text-navy underline decoration-gold/50 underline-offset-2 transition hover:text-gold">
                        Masuk di sini
                    </a>
                </p>
            </div>
        </div>
    </div>
</section>
