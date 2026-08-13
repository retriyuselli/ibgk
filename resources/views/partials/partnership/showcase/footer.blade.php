@php
    $websiteHost = $partner->website ? (parse_url($partner->website, PHP_URL_HOST) ?: $partner->website) : null;
    $socialHandle = $partner->showcase_social_handle;
    $org = $org ?? org_profile($profile);
@endphp

<section class="showcase-footer-bar showcase-section relative mt-auto overflow-hidden bg-showcase text-white">
    @include('partials.partnership.showcase.shapes', ['variant' => 'dark', 'density' => 'rich', 'section' => 'footer'])
    <svg class="showcase-footer-bar__wave pointer-events-none absolute -top-[3.45rem] left-0 z-[2] w-full text-showcase sm:-top-[4.5rem]" viewBox="0 0 1440 72" preserveAspectRatio="none" aria-hidden="true">
        <path fill="currentColor" d="M0,32 C360,72 720,0 1080,32 C1260,48 1380,56 1440,60 L1440,72 L0,72 Z"/>
    </svg>

    <div class="site-container relative z-10 py-10 sm:py-12">
        <div class="grid items-center gap-8 lg:grid-cols-[1.2fr_1fr_0.8fr] lg:gap-6">
            <blockquote class="relative pl-6 sm:pl-8">
                <span class="pointer-events-none absolute top-0 left-0 font-display text-4xl leading-none text-gold sm:text-5xl" aria-hidden="true">“</span>
                <p class="text-sm leading-relaxed text-white/95 sm:text-[0.95rem]">
                    {{ $partner->showcaseFooterQuote($org) }}
                </p>
            </blockquote>

            <div class="text-center lg:border-x lg:border-white/15 lg:px-6">
                @if ($partner->externalWebsiteUrl() && $websiteHost)
                    <a href="{{ $partner->externalWebsiteUrl() }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center gap-2 text-sm font-semibold text-white transition hover:text-gold">
                        <svg class="h-4 w-4 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                            <circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M3 12h18M12 3a15 15 0 010 18M12 3a15 15 0 000 18"/>
                        </svg>
                        {{ $websiteHost }}
                    </a>
                @endif

                @if ($socialHandle)
                    <div @class(['flex items-center justify-center gap-3', $partner->externalWebsiteUrl() ? 'mt-4' : ''])>
                        <a href="https://instagram.com/{{ ltrim($socialHandle, '@') }}" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/25 text-white transition hover:border-gold hover:text-gold" aria-label="Instagram {{ $partner->name }}">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                        </a>
                        <a href="https://facebook.com/{{ ltrim($socialHandle, '@') }}" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/25 text-white transition hover:border-gold hover:text-gold" aria-label="Facebook {{ $partner->name }}">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                        <a href="https://youtube.com/@{{ ltrim($socialHandle, '@') }}" target="_blank" rel="noopener noreferrer" class="flex h-9 w-9 items-center justify-center rounded-full border border-white/25 text-white transition hover:border-gold hover:text-gold" aria-label="YouTube {{ $partner->name }}">
                            <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M23.498 6.186a3.016 3.016 0 00-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 00.502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 002.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 002.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        </a>
                    </div>
                    <p class="mt-3 text-xs text-white/75">{{ $socialHandle }}</p>
                @endif
            </div>

            <div class="flex justify-center lg:justify-end">
                @if ($partner->externalWebsiteUrl())
                    <a href="{{ $partner->externalWebsiteUrl() }}" target="_blank" rel="noopener noreferrer" class="inline-flex flex-col items-center gap-2 rounded-md bg-white px-5 py-4 text-center shadow-sm transition hover:shadow-md">
                        @include('partials.partnership.showcase.partner-brand', [
                            'partner' => $partner,
                            'boxClass' => 'h-11 w-11 rounded-lg',
                            'iconClass' => 'h-5 w-5',
                        ])
                        <span class="text-[10px] font-semibold tracking-[0.12em] text-gold uppercase">
                            {{ $partner->externalCtaLabel() }}
                        </span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</section>
