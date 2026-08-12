@foreach ($alumni as $person)
    <article class="overflow-hidden border border-navy/8 bg-white shadow-sm transition hover:border-gold/35">
        <div class="relative">
            {!! site_image_or_storage($person->photo, 'images/home/alumni-placeholder.jpg', $person->name, ['class' => 'aspect-[3/4] w-full object-cover']) !!}
            <span class="absolute top-2 right-2 flex h-7 w-7 items-center justify-center rounded-full bg-navy/85 text-gold backdrop-blur-sm sm:top-3 sm:right-3 sm:h-8 sm:w-8" title="{{ $person->genderShortLabel() }} ({{ $person->isGadis() ? 'Perempuan' : 'Pria' }})">
                @if ($person->isGadis())
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10" cy="10" r="5"/><path stroke-linecap="round" d="M14 14l6 6M16 20h4v-4"/></svg>
                @else
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><circle cx="10" cy="14" r="5"/><path stroke-linecap="round" d="M14 6l4-4m0 0h-4m4 0v4"/></svg>
                @endif
            </span>
        </div>
        <div class="px-3 py-3 sm:px-4 sm:py-4">
            <h4 class="text-sm font-semibold text-navy sm:text-base">{{ $person->name }}</h4>
            <p class="mt-1 line-clamp-2 text-[11px] text-muted sm:text-xs">{{ $person->university ?: '—' }}</p>
            <p class="mt-0.5 line-clamp-2 text-[11px] font-medium text-navy/70 sm:text-xs">{{ $person->profession ?: 'Alumni IBGK' }}</p>
            <a href="{{ route('alumni.show', $person) }}" class="mt-2 inline-flex items-center gap-1 text-[10px] font-semibold tracking-[0.1em] text-gold uppercase hover:text-navy sm:mt-3 sm:text-xs sm:tracking-[0.12em]">
                Lihat Profil
                <span aria-hidden="true">→</span>
            </a>
        </div>
    </article>
@endforeach
