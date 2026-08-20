@foreach ($alumni as $person)
    @php
        $roleLabel = $person->titleCase($person->profession)
            ?: ($person->titleCase($person->university) ?: 'Alumni IBGK');
    @endphp
    <a
        href="{{ route('alumni.show', $person) }}"
        aria-label="Lihat profil {{ $person->displayName() }}"
        class="alumni-profile-card group relative block overflow-hidden rounded-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold"
    >
        {!! site_image_or_storage($person->photo, 'images/home/alumni-placeholder.jpg', $person->displayName(), ['class' => 'aspect-[3/4] w-full object-cover transition duration-500 group-hover:scale-[1.04]']) !!}

        <div class="alumni-profile-card__overlay">
            <div class="min-w-0 pr-2">
                <h4 class="truncate text-xs font-semibold text-white sm:text-sm">{{ $person->displayName() }}</h4>
                @if ($isSearching ?? false)
                    <p class="mt-0.5 truncate text-[10px] font-semibold tracking-wide text-gold sm:text-[11px]">{{ $person->alumniBatch?->name }}</p>
                @endif
                <p class="mt-0.5 truncate text-[11px] text-white/80 sm:text-xs">{{ $roleLabel }}</p>
            </div>
            <span class="alumni-profile-card__action" aria-hidden="true">
                @if (filled($person->instagramUrl()))
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="0.8" fill="currentColor" stroke="none"/></svg>
                @else
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14m0 0-5-5m5 5-5 5"/></svg>
                @endif
            </span>
        </div>
    </a>
@endforeach
