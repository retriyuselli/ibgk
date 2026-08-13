@props([
    'partner',
    'iconClass' => 'h-6 w-6',
    'boxClass' => 'h-12 w-12 rounded-lg',
    'showName' => false,
])

@php
    $useCategoryIcon = $partner->usesCategoryIcon();
@endphp

<div @class(['inline-flex items-center gap-3' => $showName])>
    @if (! $useCategoryIcon && $partner->logoUrl())
        <img
            src="{{ $partner->logoUrl() }}"
            alt="Logo {{ $partner->name }}"
            {{ $attributes->merge(['class' => 'object-contain']) }}
        >
    @else
        <div {{ $attributes->merge(['class' => "inline-flex shrink-0 items-center justify-center bg-showcase text-gold {$boxClass}"]) }}>
            @include('partials.partnership.showcase.icons', ['name' => $partner->categoryIconName(), 'class' => $iconClass])
            <span class="sr-only">{{ $partner->name }}</span>
        </div>
    @endif

    @if ($showName)
        <div class="min-w-0 text-left">
            <p class="font-bold leading-none tracking-tight text-showcase uppercase">{{ $partner->showcaseShortName() }}</p>
        </div>
    @endif
</div>
