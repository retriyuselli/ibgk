<div class="flex min-h-28 flex-col items-center justify-center gap-2.5 border border-navy/8 bg-white px-4 py-5 text-center shadow-sm transition hover:border-gold/30 hover:shadow-md">
    @if ($partner->usesOfficeIcon())
        @include('partials.partnership.showcase.partner-brand', [
            'partner' => $partner,
            'boxClass' => 'h-12 w-12 rounded-lg',
            'iconClass' => 'h-5 w-5',
        ])
    @elseif ($partner->logoUrl())
        <img
            src="{{ $partner->logoUrl() }}"
            alt="Logo {{ $partner->name }}"
            class="max-h-12 w-full max-w-[85%] object-contain"
            loading="lazy"
        >
    @endif
    <span @class([
        'font-semibold leading-snug tracking-wide text-navy/70 uppercase',
        'text-[10px]' => $partner->logoUrl() || $partner->usesOfficeIcon(),
        'text-xs' => ! $partner->logoUrl() && ! $partner->usesOfficeIcon(),
    ])>{{ $partner->name }}</span>
</div>
