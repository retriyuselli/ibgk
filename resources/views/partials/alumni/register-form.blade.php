<section class="auth-section relative isolate overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    @include('partials.auth.decorative-shapes', ['variant' => 'light', 'density' => 'rich'])

    <div class="pointer-events-none absolute inset-x-0 top-0 h-32 bg-gradient-to-b from-navy/8 to-transparent" aria-hidden="true"></div>

    <div class="site-container relative z-[2]">
        <div class="mx-auto max-w-3xl">
            <div class="auth-form-card rounded-sm border border-navy/8 bg-white p-6 shadow-lg shadow-navy/5 sm:p-8">
                <div class="hero-animate">
                    <p class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">Formulir Alumni</p>
                    <h1 class="mt-3 font-display text-2xl font-semibold text-navy sm:text-3xl">Daftar Profil Alumni</h1>
                    <div class="mt-3 h-px w-12 bg-gold"></div>
                    <p class="mt-4 text-sm leading-relaxed text-muted">
                        Alumni IBGK Sumsel dapat mengisi profil sendiri. Pilih angkatan BGK Anda, lengkapi data, lalu kirim.
                        Setelah terdaftar, akun Dashboard akan dibuat otomatis menggunakan email Anda.
                    </p>
                </div>

                <form method="POST" action="{{ route('alumni.register.store') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
                    @csrf

                    <fieldset class="auth-field-animate space-y-4" style="--auth-delay: 0s">
                        <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Keanggotaan</legend>
                        <div>
                            <label for="alumni_batch_id" class="mb-1.5 block text-sm font-medium text-navy">Angkatan BGK *</label>
                            <select id="alumni_batch_id" name="alumni_batch_id" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold focus:shadow-[0_0_0_3px_color-mix(in_oklab,var(--color-gold)_18%,transparent)]">
                                <option value="">Pilih angkatan...</option>
                                @foreach ($batches as $batch)
                                    <option value="{{ $batch->id }}" @selected((string) old('alumni_batch_id') === (string) $batch->id)>
                                        {{ $batch->name }} ({{ $batch->year }})
                                    </option>
                                @endforeach
                            </select>
                            @error('alumni_batch_id')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                        <div>
                            <label class="mb-1.5 block text-sm font-medium text-navy">Kategori *</label>
                            <div class="flex flex-wrap gap-4">
                                <label class="inline-flex items-center gap-2 text-sm text-navy">
                                    <input type="radio" name="gender" value="bujang" @checked(old('gender') === 'bujang') required class="text-gold focus:ring-gold">
                                    Bujang Kampus
                                </label>
                                <label class="inline-flex items-center gap-2 text-sm text-navy">
                                    <input type="radio" name="gender" value="gadis" @checked(old('gender') === 'gadis') required class="text-gold focus:ring-gold">
                                    Gadis Kampus
                                </label>
                            </div>
                            @error('gender')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>
                    </fieldset>

                    @include('partials.alumni.profile-form-fields', ['emailRequired' => true])

                    <div class="auth-field-animate" style="--auth-delay: 0.52s">
                        <button type="submit" class="btn-gold w-full justify-center transition-transform duration-300 hover:scale-[1.01] active:scale-[0.99]">
                            Daftar & Masuk Dashboard
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
