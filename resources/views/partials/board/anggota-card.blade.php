@php
    $alumniUrl = filled($alumni->slug) ? route('alumni.show', $alumni) : null;
    $year = $alumni->alumniBatch?->year ?? $alumni->graduation_year;
    $subtitle = $alumni->genderLabel().' Sumatera Selatan'.($year ? ' '.$year : '');
    $university = $alumni->titleCase($alumni->university);
    $tag = $alumniUrl ? 'a' : 'article';
@endphp
<{{ $tag }}
    @if ($alumniUrl)
        href="{{ $alumniUrl }}"
        aria-label="Lihat profil alumni {{ $alumni->displayName() }}"
    @endif
    @class([
        'board-member-card',
        'is-link group' => (bool) $alumniUrl,
    ])
>
    <div class="board-member-photo">
        {!! site_image_or_storage($alumni->photo, 'images/home/alumni-placeholder.jpg', $alumni->displayName(), ['class' => 'h-full w-full object-cover object-top']) !!}
    </div>
    <div class="board-member-copy">
        <p class="board-member-role">Anggota</p>
        <p @class(['board-member-name', 'transition group-hover:text-gold' => (bool) $alumniUrl]) title="{{ $alumni->displayName() }}">
            {{ $alumni->displayName() }}
        </p>
        <p class="board-member-meta" title="{{ $subtitle }}">{{ $subtitle }}</p>
        @if ($university !== '')
            <p class="board-member-campus" title="{{ $university }}">{{ $university }}</p>
        @endif
    </div>
</{{ $tag }}>
