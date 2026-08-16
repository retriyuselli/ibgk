@foreach ($honoraryMembers as $member)
    <article class="group overflow-hidden border border-navy/8 bg-white shadow-sm transition hover:border-gold/35 hover:shadow-md">
        <div class="relative overflow-hidden">
            {!! site_image_or_storage($member->photo, 'images/home/alumni-placeholder.jpg', $member->displayName(), ['class' => 'aspect-[3/4] w-full object-cover transition duration-300 group-hover:scale-[1.02]']) !!}
            <span class="absolute top-2 left-3 flex h-7 w-7 items-center justify-center rounded-full bg-navy/85 text-gold backdrop-blur-sm sm:top-3 sm:left-4 sm:h-8 sm:w-8" title="Anggota Kehormatan">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4l2.1 4.3 4.7.7-3.4 3.3.8 4.7L12 14.8 7.8 17l.8-4.7-3.4-3.3 4.7-.7L12 4z"/>
                </svg>
            </span>
        </div>
        <div class="px-3 py-3 sm:px-4 sm:py-4">
            <h4 class="text-sm font-semibold text-navy sm:text-base">{{ $member->displayName() }}</h4>
            <p class="mt-1 line-clamp-2 text-[11px] text-muted sm:text-xs">{{ $member->displayTitle() }}</p>
            @if (filled($member->description))
                <p class="mt-0.5 line-clamp-2 text-[11px] font-medium text-navy/70 sm:text-xs">{{ $member->description }}</p>
            @endif
        </div>
    </article>
@endforeach
