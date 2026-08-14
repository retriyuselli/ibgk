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
        'board-member-card flex items-center gap-3 rounded-lg border border-navy/8 bg-white p-3 shadow-sm sm:gap-4 sm:p-4',
        'group transition hover:border-gold/35 hover:shadow-md focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-gold' => (bool) $alumniUrl,
    ])
>
    <div class="h-24 w-16 shrink-0 overflow-hidden rounded-md bg-cream sm:h-[6.5rem] sm:w-[4.5rem]">
        {!! site_image_or_storage($alumni->photo, 'images/home/alumni-placeholder.jpg', $alumni->displayName(), ['class' => 'h-full w-full object-cover']) !!}
    </div>
    <div class="min-w-0">
        <p class="text-[10px] font-semibold tracking-[0.14em] text-gold uppercase sm:text-xs">Anggota</p>
        <p @class(['mt-1 font-semibold text-navy sm:text-base', 'transition group-hover:text-gold' => (bool) $alumniUrl])>{{ $alumni->displayName() }}</p>
        <p class="mt-1 text-[11px] leading-relaxed text-muted sm:text-xs">{{ $subtitle }}</p>
        @if ($university !== '')
            <p class="mt-0.5 text-[11px] text-navy/70 sm:text-xs">{{ $university }}</p>
        @endif
    </div>
</{{ $tag }}>
