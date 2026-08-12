@php
    $values = $alumni ?? null;
@endphp

<fieldset class="auth-field-animate space-y-4" style="--auth-delay: 0.04s">
    <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Identitas</legend>
    <div>
        <label for="name" class="mb-1.5 block text-sm font-medium text-navy">Nama Lengkap *</label>
        <input id="name" type="text" name="name" value="{{ old('name', $values?->name) }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold focus:shadow-[0_0_0_3px_color-mix(in_oklab,var(--color-gold)_18%,transparent)]">
        @error('name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div>
        <label for="photo" class="mb-1.5 block text-sm font-medium text-navy">Foto Profil</label>
        @if ($values?->photo)
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
            <input id="university" type="text" name="university" value="{{ old('university', $values?->university) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
            @error('university')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="faculty" class="mb-1.5 block text-sm font-medium text-navy">Fakultas</label>
            <input id="faculty" type="text" name="faculty" value="{{ old('faculty', $values?->faculty) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
            @error('faculty')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="study_program" class="mb-1.5 block text-sm font-medium text-navy">Program Studi</label>
            <input id="study_program" type="text" name="study_program" value="{{ old('study_program', $values?->study_program) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
            @error('study_program')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="graduation_year" class="mb-1.5 block text-sm font-medium text-navy">Tahun Lulus</label>
            <input id="graduation_year" type="number" name="graduation_year" value="{{ old('graduation_year', $values?->graduation_year) }}" min="1999" max="{{ now()->year + 10 }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
            @error('graduation_year')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>
    </div>
</fieldset>

<fieldset class="auth-field-animate space-y-4" style="--auth-delay: 0.2s">
    <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Karier</legend>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="profession" class="mb-1.5 block text-sm font-medium text-navy">Profesi</label>
            <input id="profession" type="text" name="profession" value="{{ old('profession', $values?->profession) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
            @error('profession')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="company" class="mb-1.5 block text-sm font-medium text-navy">Instansi / Perusahaan</label>
            <input id="company" type="text" name="company" value="{{ old('company', $values?->company) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
            @error('company')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>
        <div class="sm:col-span-2">
            <label for="city" class="mb-1.5 block text-sm font-medium text-navy">Kota Domisili</label>
            <input id="city" type="text" name="city" value="{{ old('city', $values?->city) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
            @error('city')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>
    </div>
</fieldset>

<fieldset class="auth-field-animate space-y-4" style="--auth-delay: 0.28s">
    <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Profil Publik</legend>
    <div>
        <label for="bio" class="mb-1.5 block text-sm font-medium text-navy">Biografi / Profesi Singkat</label>
        <textarea id="bio" name="bio" rows="4" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">{{ old('bio', $values?->bio) }}</textarea>
        @error('bio')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
    </div>
    <div class="grid gap-4 sm:grid-cols-2">
        <div>
            <label for="instagram" class="mb-1.5 block text-sm font-medium text-navy">Instagram</label>
            <input id="instagram" type="text" name="instagram" value="{{ old('instagram', $values?->instagram) }}" placeholder="@username atau URL" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
            @error('instagram')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="linkedin" class="mb-1.5 block text-sm font-medium text-navy">LinkedIn</label>
            <input id="linkedin" type="url" name="linkedin" value="{{ old('linkedin', $values?->linkedin) }}" placeholder="https://linkedin.com/in/..." class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
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
            <input id="email" type="email" name="email" value="{{ old('email', $values?->email) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
            @error('email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
        </div>
        <div>
            <label for="phone" class="mb-1.5 block text-sm font-medium text-navy">Nomor Telepon</label>
            <input id="phone" type="tel" name="phone" value="{{ old('phone', $values?->phone) }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none transition focus:border-gold">
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
