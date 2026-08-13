@php
    $org = $org ?? org_profile($profile);
    $description = $election?->description ?? $org->electionCopy('description_fallback');
    $pillars = $org->electionPillars();
@endphp

<section class="election-about-section relative overflow-hidden bg-cream py-16 sm:py-20 lg:py-24">
    @include('partials.site.section-shapes', ['variant' => 'light'])

    <div class="site-container relative">
        <div class="mx-auto max-w-3xl text-center">
            <h2 class="section-title">{{ $org->electionCopy('about_title') }}</h2>
            <div class="ornament-divider mt-4">
                <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                    <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                </svg>
            </div>
        </div>

        <div class="mt-12 grid items-start gap-10 lg:grid-cols-2 lg:gap-14">
            <div>
                <div class="space-y-4 text-sm leading-relaxed text-muted sm:text-base">
                    <p>{{ $description }}</p>
                    <p>{{ $org->electionCopy('about_second_paragraph') }}</p>
                </div>

                <a href="{{ route('about') }}" class="btn-outline-gold mt-8">
                    {{ $org->electionCopy('about_link_label') }}
                    <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($pillars as $pillar)
                    <article class="border border-navy/8 bg-white px-5 py-5 shadow-sm">
                        <span class="flex h-11 w-11 items-center justify-center rounded-full border border-gold/40 text-gold">
                            @switch($pillar['icon'] ?? 'user')
                                @case('user')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M16 19v-1a3 3 0 00-3-3H7a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/></svg>
                                    @break
                                @case('building')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8l7-4 7 4v13M9 21v-6h6v6"/></svg>
                                    @break
                                @case('heart')
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4.3 12.3C2.6 10.6 2.6 7.8 4.3 6.1s4.5-1.7 6.2 0L12 7.6l1.5-1.5c1.7-1.7 4.5-1.7 6.2 0s1.7 4.5 0 6.2L12 20.5 4.3 12.3z"/></svg>
                                    @break
                                @default
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M8 21h8M12 17v4M7 4h10v5a5 5 0 01-10 0V4zm0 0H5m14 0h2"/></svg>
                            @endswitch
                        </span>
                        <h3 class="mt-4 text-sm font-semibold tracking-wide text-navy uppercase">{{ $pillar['title'] ?? '' }}</h3>
                        <p class="mt-2 text-sm leading-relaxed text-muted">{{ $pillar['text'] ?? '' }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>
