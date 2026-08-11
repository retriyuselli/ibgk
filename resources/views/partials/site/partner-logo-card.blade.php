@php
    $href = $partner->publicLinkUrl();
    $isExternal = ! $partner->has_showcase_page && filled($partner->website);
@endphp

@if ($href)
    <a
        href="{{ $href }}"
        @if ($isExternal) target="_blank" rel="noopener noreferrer" @endif
        class="flex min-h-32 flex-col items-center justify-center gap-3 rounded-sm border border-navy/8 bg-cream/40 px-4 py-5 text-center shadow-sm transition hover:border-gold/35 hover:shadow-md"
    >
@else
    <div class="flex min-h-32 flex-col items-center justify-center gap-3 rounded-sm border border-navy/8 bg-cream/40 px-4 py-5 text-center shadow-sm transition hover:border-gold/35 hover:shadow-md">
@endif
    @if ($partner->usesOfficeIcon())
        @include('partials.partnership.showcase.partner-brand', [
            'partner' => $partner,
            'boxClass' => 'h-14 w-14 rounded-lg',
            'iconClass' => 'h-6 w-6',
        ])
    @elseif ($partner->logoUrl())
        <img
            src="{{ $partner->logoUrl() }}"
            alt="Logo {{ $partner->name }}"
            class="max-h-14 w-full max-w-[85%] object-contain"
            loading="lazy"
        >
    @endif
    <span @class([
        'font-semibold leading-snug tracking-wide text-navy/75 uppercase',
        'text-[10px]' => $partner->logoUrl() || $partner->usesOfficeIcon(),
        'text-[11px]' => ! $partner->logoUrl() && ! $partner->usesOfficeIcon(),
    ])>{{ $partner->name }}</span>
    @if ($partner->has_showcase_page)
        <span class="text-[10px] font-medium tracking-wide text-gold uppercase">Lihat Kolaborasi</span>
    @endif
@if ($href)
    </a>
@else
    </div>
@endif
