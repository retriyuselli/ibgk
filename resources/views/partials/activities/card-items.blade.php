@php
    $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];
    $formatDate = function ($date) use ($months): string {
        if (! $date) {
            return '—';
        }

        return $date->format('j').' '.$months[(int) $date->format('n')].' '.$date->format('Y');
    };
    $placeholders = [
        'images/home/about-1.jpg',
        'images/home/about-2.jpg',
        'images/home/about-3.jpg',
        'images/home/about-4.jpg',
        'images/home/news-1.jpg',
        'images/home/news-2.jpg',
        'images/home/news-3.jpg',
        'images/home/election-poster.jpg',
    ];
    $placeholderOffset = $placeholderOffset ?? 0;
@endphp

@foreach ($featuredActivities as $index => $activity)
    <article class="overflow-hidden border border-navy/8 bg-cream/40 shadow-sm transition hover:border-gold/35">
        <a href="{{ route('activities.show', $activity) }}" class="block">
            <div class="relative">
                {!! site_image_or_storage($activity->thumbnail, $placeholders[($placeholderOffset + $index) % count($placeholders)], $activity->title, ['class' => 'aspect-[4/3] w-full object-cover']) !!}
                @if ($activity->category)
                    <span class="absolute top-3 right-3 rounded bg-navy/90 px-2 py-1 text-[10px] font-semibold tracking-wide text-gold uppercase">
                        {{ \Illuminate\Support\Str::before($activity->category->name, ' &') }}
                    </span>
                @endif
            </div>
            <div class="px-4 py-4">
                <h3 class="font-semibold text-navy">{{ $activity->title }}</h3>
                <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-muted">
                    {{ $activity->excerpt ?: 'Dokumentasi program kegiatan IBGK Sumsel.' }}
                </p>
                <div class="mt-4 flex flex-wrap gap-3 text-[11px] text-muted">
                    <span class="inline-flex items-center gap-1">
                        <svg class="h-3.5 w-3.5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M6 5h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                        {{ $formatDate($activity->activity_date) }}
                    </span>
                    @if ($activity->location)
                        <span class="inline-flex items-center gap-1">
                            <svg class="h-3.5 w-3.5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.2 7-11a7 7 0 10-14 0c0 5.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                            {{ $activity->location }}
                        </span>
                    @endif
                </div>
            </div>
        </a>
    </article>
@endforeach
