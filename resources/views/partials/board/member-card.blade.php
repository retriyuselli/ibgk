@php
    $size = $size ?? 'md';
    $photoClass = $size === 'lg' ? 'h-28 w-20 sm:h-32 sm:w-24' : 'h-24 w-16 sm:h-[6.5rem] sm:w-[4.5rem]';
@endphp
<article class="board-member-card flex items-center gap-3 rounded-lg border border-navy/8 bg-white p-3 shadow-sm sm:gap-4 sm:p-4">
    <div class="{{ $photoClass }} shrink-0 overflow-hidden rounded-md bg-cream">
        {!! site_image_or_storage($member->photoPath(), 'images/home/alumni-placeholder.jpg', $member->displayName(), ['class' => 'h-full w-full object-cover']) !!}
    </div>
    <div class="min-w-0">
        <p class="text-[10px] font-semibold tracking-[0.14em] text-gold uppercase sm:text-xs">
            {{ $member->displayPosition() }}
        </p>
        <p class="mt-1 font-semibold text-navy sm:text-base">{{ $member->displayName() }}</p>
        <p class="mt-1 text-[11px] leading-relaxed text-muted sm:text-xs">{{ $member->displaySubtitle() }}</p>
        @if ($member->displayUniversity() !== '')
            <p class="mt-0.5 text-[11px] text-navy/70 sm:text-xs">{{ $member->displayUniversity() }}</p>
        @endif
    </div>
</article>
