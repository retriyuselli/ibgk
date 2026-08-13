@php
    $org = $org ?? org_profile($profile ?? null);
    $success = session('registration_success');
    $year = $election?->year ?? now()->year;
    $inputClass = 'w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2.5 text-sm outline-none focus:border-gold';
    $fileClass = 'w-full rounded-md border border-navy/15 bg-cream/40 px-3 py-2 text-sm file:mr-3 file:rounded file:border-0 file:bg-gold file:px-3 file:py-1.5 file:text-xs file:font-semibold file:text-navy-deep';
@endphp

<section class="relative overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    <div class="site-container grid gap-10 lg:grid-cols-[1fr_320px] xl:grid-cols-[1fr_360px] xl:gap-12">
        <div>
            @if ($success)
                <div class="rounded-sm border border-gold/35 bg-white p-8 text-center shadow-sm">
                    <span class="mx-auto flex h-14 w-14 items-center justify-center rounded-full bg-gold/15 text-gold">
                        <svg class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <h2 class="mt-5 font-display text-2xl font-semibold text-navy">{{ $org->registrationCopy('success_title') }}</h2>
                    <p class="mt-3 text-sm leading-relaxed text-muted">
                        {{ $org->registrationCopy('success_intro', ['name' => $success['name']]) }}
                    </p>
                    <p class="mt-4 inline-block rounded-md bg-navy px-4 py-2 font-display text-xl font-semibold tracking-wide text-gold">
                        {{ $success['number'] }}
                    </p>
                    <p class="mt-4 text-xs text-muted">
                        {{ $org->registrationCopy('success_footnote') }}
                    </p>
                    <div class="mt-6 flex flex-wrap justify-center gap-3">
                        <a href="{{ route('election') }}" class="btn-outline-gold">{{ $org->registrationCopy('success_election_link') }}</a>
                        <a href="{{ route('home') }}" class="btn-gold">{{ $org->registrationCopy('success_home_link') }}</a>
                    </div>
                </div>
            @elseif (! $registrationOpen)
                <div class="rounded-sm border border-dashed border-navy/15 bg-white px-6 py-12 text-center shadow-sm">
                    <h2 class="font-display text-2xl font-semibold text-navy">{{ $org->registrationCopy('closed_title') }}</h2>
                    <p class="mt-3 text-sm text-muted">
                        {{ session('registration_error') ?: $org->registrationCopy('closed_description') }}
                    </p>
                    <a href="{{ route('election') }}" class="btn-gold mt-6 inline-flex">{{ $org->registrationCopy('closed_button') }}</a>
                </div>
            @else
                <div class="rounded-sm border border-navy/8 bg-white p-6 shadow-sm sm:p-8">
                    <h2 class="font-display text-2xl font-semibold text-navy">{{ $org->registrationCopy('form_title') }}</h2>
                    <div class="mt-3 h-px w-12 bg-gold"></div>
                    <p class="mt-4 text-sm text-muted">
                        {{ $org->registrationCopy('form_intro') }}
                    </p>

                    <form method="POST" action="{{ route('election.register.submit') }}" enctype="multipart/form-data" class="mt-8 space-y-6">
                        @csrf

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">{{ $org->registrationCopy('section_personal') }}</legend>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('gender_label') }} *</label>
                                    <div class="flex flex-wrap gap-4">
                                        <label class="inline-flex items-center gap-2 text-sm text-navy">
                                            <input type="radio" name="gender" value="male" @checked(old('gender') === 'male') required class="text-gold focus:ring-gold">
                                            {{ $org->registrationCopy('gender_bujang_label') }}
                                        </label>
                                        <label class="inline-flex items-center gap-2 text-sm text-navy">
                                            <input type="radio" name="gender" value="female" @checked(old('gender') === 'female') required class="text-gold focus:ring-gold">
                                            {{ $org->registrationCopy('gender_gadis_label') }}
                                        </label>
                                    </div>
                                    @error('gender')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="full_name" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_full_name') }} *</label>
                                    <input id="full_name" type="text" name="full_name" value="{{ old('full_name') }}" required class="{{ $inputClass }}">
                                    @error('full_name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="nickname" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_nickname') }} *</label>
                                    <input id="nickname" type="text" name="nickname" value="{{ old('nickname') }}" required class="{{ $inputClass }}">
                                    @error('nickname')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="religion" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_religion') }} *</label>
                                    <select id="religion" name="religion" required class="{{ $inputClass }}">
                                        <option value="">Pilih agama</option>
                                        @foreach (\App\Models\Participant::religionOptions() as $value => $label)
                                            <option value="{{ $value }}" @selected(old('religion') === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                    @error('religion')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="birth_place" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_birth_place') }} *</label>
                                    <input id="birth_place" type="text" name="birth_place" value="{{ old('birth_place') }}" required class="{{ $inputClass }}">
                                    @error('birth_place')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="birth_date" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_birth_date') }} *</label>
                                    <input id="birth_date" type="date" name="birth_date" value="{{ old('birth_date') }}" required class="{{ $inputClass }}">
                                    @error('birth_date')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="city" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_city') }} *</label>
                                    <input id="city" type="text" name="city" value="{{ old('city') }}" required class="{{ $inputClass }}">
                                    @error('city')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="photo" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_photo') }} *</label>
                                    <input id="photo" type="file" name="photo" accept="image/*" required data-compress-image class="{{ $fileClass }}">
                                    <p class="mt-1 text-xs text-muted" data-compress-status>{{ $org->registrationCopy('hint_photo') }}</p>
                                    @error('photo')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="photo_full_body" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_photo_full_body') }} *</label>
                                    <input id="photo_full_body" type="file" name="photo_full_body" accept="image/*" required data-compress-image class="{{ $fileClass }}">
                                    <p class="mt-1 text-xs text-muted" data-compress-status>{{ $org->registrationCopy('hint_photo') }}</p>
                                    @error('photo_full_body')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">{{ $org->registrationCopy('section_physical') }}</legend>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="height_cm" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_height') }} *</label>
                                    <input id="height_cm" type="number" name="height_cm" min="100" max="250" value="{{ old('height_cm') }}" required class="{{ $inputClass }}">
                                    @error('height_cm')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="weight_kg" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_weight') }} *</label>
                                    <input id="weight_kg" type="number" name="weight_kg" min="30" max="200" step="0.1" value="{{ old('weight_kg') }}" required class="{{ $inputClass }}">
                                    @error('weight_kg')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="medical_history" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_medical_history') }}</label>
                                    <textarea id="medical_history" name="medical_history" rows="3" class="{{ $inputClass }}">{{ old('medical_history') }}</textarea>
                                    <p class="mt-1 text-xs text-muted">{{ $org->registrationCopy('hint_medical') }}</p>
                                    @error('medical_history')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">{{ $org->registrationCopy('section_campus') }}</legend>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="university" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_university') }} *</label>
                                    <input id="university" type="text" name="university" value="{{ old('university') }}" required class="{{ $inputClass }}">
                                    @error('university')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="faculty" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_faculty') }} *</label>
                                    <input id="faculty" type="text" name="faculty" value="{{ old('faculty') }}" required class="{{ $inputClass }}">
                                    @error('faculty')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="study_program" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_study_program') }} *</label>
                                    <input id="study_program" type="text" name="study_program" value="{{ old('study_program') }}" required class="{{ $inputClass }}">
                                    @error('study_program')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="semester" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_semester') }} *</label>
                                    <input id="semester" type="number" name="semester" min="1" max="14" value="{{ old('semester') }}" required class="{{ $inputClass }}">
                                    @error('semester')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="gpa" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_gpa') }} *</label>
                                    <input id="gpa" type="number" name="gpa" min="0" max="4" step="0.01" value="{{ old('gpa') }}" required class="{{ $inputClass }}">
                                    @error('gpa')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">{{ $org->registrationCopy('section_contact') }}</legend>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="email" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_email') }} *</label>
                                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="email" class="{{ $inputClass }}">
                                    <p class="mt-1 text-xs text-muted">Email ini juga dipakai untuk masuk ke Dashboard Peserta dan tidak boleh dipakai dua kali.</p>
                                    @error('email')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="phone" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_phone') }} *</label>
                                    <input id="phone" type="text" name="phone" value="{{ old('phone') }}" required class="{{ $inputClass }}">
                                    @error('phone')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="emergency_phone" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_emergency_phone') }} *</label>
                                    <input id="emergency_phone" type="text" name="emergency_phone" value="{{ old('emergency_phone') }}" required class="{{ $inputClass }}">
                                    @error('emergency_phone')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="address" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_address') }} *</label>
                                    <textarea id="address" name="address" rows="3" required class="{{ $inputClass }}">{{ old('address') }}</textarea>
                                    @error('address')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <p class="mb-1.5 text-sm font-medium text-navy">{{ $org->registrationCopy('field_social') }} *</p>
                                </div>
                                <div>
                                    <label for="instagram" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_instagram') }} *</label>
                                    <input id="instagram" type="text" name="instagram" value="{{ old('instagram') }}" placeholder="@username" required class="{{ $inputClass }}">
                                    @error('instagram')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="tiktok" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_tiktok') }}</label>
                                    <input id="tiktok" type="text" name="tiktok" value="{{ old('tiktok') }}" placeholder="@username" class="{{ $inputClass }}">
                                    @error('tiktok')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="motto" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_motto') }}</label>
                                    <input id="motto" type="text" name="motto" value="{{ old('motto') }}" class="{{ $inputClass }}">
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="biography" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_biography') }}</label>
                                    <textarea id="biography" name="biography" rows="4" class="{{ $inputClass }}">{{ old('biography') }}</textarea>
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">{{ $org->registrationCopy('section_family') }}</legend>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="parent_name" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_parent_name') }} *</label>
                                    <input id="parent_name" type="text" name="parent_name" value="{{ old('parent_name') }}" required class="{{ $inputClass }}">
                                    @error('parent_name')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="parent_occupation" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_parent_occupation') }} *</label>
                                    <input id="parent_occupation" type="text" name="parent_occupation" value="{{ old('parent_occupation') }}" required class="{{ $inputClass }}">
                                    @error('parent_occupation')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div class="sm:col-span-2">
                                    <label for="parent_address" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_parent_address') }} *</label>
                                    <textarea id="parent_address" name="parent_address" rows="3" required class="{{ $inputClass }}">{{ old('parent_address') }}</textarea>
                                    @error('parent_address')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">{{ $org->registrationCopy('section_profile') }}</legend>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div class="sm:col-span-2">
                                    <label for="achievements" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_achievements') }} *</label>
                                    <textarea id="achievements" name="achievements" rows="4" required class="{{ $inputClass }}">{{ old('achievements') }}</textarea>
                                    <p class="mt-1 text-xs text-muted">{{ $org->registrationCopy('hint_achievements') }}</p>
                                    @error('achievements')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="hobbies" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_hobbies') }} *</label>
                                    <textarea id="hobbies" name="hobbies" rows="3" required class="{{ $inputClass }}">{{ old('hobbies') }}</textarea>
                                    @error('hobbies')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="talents" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_talents') }} *</label>
                                    <textarea id="talents" name="talents" rows="3" required class="{{ $inputClass }}">{{ old('talents') }}</textarea>
                                    @error('talents')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">{{ $org->registrationCopy('section_essay') }}</legend>
                            <div class="mt-4 grid gap-4">
                                <div>
                                    <label for="motivation" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_motivation') }} *</label>
                                    <textarea id="motivation" name="motivation" rows="4" required class="{{ $inputClass }}">{{ old('motivation') }}</textarea>
                                    @error('motivation')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="ibgk_opinion" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_ibgk_opinion') }} *</label>
                                    <textarea id="ibgk_opinion" name="ibgk_opinion" rows="4" required class="{{ $inputClass }}">{{ old('ibgk_opinion') }}</textarea>
                                    @error('ibgk_opinion')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                            </div>
                        </fieldset>

                        <fieldset>
                            <legend class="text-xs font-semibold tracking-[0.14em] text-gold uppercase">{{ $org->registrationCopy('section_account') }}</legend>
                            <p class="mt-3 text-xs text-muted">{{ $org->registrationCopy('hint_account') }}</p>
                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="password" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_password') }} *</label>
                                    <input id="password" type="password" name="password" required autocomplete="new-password" class="{{ $inputClass }}">
                                    @error('password')<p class="mt-1 text-xs text-rose-600">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label for="password_confirmation" class="mb-1.5 block text-sm font-medium text-navy">{{ $org->registrationCopy('field_password_confirmation') }} *</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" class="{{ $inputClass }}">
                                </div>
                            </div>
                        </fieldset>

                        <label class="flex items-start gap-3 text-sm leading-relaxed text-muted">
                            <input type="checkbox" name="terms" value="1" @checked(old('terms')) required class="mt-0.5 rounded border-navy/20 text-gold focus:ring-gold">
                            <span>{{ $org->registrationCopy('terms_text', ['year' => $year]) }}</span>
                        </label>
                        @error('terms')<p class="text-xs text-rose-600">{{ $message }}</p>@enderror

                        <button type="submit" class="btn-gold w-full justify-center sm:w-auto">
                            {{ $org->registrationCopy('submit_label') }}
                            <span aria-hidden="true">→</span>
                        </button>
                    </form>
                </div>
            @endif
        </div>

        @include('partials.registration.sidebar')
    </div>
</section>
