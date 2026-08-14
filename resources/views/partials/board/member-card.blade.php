@php
    $size = $size ?? 'md';
    $alumniUrl = $member->alumniShowUrl();
    $tag = $alumniUrl ? 'a' : 'article';
    $position = title_case($member->position?->name) ?: $member->displayPosition();
    $division = $member->position?->isDivisionLead() ? ($member->division?->displayName() ?? '') : '';
    $subtitle = $member->displaySubtitle();
    $university = $member->displayUniversity();
@endphp
<{{ $tag }}
    @if ($alumniUrl)
        href="{{ $alumniUrl }}"
        aria-label="Lihat profil alumni {{ $member->displayName() }}"
    @endif
    @class([
        'board-member-card',
        'is-lg' => $size === 'lg',
        'is-link group' => (bool) $alumniUrl,
    ])
>
    <div class="board-member-photo">
        {!! site_image_or_storage($member->photoPath(), 'images/home/alumni-placeholder.jpg', $member->displayName(), ['class' => 'h-full w-full object-cover object-top']) !!}
    </div>
    <div class="board-member-copy">
        <p class="board-member-role" title="{{ $member->displayPosition() }}">{{ $position }}</p>
        @if ($division !== '')
            <p class="board-member-division" title="{{ $division }}">{{ $division }}</p>
        @endif
        <p @class(['board-member-name', 'transition group-hover:text-gold' => (bool) $alumniUrl]) title="{{ $member->displayName() }}">
            {{ $member->displayName() }}
        </p>
        <p class="board-member-meta" title="{{ $subtitle }}">{{ $subtitle }}</p>
        @if ($university !== '')
            <p class="board-member-campus" title="{{ $university }}">{{ $university }}</p>
        @endif
    </div>
</{{ $tag }}>
