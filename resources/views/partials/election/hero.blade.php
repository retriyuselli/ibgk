@php
    $org = $org ?? org_profile($profile);
    $year = $election?->year ?? now()->year;
    $heroTitle = $election?->name ?? $org->electionCopy('hero_title_fallback');
    $theme = $election?->theme ?? $org->electionCopy('theme_fallback');
    $short = $election?->short_description ?? $org->electionCopy('short_description_fallback');
@endphp

<section class="relative isolate overflow-hidden bg-navy text-white">
    @include('partials.site.section-shapes', ['variant' => 'dark'])
    {!! site_image_or_storage($election?->banner, $org->electionCopy('hero_banner_fallback'), '', ['class' => 'absolute inset-0 h-full w-full object-cover opacity-40', 'lazy' => false]) !!}
    <div class="absolute inset-0 bg-gradient-to-r from-navy-deep via-navy-deep/92 to-navy/70"></div>

    <div class="site-container relative grid items-center gap-10 py-16 lg:grid-cols-[1.15fr_0.85fr] lg:gap-12 lg:py-20">
        <div class="max-w-2xl">
            <nav class="hero-animate text-xs text-white/65" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="hover:text-gold">Beranda</a></li>
                    <li aria-hidden="true">›</li>
                    <li class="text-white/90">{{ $org->electionCopy('breadcrumb_label') }}</li>
                </ol>
            </nav>

            <h1 class="hero-animate-delay mt-6 font-display text-3xl leading-[1.15] font-semibold text-balance text-gold sm:text-4xl lg:text-[2.75rem]">
                {{ $heroTitle }}
            </h1>

            <p class="hero-animate-delay mt-4 font-display text-base text-gold-light italic sm:text-lg">
                {{ $theme }}
            </p>

            <p class="hero-animate-delay-2 mt-5 text-sm leading-relaxed text-white/80 sm:text-base">
                {{ $short }}
            </p>

            <div class="hero-animate-delay-2 mt-8 flex flex-wrap gap-3">
                <a href="{{ route('election.register') }}" class="btn-gold">
                    {{ $org->electionCopy('register_button_label', ['year' => $year]) }}
                    <span aria-hidden="true">→</span>
                </a>
                @if ($guideDocument ?? null)
                    <a href="{{ route('documents.download', $guideDocument) }}" class="btn-outline-light">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/>
                        </svg>
                        {{ $org->electionCopy('download_guide_label') }}
                    </a>
                @endif
            </div>
        </div>

        <div class="hero-animate-delay-2 relative mx-auto w-full max-w-md lg:max-w-none">
            <div class="absolute -inset-3 rounded-lg border border-gold/25" aria-hidden="true"></div>
            {!! site_image_or_storage($election?->poster, $org->electionCopy('hero_poster_fallback'), $org->electionCopy('poster_alt'), ['class' => 'relative aspect-[4/5] w-full rounded-lg object-cover shadow-2xl shadow-black/40 sm:aspect-[5/6]']) !!}
        </div>
    </div>
</section>
