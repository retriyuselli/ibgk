@php
    $org = org_profile($profile);
    $orgName = $org->displayShortName();
    $orgFormalName = $org->formalName();
    $partnerShort = $partner->showcaseShortName();
    $year = $partner->showcase_year ?? now()->year;
    $hasHeroPhoto = filled($partner->hero_image) && ! str_contains((string) $partner->hero_image, 'proposal');
@endphp

<section class="showcase-hero showcase-section relative overflow-hidden bg-white pb-0">
    @include('partials.partnership.showcase.shapes', ['variant' => 'light', 'density' => 'rich', 'section' => 'hero'])
    <div class="site-container relative z-10 pt-8 pb-10 sm:pt-10 lg:pb-14">
        <nav class="mb-8 text-xs text-muted" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-showcase">Beranda</a></li>
                <li aria-hidden="true">›</li>
                <li><a href="{{ route('partnership') }}" class="hover:text-showcase">Kemitraan</a></li>
                <li aria-hidden="true">›</li>
                <li class="text-navy">{{ $partner->name }}</li>
            </ol>
        </nav>

        <div class="showcase-brand-bar mx-auto flex w-fit max-w-full items-center gap-4 sm:gap-6">
            <div class="flex min-h-12 items-center sm:min-h-14">
                @if (filled($profile?->logo))
                    <img src="{{ asset('storage/'.$profile->logo) }}" alt="{{ org_profile($profile)->displayShortName() }}" class="h-10 w-auto max-w-[9rem] object-contain sm:h-12 sm:max-w-[11rem]">
                @else
                    <span class="font-display text-base font-semibold text-navy sm:text-lg">{{ org_profile($profile)->displayShortName() }}</span>
                @endif
            </div>
            <span class="h-10 w-px shrink-0 bg-showcase/25 sm:h-12" aria-hidden="true"></span>
            <div class="flex min-h-12 items-center gap-3 sm:min-h-14">
                @if ($partner->externalWebsiteUrl())
                    <a href="{{ $partner->externalWebsiteUrl() }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3">
                        @include('partials.partnership.showcase.partner-brand', [
                            'partner' => $partner,
                            'boxClass' => 'h-11 w-11 rounded-lg sm:h-12 sm:w-12',
                            'iconClass' => 'h-5 w-5 sm:h-6 sm:w-6',
                            'showName' => true,
                        ])
                    </a>
                @else
                    @include('partials.partnership.showcase.partner-brand', [
                        'partner' => $partner,
                        'boxClass' => 'h-11 w-11 rounded-lg sm:h-12 sm:w-12',
                        'iconClass' => 'h-5 w-5 sm:h-6 sm:w-6',
                        'showName' => true,
                    ])
                @endif
            </div>
        </div>

        <div class="mt-10 grid items-center gap-10 lg:grid-cols-2 lg:gap-12 xl:gap-16">
            <div class="max-w-xl">
                <h1 class="font-display text-[1.65rem] leading-[1.15] font-bold tracking-tight text-showcase sm:text-3xl lg:text-[2rem] xl:text-[2.15rem]">
                    {{ $partnerShort }}
                    <span class="text-showcase">×</span>
                    {{ $orgFormalName }} {{ $year }}
                </h1>

                @if ($partner->tagline)
                    <p class="mt-4 text-sm font-bold tracking-[0.14em] text-gold uppercase sm:text-base">
                        {{ $partner->tagline }}
                    </p>
                @endif

                <p class="mt-5 text-sm leading-relaxed text-muted sm:text-[0.95rem]">
                    {{ $partner->showcase_intro ?: $partner->description }}
                </p>

                @if ($partner->showcase_official_title)
                    <div class="showcase-official-card mt-8 flex gap-4 rounded-lg bg-showcase p-5 text-white shadow-lg sm:p-6">
                        <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-full border-2 border-gold/70 bg-showcase-dark text-gold">
                            @include('partials.partnership.showcase.icons', ['name' => 'handshake', 'class' => 'h-6 w-6'])
                        </span>
                        <div>
                            <p class="text-xs font-bold leading-snug tracking-[0.04em] uppercase sm:text-sm">
                                {{ $partner->showcase_official_title }}
                            </p>
                            @if ($partner->showcase_official_subtext)
                                <p class="mt-2 text-xs leading-relaxed text-white/80 sm:text-sm">
                                    {{ $partner->showcase_official_subtext }}
                                </p>
                            @endif
                        </div>
                    </div>
                @endif
            </div>

            <div class="showcase-hero-visual relative mx-auto w-full max-w-lg lg:max-w-none">
                <div class="showcase-hero-visual__frame relative overflow-hidden">
                    <div class="showcase-hero-visual__bg absolute inset-0" aria-hidden="true">
                        {!! site_image_or_storage(
                            $org->showcaseHeroBackgroundStoragePath(),
                            $org->showcaseHeroBackgroundFallbackPath(),
                            $orgFormalName,
                            ['class' => 'h-full w-full object-cover opacity-[0.14] grayscale']
                        ) !!}
                    </div>

                    @if ($hasHeroPhoto && $partner->heroImageUrl())
                        <img
                            src="{{ $partner->heroImageUrl() }}"
                            alt="{{ $orgFormalName }}"
                            class="showcase-hero-visual__photo relative z-10 w-full object-cover object-top"
                        >
                    @else
                        <div class="showcase-hero-visual__placeholder relative z-10 flex min-h-[22rem] flex-col items-center justify-center px-8 text-center sm:min-h-[26rem]">
                            <span class="flex h-16 w-16 items-center justify-center rounded-full border border-showcase-20 bg-white/80 text-showcase shadow-sm">
                                <svg class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.4" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                            </span>
                            <p class="mt-4 text-sm font-semibold text-showcase">{{ $orgName }}</p>
                            <p class="mt-1 max-w-xs text-xs leading-relaxed text-muted">{{ $org->showcaseCopy('hero_placeholder_hint') }}</p>
                        </div>
                    @endif

                    <svg class="showcase-hero-visual__wave pointer-events-none absolute right-0 bottom-0 left-0 z-20 text-white" viewBox="0 0 1440 80" preserveAspectRatio="none" aria-hidden="true">
                        <path fill="currentColor" d="M0,48 C240,96 480,0 720,48 C960,96 1200,16 1440,48 L1440,80 L0,80 Z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>
