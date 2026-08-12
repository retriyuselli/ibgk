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

                        <fieldset class="auth-field-animate space-y-4" style="--auth-delay: 0.04s">
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Identitas</legend>
                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-medium text-navy">Nama Lengkap *</label>
                                <input id="name" type="text" name="name" value="{{ old('name', $alumni->name) }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold focus:shadow-[0_0_0_3px_color-mix(in_oklab,var(--color-gold)_18%,transparent)]">
                                @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label for="photo" class="mb-1.5 block text-sm font-medium text-navy">Foto Profil</label>
                                @if ($alumni->photo)
                                    <p class="mb-2 text-xs text-muted">Foto saat ini akan diganti jika Anda mengunggah file baru.</p>
                                @endif
                                <input id="photo" type="file" name="photo" accept="image/*" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2 text-sm file:mr-3 file:rounded-md file:border-0 file:bg-navy file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-white">
                                @error('photo')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                        </fieldset>

                        <fieldset class="auth-field-animate space-y-4" style="--auth-delay: 0.12s">
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Pendidikan</legend>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="university" class="mb-1.5 block text-sm font-medium text-navy">Perguruan Tinggi</label>
                                    <input id="university" type="text" name="university" value="{{ old('university', $alumni->university) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('university')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="faculty" class="mb-1.5 block text-sm font-medium text-navy">Fakultas</label>
                                    <input id="faculty" type="text" name="faculty" value="{{ old('faculty', $alumni->faculty) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('faculty')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="study_program" class="mb-1.5 block text-sm font-medium text-navy">Program Studi</label>
                                    <input id="study_program" type="text" name="study_program" value="{{ old('study_program', $alumni->study_program) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('study_program')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="graduation_year" class="mb-1.5 block text-sm font-medium text-navy">Tahun Lulus</label>
                                    <input id="graduation_year" type="number" name="graduation_year" value="{{ old('graduation_year', $alumni->graduation_year) }}" min="1999" max="{{ now()->year + 10 }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('graduation_year')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="auth-field-animate space-y-4" style="--auth-delay: 0.2s">
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Karier</legend>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="profession" class="mb-1.5 block text-sm font-medium text-navy">Profesi</label>
                                    <input id="profession" type="text" name="profession" value="{{ old('profession', $alumni->profession) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('profession')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="company" class="mb-1.5 block text-sm font-medium text-navy">Instansi / Perusahaan</label>
                                    <input id="company" type="text" name="company" value="{{ old('company', $alumni->company) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('company')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="city" class="mb-1.5 block text-sm font-medium text-navy">Kota Domisili</label>
                                    <input id="city" type="text" name="city" value="{{ old('city', $alumni->city) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('city')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="auth-field-animate space-y-4" style="--auth-delay: 0.28s">
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Profil Publik</legend>
                            <div>
                                <label for="bio" class="mb-1.5 block text-sm font-medium text-navy">Biografi / Profesi Singkat</label>
                                <textarea id="bio" name="bio" rows="4" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">{{ old('bio', $alumni->bio) }}</textarea>
                                @error('bio')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                            </div>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="instagram" class="mb-1.5 block text-sm font-medium text-navy">Instagram</label>
                                    <input id="instagram" type="text" name="instagram" value="{{ old('instagram', $alumni->instagram) }}" placeholder="@username atau URL" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('instagram')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="linkedin" class="mb-1.5 block text-sm font-medium text-navy">LinkedIn</label>
                                    <input id="linkedin" type="url" name="linkedin" value="{{ old('linkedin', $alumni->linkedin) }}" placeholder="https://linkedin.com/in/..." class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('linkedin')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset class="auth-field-animate space-y-4" style="--auth-delay: 0.36s">
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Kontak (Privat)</legend>
                            <p class="text-xs text-muted">Email dan telepon hanya untuk keperluan administrasi IBGK, tidak otomatis ditampilkan di website.</p>
                            <div class="grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="email" class="mb-1.5 block text-sm font-medium text-navy">Email</label>
                                    <input id="email" type="email" name="email" value="{{ old('email', $alumni->email) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="phone" class="mb-1.5 block text-sm font-medium text-navy">Nomor Telepon</label>
                                    <input id="phone" type="tel" name="phone" value="{{ old('phone', $alumni->phone) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
                                    @error('phone')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <div class="auth-field-animate" style="--auth-delay: 0.44s">
                            <label class="flex items-start gap-2 text-sm text-navy">
                                <input type="checkbox" name="terms" value="1" @checked(old('terms')) required class="mt-0.5 rounded border-navy/20 text-gold focus:ring-gold">
                                <span>Saya menyatakan data yang saya isi benar dan dapat dipertanggungjawabkan.</span>
                            </label>
                            @error('terms')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                        </div>

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
