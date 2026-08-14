<article class="board-member-card flex items-center gap-3 rounded-lg border border-navy/8 bg-white p-3 shadow-sm sm:gap-4 sm:p-4">
    <div class="h-24 w-16 shrink-0 overflow-hidden rounded-md bg-cream sm:h-[6.5rem] sm:w-[4.5rem]">
        {!! site_image_or_storage($member->photo, 'images/home/alumni-placeholder.jpg', $member->displayName(), ['class' => 'h-full w-full object-cover']) !!}
    </div>
    <div class="min-w-0">
        <p class="text-[10px] font-semibold tracking-[0.14em] text-gold uppercase sm:text-xs">
            Dewan Pembina
        </p>
        <p class="mt-1 font-semibold text-navy sm:text-base">{{ $member->displayName() }}</p>
        <p class="mt-1 text-[11px] leading-relaxed text-muted sm:text-xs">{{ $member->displayTitle() }}</p>
    </div>
</article>
