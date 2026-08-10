<section class="relative overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    <div class="site-container">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="section-title">Bentuk Kemitraan</h2>
            <div class="ornament-divider mt-4">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
        </div>

        <div class="mt-10 grid gap-4 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6">
            @foreach ($partnershipTypes as $type)
                <article class="flex flex-col items-center rounded-sm border border-navy/8 bg-white px-4 py-6 text-center shadow-sm transition hover:border-gold/35 hover:shadow-md">
                    <span class="flex h-11 w-11 items-center justify-center rounded-full bg-navy text-gold">
                        @switch($type['icon'])
                            @case('academic')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z"/></svg>
                                @break
                            @case('users')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/></svg>
                                @break
                            @case('megaphone')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5L6 9H3v6h3l5 4V5zm5.5 2.5a4.5 4.5 0 010 9"/></svg>
                                @break
                            @case('heart')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s-7-4.5-7-10a4 4 0 017-4 4 4 0 017 4c0 5.5-7 10-7 10z"/></svg>
                                @break
                            @case('building')
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8l7-4 7 4v13"/></svg>
                                @break
                            @default
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3 3 7-7M4 14l3 3m13-5l-3-3"/></svg>
                        @endswitch
                    </span>
                    <h3 class="mt-4 text-[11px] font-semibold tracking-[0.08em] text-navy uppercase">{{ $type['title'] }}</h3>
                    <p class="mt-2 text-[11px] leading-relaxed text-muted">{{ $type['description'] }}</p>
                </article>
            @endforeach
        </div>
    </div>
</section>
