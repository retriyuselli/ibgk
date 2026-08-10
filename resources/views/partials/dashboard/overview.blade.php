<section class="relative overflow-hidden bg-cream py-10 sm:py-12">
    @include('partials.auth.decorative-shapes', ['variant' => 'light', 'density' => 'default'])

    <div class="site-container relative z-[2]">
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
