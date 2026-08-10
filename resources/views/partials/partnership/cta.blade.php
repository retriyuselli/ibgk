<section id="ajukan" class="relative isolate overflow-hidden bg-navy py-14 text-white sm:py-16 lg:py-20">
    <div class="absolute inset-0 opacity-15" aria-hidden="true" style="background-image: repeating-linear-gradient(45deg, color-mix(in oklab, var(--color-gold) 10%, transparent) 0 2px, transparent 2px 16px);"></div>
    <div class="absolute inset-0 bg-gradient-to-br from-navy-deep/95 via-navy/90 to-navy-soft/95"></div>

    <div class="site-container relative grid gap-10 lg:grid-cols-2 lg:gap-14">
        <div>
            <h2 class="font-display text-2xl font-semibold text-gold sm:text-3xl lg:text-4xl">
                Mari Berkolaborasi
            </h2>
            <p class="mt-2 font-display text-xl text-gold/90 sm:text-2xl">
                Untuk Generasi Muda Sumatera Selatan
            </p>
            <p class="mt-5 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base">
                Instansi, perguruan tinggi, dunia usaha, media, dan komunitas dipersilakan
                bergabung dalam program IBGK Sumsel. Ajukan proposal kerja sama Anda melalui
                formulir di bawah ini.
            </p>

            @if (session('partnership_success'))
                <p class="mt-5 rounded-md border border-gold/30 bg-white/10 px-4 py-3 text-sm text-gold">
                    {{ session('partnership_success') }}
                </p>
            @endif

            <form method="POST" action="{{ route('partnership.submit') }}" class="mt-8 space-y-4 rounded-sm border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
                @csrf
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="partnership-name" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Nama</label>
                        <input id="partnership-name" type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">
                        @error('name')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="partnership-organization" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Instansi</label>
                        <input id="partnership-organization" type="text" name="organization" value="{{ old('organization') }}" class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">
                    </div>
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="partnership-email" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Email</label>
                        <input id="partnership-email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">
                        @error('email')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="partnership-phone" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Telepon</label>
                        <input id="partnership-phone" type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">
                    </div>
                </div>
                <div>
                    <label for="partnership-type" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Bentuk Kemitraan</label>
                    <select id="partnership-type" name="partnership_type" class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">
                        <option value="">Pilih bentuk kemitraan</option>
                        @foreach ($partnershipTypes as $type)
                            <option value="{{ $type['title'] }}" @selected(old('partnership_type') === $type['title'])>{{ $type['title'] }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="partnership-message" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Pesan / Proposal</label>
                    <textarea id="partnership-message" name="message" rows="4" required class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>
                <button type="submit" class="btn-gold w-full justify-center sm:w-auto">
                    Ajukan Kerja Sama
                    <span aria-hidden="true">→</span>
                </button>
            </form>
        </div>

        <div class="grid gap-4 sm:grid-cols-2">
            @foreach ($ctaFeatures as $feature)
                <article class="rounded-sm border border-white/10 bg-white/5 p-5 backdrop-blur-sm">
                    <span class="flex h-10 w-10 items-center justify-center rounded-full border border-gold/40 text-gold">
                        @switch($feature['icon'])
                            @case('star')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l2.2 4.4L19 8.2l-3.5 3.4.8 4.7L12 14.2 7.7 16.3l.8-4.7L5 8.2l4.8-.8L12 3z"/></svg>
                                @break
                            @case('target')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="8"/><circle cx="12" cy="12" r="3"/></svg>
                                @break
                            @case('shield')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 3v6c0 4-3 7-7 9-4-2-7-5-7-9V6l7-3z"/></svg>
                                @break
                            @default
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v4m0 10v4M3 12h4m10 0h4"/></svg>
                        @endswitch
                    </span>
                    <h3 class="mt-4 text-sm font-semibold text-gold">{{ $feature['title'] }}</h3>
                    <p class="mt-2 text-xs leading-relaxed text-white/75">{{ $feature['description'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
