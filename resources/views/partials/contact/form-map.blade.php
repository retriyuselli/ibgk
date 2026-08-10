<section class="relative overflow-hidden bg-white py-14 sm:py-16 lg:py-20">
    <div class="site-container grid gap-8 lg:grid-cols-2 lg:gap-10">
        <div id="kirim-pesan" class="rounded-sm bg-navy p-6 text-white shadow-lg sm:p-8">
            <h2 class="font-display text-2xl font-semibold">Kirim Pesan</h2>
            <div class="mt-3 h-px w-12 bg-gold"></div>

            @if (session('contact_success'))
                <p class="mt-5 rounded-md border border-gold/30 bg-white/10 px-4 py-3 text-sm text-gold">
                    {{ session('contact_success') }}
                </p>
            @endif

            <form method="POST" action="{{ route('contact.submit') }}" class="mt-6 space-y-4">
                @csrf
                <div>
                    <label for="contact-name" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Nama Lengkap *</label>
                    <input id="contact-name" type="text" name="name" value="{{ old('name') }}" required class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">
                    @error('name')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="contact-email" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Email *</label>
                        <input id="contact-email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">
                        @error('email')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="contact-phone" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Nomor Telepon</label>
                        <input id="contact-phone" type="text" name="phone" value="{{ old('phone') }}" class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">
                    </div>
                </div>
                <div>
                    <label for="contact-subject" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Subjek / Keperluan</label>
                    <input id="contact-subject" type="text" name="subject" value="{{ old('subject') }}" class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">
                </div>
                <div>
                    <label for="contact-message" class="mb-1.5 block text-xs font-semibold tracking-wide text-white/80 uppercase">Pesan Anda *</label>
                    <textarea id="contact-message" name="message" rows="5" required class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none focus:border-gold">{{ old('message') }}</textarea>
                    @error('message')<p class="mt-1 text-xs text-rose-300">{{ $message }}</p>@enderror
                </div>
                <label class="flex items-start gap-3 text-xs leading-relaxed text-white/75">
                    <input type="checkbox" name="privacy" value="1" @checked(old('privacy')) required class="mt-0.5 rounded border-white/30 text-gold focus:ring-gold">
                    <span>Saya setuju data yang saya kirimkan digunakan untuk keperluan komunikasi sesuai kebijakan privasi IBGK Sumsel.</span>
                </label>
                @error('privacy')<p class="text-xs text-rose-300">{{ $message }}</p>@enderror
                <button type="submit" class="btn-gold w-full justify-center">
                    Kirim Pesan
                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                </button>
            </form>
        </div>

        <div class="overflow-hidden rounded-sm border border-navy/8 bg-cream/50 shadow-sm">
            <div class="border-b border-navy/8 px-6 py-5">
                <h2 class="font-display text-2xl font-semibold text-navy">Lokasi Kami</h2>
                <div class="mt-3 h-px w-12 bg-gold"></div>
                <p class="mt-3 text-sm text-muted">{{ $contactInfo['address'] }}</p>
            </div>
            <div class="aspect-[4/3] w-full bg-cream-muted">
                <iframe
                    src="{{ $mapEmbed }}"
                    title="Peta lokasi IBGK Sumsel"
                    class="h-full w-full border-0"
                    loading="lazy"
                    referrerpolicy="no-referrer-when-downgrade"
                    allowfullscreen
                ></iframe>
            </div>
        </div>
    </div>
</section>
