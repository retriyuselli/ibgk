@php
    $icons = [
        'pendidikan-pengembangan-diri' => 'academic',
        'sosial-pengabdian-masyarakat' => 'users',
        'budaya-pariwisata' => 'building',
        'pemuda-kampus' => 'spark',
        'internal-ibgk' => 'flag',
    ];
@endphp

<section class="relative overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    <div class="site-container">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="section-title">Kategori Kegiatan</h2>
            <div class="ornament-divider mt-4">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
        </div>

        <div class="mt-10 flex flex-wrap justify-center gap-y-8 lg:gap-y-0 lg:divide-x lg:divide-navy/10">
            @foreach ($categories as $category)
                @php $icon = $icons[$category->slug] ?? 'flag'; @endphp
                <article class="w-full max-w-sm px-6 text-center sm:w-1/2 lg:w-56 lg:max-w-none lg:px-8">
                    <span class="mx-auto flex h-12 w-12 items-center justify-center rounded-full border border-gold/40 text-gold">
                        @switch($icon)
                            @case('academic')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z"/></svg>
                                @break
                            @case('users')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/><path d="M21 20v-1a3 3 0 00-2-2.83M16 4.13a3 3 0 010 5.74"/></svg>
                                @break
                            @case('building')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8l7-4 7 4v13M9 21v-6h6v6"/></svg>
                                @break
                            @case('spark')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3v4m0 10v4M3 12h4m10 0h4M6.3 6.3l2.8 2.8m5.8 5.8l2.8 2.8m0-11.4l-2.8 2.8M9.1 14.9l-2.8 2.8"/></svg>
                                @break
                            @default
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 21V4m0 0h10l-1.5 3L16 10H4"/></svg>
                        @endswitch
                    </span>
                    <h3 class="mt-4 text-[11px] font-semibold tracking-[0.1em] text-navy uppercase sm:text-xs">
                        {{ $category->name }}
                    </h3>
                    <p class="mt-2 text-[11px] leading-relaxed text-muted sm:text-xs">
                        {{ $category->description ?: 'Program kegiatan IBGK Sumsel pada bidang ini.' }}
                    </p>
                </article>
            @endforeach
        </div>
    </div>
</section>
