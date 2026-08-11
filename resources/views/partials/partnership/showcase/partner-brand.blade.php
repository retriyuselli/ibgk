@props([
    'partner',
    'iconClass' => 'h-6 w-6',
    'boxClass' => 'h-12 w-12 rounded-lg',
    'showName' => false,
])

@php
    $useOfficeIcon = $partner->usesOfficeIcon();
@endphp

<div @class(['inline-flex items-center gap-3' => $showName])>
    @if (! $useOfficeIcon && $partner->logoUrl())
        <img
            src="{{ $partner->logoUrl() }}"
            alt="Logo {{ $partner->name }}"
            {{ $attributes->merge(['class' => 'object-contain']) }}
        >
    @else
        <div {{ $attributes->merge(['class' => "inline-flex shrink-0 items-center justify-center bg-banking text-gold {$boxClass}"]) }}>
            <svg @class([$iconClass]) fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M6 21V7l6-4 6 4v14"/><path stroke-linecap="round" d="M9 21v-6h6v6"/><path stroke-linecap="round" d="M10 10h4M10 14h4"/>
            </svg>
            <span class="sr-only">{{ $partner->name }}</span>
        </div>
    @endif

    @if ($showName)
        <div class="min-w-0 text-left">
            <p class="font-bold leading-none tracking-tight text-banking uppercase">{{ $partner->showcaseShortName() }}</p>
            @if (str($partner->name)->contains(' '))
                <p class="mt-1 text-[10px] font-semibold tracking-[0.14em] text-muted uppercase">{{ str($partner->name)->after(' ')->upper() }}</p>
            @endif
        </div>
    @endif
</div>
