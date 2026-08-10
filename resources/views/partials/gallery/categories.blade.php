@php
    $icons = [
        '' => 'grid',
        'pemilihan-bgk' => 'crown',
        'kegiatan' => 'flag',
        'kegiatan-sosial' => 'heart',
        'budaya-pariwisata' => 'building',
        'internal-ibgk' => 'users',
        'event-kolaborasi' => 'spark',
    ];

    $queryParams = array_filter([
        'q' => $search ?: null,
        'urut' => $sort !== 'terbaru' ? $sort : null,
        'semua' => $showAll ? 1 : null,
    ]);
@endphp

<section class="bg-cream py-8 sm:py-10">
    <div class="site-container">
        <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-4 xl:grid-cols-7">
            @foreach ($categories as $category)
                @php $icon = $icons[$category['slug']] ?? 'grid'; @endphp
                <a
                    href="{{ route('gallery', array_merge($queryParams, ['kategori' => $category['slug'] ?: null])) }}"
                    @class([
                        'group rounded-sm border px-3 py-4 text-center transition',
                        $selectedCategory['slug'] === $category['slug']
                            ? 'border-gold/50 bg-cream-muted shadow-sm'
                            : 'border-navy/8 bg-white hover:border-gold/35 hover:shadow-sm',
                    ])
                >
                    <span class="mx-auto flex h-10 w-10 items-center justify-center text-gold">
                        @switch($icon)
                            @case('crown')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 19h14M7 19V9l5 3 5-3v10M9 9l3-5 3 5"/></svg>
                                @break
                            @case('flag')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 21V4m0 0h10l-1.5 3L16 10H4"/></svg>
                                @break
                            @case('heart')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.5-7-10a4 4 0 017-4 4 4 0 017 4c0 5.5-7 10-7 10z"/></svg>
                                @break
                            @case('building')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8l7-4 7 4v13"/></svg>
                                @break
                            @case('users')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/></svg>
                                @break
                            @case('spark')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v4m0 10v4M3 12h4m10 0h4"/></svg>
                                @break
                            @default
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 5h16v14H4zM8 5V3h8v2"/></svg>
                        @endswitch
                    </span>
                    <p class="mt-3 text-[11px] font-semibold tracking-[0.08em] text-navy uppercase">{{ $category['name'] }}</p>
                    <p class="mt-1 text-[11px] text-muted">{{ $category['count'] }} Album</p>
                </a>
            @endforeach
        </div>
    </div>
</section>
