<section class="relative overflow-hidden bg-cream py-10 sm:py-12">
    @include('partials.auth.decorative-shapes', ['variant' => 'light', 'density' => 'default'])

    <div class="site-container relative z-[2]">
        @if (session('alumni_registration_welcome'))
            @php($welcome = session('alumni_registration_welcome'))
            <div class="mb-6 rounded-sm border border-gold/35 bg-white px-5 py-5 text-sm text-navy shadow-sm">
                <p class="font-display text-lg font-semibold text-navy">Terima kasih, {{ $welcome['name'] }}!</p>
                <p class="mt-3 leading-relaxed text-muted">
                    Pendaftaran profil alumni Anda telah kami terima. Saat ini website IBGK Sumsel masih dalam proses perbaikan,
                    sehingga untuk sementara Anda hanya dapat mengakses Dashboard.
                </p>
                <div class="mt-4 rounded-md border border-navy/10 bg-cream/50 px-4 py-3">
                    <p class="text-xs font-semibold tracking-[0.12em] text-gold uppercase">Akun Dashboard</p>
                    <dl class="mt-3 grid gap-2 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs text-muted">Email</dt>
                            <dd class="mt-0.5 font-medium text-navy">{{ $welcome['email'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-muted">Password sementara</dt>
                            <dd class="mt-0.5 font-medium text-navy">{{ $welcome['temp_password'] }}</dd>
                        </div>
                    </dl>
                    <p class="mt-3 text-xs text-muted">Simpan informasi ini. Anda dapat login kembali melalui halaman Masuk jika keluar dari Dashboard.</p>
                </div>
            </div>
        @endif

        @if (session('development_access_notice'))
            <div class="mb-6 rounded-sm border border-navy/10 bg-white px-5 py-4 text-sm text-navy shadow-sm">
                {{ session('development_access_notice') }}
            </div>
        @endif

        @if (session('registration_success'))
            <div class="mb-6 rounded-sm border border-gold/35 bg-white px-5 py-4 text-sm text-navy shadow-sm">
                {{ session('registration_success') }}
            </div>
        @endif

        <div class="grid gap-6 lg:grid-cols-3">
            <div class="rounded-sm border border-navy/8 bg-white p-6 shadow-sm lg:col-span-2">
                <h2 class="font-display text-xl font-semibold text-navy">Informasi Akun</h2>
                <div class="mt-3 h-px w-12 bg-gold"></div>

                <dl class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div>
                        <dt class="text-xs font-semibold tracking-[0.12em] text-muted uppercase">Nama</dt>
                        <dd class="mt-1 text-sm font-medium text-navy">{{ $user->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold tracking-[0.12em] text-muted uppercase">Email</dt>
                        <dd class="mt-1 text-sm font-medium text-navy">{{ $user->email }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold tracking-[0.12em] text-muted uppercase">Bergabung</dt>
                        <dd class="mt-1 text-sm font-medium text-navy">{{ $user->created_at?->translatedFormat('d F Y') }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs font-semibold tracking-[0.12em] text-muted uppercase">Peran</dt>
                        <dd class="mt-2 flex flex-wrap gap-2">
                            @forelse ($roles as $role)
                                <span class="rounded-full bg-navy/8 px-3 py-1 text-xs font-semibold text-navy">{{ $role }}</span>
                            @empty
                                <span class="text-sm text-muted">Belum ada peran</span>
                            @endforelse
                        </dd>
                    </div>
                </dl>

                @if ($alumni ?? null)
                    <div class="mt-6 rounded-sm border border-navy/8 bg-cream/40 px-4 py-4">
                        <p class="text-xs font-semibold tracking-[0.12em] text-gold uppercase">Profil Alumni</p>
                        <p class="mt-2 text-sm text-navy">
                            {{ $alumni->batch?->name ?? 'Alumni IBGK' }}
                            · {{ $alumni->genderLabel() }}
                        </p>
                        <p class="mt-1 text-xs text-muted">
                            @if ($alumni->is_public)
                                Profil publik aktif di website.
                            @else
                                Profil menunggu persetujuan pengurus sebelum tampil di website.
                            @endif
                        </p>
                        <a href="{{ route('alumni.profile.edit') }}" class="mt-3 inline-flex text-xs font-semibold tracking-[0.1em] text-gold uppercase hover:text-navy">
                            Perbaiki Data Alumni →
                        </a>
                    </div>
                @endif
            </div>

            <div class="rounded-sm border border-navy/8 bg-white p-6 shadow-sm">
                <h2 class="font-display text-xl font-semibold text-navy">Status Akun</h2>
                <div class="mt-3 h-px w-12 bg-gold"></div>

                <ul class="mt-6 space-y-4 text-sm">
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full bg-gold/15 text-gold">
                            <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        </span>
                        <span class="text-navy">Akun aktif dan siap digunakan.</span>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="mt-0.5 flex h-6 w-6 shrink-0 items-center justify-center rounded-full {{ $canAccessAdmin ? 'bg-gold/15 text-gold' : 'bg-cream-muted text-muted' }}">
                            @if ($canAccessAdmin)
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            @else
                                <svg class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M6 12h12"/></svg>
                            @endif
                        </span>
                        <span class="text-navy">
                            @if ($canAccessAdmin)
                                Anda memiliki akses ke panel admin.
                            @else
                                Akses panel admin belum tersedia untuk akun ini.
                            @endif
                        </span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
