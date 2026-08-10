<div class="flex min-h-32 flex-col items-center justify-center gap-3 rounded-sm border border-navy/8 bg-cream/40 px-4 py-5 text-center shadow-sm transition hover:border-gold/35 hover:shadow-md">
    @if ($partner->logoUrl())
        <img
            src="{{ $partner->logoUrl() }}"
            alt="Logo {{ $partner->name }}"
            class="max-h-14 w-full max-w-[85%] object-contain"
            loading="lazy"
        >
    @endif
    <span @class([
        'font-semibold leading-snug tracking-wide text-navy/75 uppercase',
        'text-[10px]' => $partner->logoUrl(),
        'text-[11px]' => ! $partner->logoUrl(),
    ])>{{ $partner->name }}</span>
</div>
