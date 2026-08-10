@php
    $success = session('registration_success');
    $year = $election?->year ?? now()->year;
@endphp

<section class="relative overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    <div class="site-container grid gap-10 lg:grid-cols-[1fr_320px] xl:grid-cols-[1fr_360px] xl:gap-12">
        <div>
            @if ($success)
                <div class="rounded-sm border border-gold/35 bg-white p-8 text-center shadow-sm">
                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gold/15 text-gold">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <h2 class="mt-5 font-display text-2xl font-semibold text-navy">Pendaftaran Berhasil</h2>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        Terima kasih, <strong class="text-navy">{{ $success['name'] }}</strong>.
                        Nomor registrasi Anda:
                    </p>
                    <p class="mt-4 inline-block rounded-md bg-navy px-4 py-2 font-display text-xl font-semibold tracking-wide text-gold">
                        {{ $success['number'] }}
                    </p>
                    <p class="mt-4 text-xs text-muted">
                        Simpan nomor registrasi ini. Panitia akan menghubungi Anda melalui email atau telepon untuk tahap selanjutnya.
                    </p>
                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                        <a href="{{ route('election') }}" class="btn-outline-gold">Lihat Info Pemilihan</a>
                        <a href="{{ route('home') }}" class="btn-gold">Kembali ke Beranda</a>
                    </div>
                </div>
            @elseif (! $registrationOpen)
                <div class="rounded-sm border border-dashed border-navy/15 bg-white px-6 py-12 text-center shadow-sm">
                    <h2 class="font-display text-2xl font-semibold text-navy">Pendaftaran Belum Dibuka</h2>
                    <p class="mt-3 text-sm text-muted">
                        {{ session('registration_error') ?: 'Formulir pendaftaran Pemilihan BGK saat ini belum tersedia atau periode pendaftaran telah berakhir.' }}
                    </p>
                    <a href="{{ route('election') }}" class="btn-gold mt-6 inline-flex">Lihat Jadwal Pemilihan</a>
                </div>
            @else
                <div class="rounded-sm border border-navy/8 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="font-display text-2xl font-semibold text-navy">Formulir Pendaftaran</h2>
                    <div class="mt-3 h-px w-12 bg-gold"></div>
                    <p class="mt-4 text-sm text-muted">
                        Lengkapi data diri Anda dengan benar. Pastikan seluruh informasi dapat diverifikasi oleh panitia.
                    </p>

                    <form method="POST" action="{{ route('election.register.submit') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
                        @csrf

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Data Diri</legend>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="mb-1.5 block text-sm font-medium text-navy">Kategori Peserta *</label>
                                    <div class="flex flex-wrap gap-4">
                                        <label class="inline-flex items-center gap-2 text-sm text-navy">
                                            <input type="radio" name="gender" value="male" @checked(old('gender') === 'male') required class="text-gold focus:ring-gold">
                                            Bujang
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-sm text-navy">
                                            <input type="radio" name="gender" value="female" @checked(old('gender') === 'female') required class="text-gold focus:ring-gold">
                                            Gadis
                                        </label>
                                    </div>
                                    @error('gender')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="full_name" class="mb-1.5 block text-sm font-medium text-navy">Nama Lengkap *</label>
                                    <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                    @error('full_name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="birth_place" class="mb-1.5 block text-sm font-medium text-navy">Tempat Lahir *</label>
                                    <input id="birth_place" type="text" name="birth_place" value="{{ old('birth_place') }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                    @error('birth_place')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="birth_date" class="mb-1.5 block text-sm font-medium text-navy">Tanggal Lahir *</label>
                                    <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                    @error('birth_date')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="city" class="mb-1.5 block text-sm font-medium text-navy">Kota Asal *</label>
                                    <input id="city" type="text" name="city" value="{{ old('city') }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                    @error('city')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="photo" class="mb-1.5 block text-sm font-medium text-navy">Foto Diri</label>
                                    <input id="photo" type="file" name="photo" accept="image/*" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2 text-sm file:mr-3 file:rounded file:border-0 file:bg-gold file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-navy-deep">
                                    @error('photo')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Data Kampus</legend>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="university" class="mb-1.5 block text-sm font-medium text-navy">Perguruan Tinggi *</label>
                                    <input id="university" type="text" name="university" value="{{ old('university') }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                    @error('university')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="faculty" class="mb-1.5 block text-sm font-medium text-navy">Fakultas *</label>
                                    <input id="faculty" type="text" name="faculty" value="{{ old('faculty') }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                    @error('faculty')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="study_program" class="mb-1.5 block text-sm font-medium text-navy">Program Studi *</label>
                                    <input id="study_program" type="text" name="study_program" value="{{ old('study_program') }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                    @error('study_program')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="semester" class="mb-1.5 block text-sm font-medium text-navy">Semester *</label>
                                    <input id="semester" type="number" name="semester" min="1" max="14" value="{{ old('semester') }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                    @error('semester')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">Kontak & Profil</legend>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="email" class="mb-1.5 block text-sm font-medium text-navy">Email *</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                    @error('email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="phone" class="mb-1.5 block text-sm font-medium text-navy">Nomor Telepon *</label>
                                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                    @error('phone')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="address" class="mb-1.5 block text-sm font-medium text-navy">Alamat *</label>
                                    <textarea id="address" name="address" rows="3" required class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">{{ old('address') }}</textarea>
                                    @error('address')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="motto" class="mb-1.5 block text-sm font-medium text-navy">Motto / Tagline</label>
                                    <input id="motto" type="text" name="motto" value="{{ old('motto') }}" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                </div>
                                <div>
                                    <label for="instagram" class="mb-1.5 block text-sm font-medium text-navy">Instagram</label>
                                    <input id="instagram" type="text" name="instagram" value="{{ old('instagram') }}" placeholder="@username" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="biography" class="mb-1.5 block text-sm font-medium text-navy">Profil Singkat</label>
                                    <textarea id="biography" name="biography" rows="4" class="w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold">{{ old('biography') }}</textarea>
                                </div>
                            </div>
                        </fieldset>

                        <label class="flex items-start gap-3 text-sm leading-relaxed text-muted">
                            <input type="checkbox" name="terms" value="1" @checked(old('terms')) required class="mt-0.5 rounded border-navy/20 text-gold focus:ring-gold">
                            <span>Saya menyatakan data yang saya isi benar, memenuhi persyaratan peserta, dan bersedia mengikuti seluruh rangkaian Pemilihan BGK {{ $year }}.</span>
                        </label>
                        @error('terms')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror

                        <button type="submit" class="btn-gold w-full justify-center sm:w-auto">
                            Kirim Pendaftaran
                            <span aria-hidden="true">→</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>

        @include('partials.registration.sidebar')
    </div>
</section>
