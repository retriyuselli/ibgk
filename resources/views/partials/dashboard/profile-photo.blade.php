@php
    $photoClass = match ($size ?? 'md') {
        'sm' => 'w-20',
        'lg' => 'w-32 sm:w-36',
        default => 'w-24 sm:w-28',
    };
    $initial = strtoupper(substr($subject?->name ?? $subject?->full_name ?? 'I', 0, 1));
@endphp

@if ($subject?->photo)
    <div @class([$photoClass, 'shrink-0 overflow-hidden rounded-lg border-2 shadow-lg', $borderClass ?? 'border-gold/35'])>
        {!! site_image_or_storage($subject->photo, 'images/home/alumni-placeholder.jpg', $subject->name ?? $subject->full_name ?? 'Foto profil', ['class' => 'aspect-[3/4] w-full object-cover']) !!}
    </div>
@else
    <div @class([$photoClass, 'flex aspect-[3/4] shrink-0 items-center justify-center rounded-lg border-2 font-display text-2xl font-semibold', $borderClass ?? 'border-gold/35 bg-white/10 text-gold'])>
        {{ $initial }}
    </div>
@endif
