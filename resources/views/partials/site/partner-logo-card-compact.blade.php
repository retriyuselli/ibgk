<div class="flex min-h-28 flex-col items-center justify-center gap-2.5 border border-navy/8 bg-white px-4 py-5 text-center shadow-sm transition hover:border-gold/30 hover:shadow-md">
    @if ($partner->logoUrl())
        <img
            src="{{ $partner->logoUrl() }}"
            alt="Logo {{ $partner->name }}"
            class="max-h-12 w-full max-w-[85%] object-contain"
            loading="lazy"
        >
    @endif
    <span @class([
        'font-semibold leading-snug tracking-wide text-navy/70 uppercase',
        'text-[10px]' => $partner->logoUrl(),
        'text-xs' => ! $partner->logoUrl(),
    ])>{{ $partner->name }}</span>
</div>
