@if (filled($partner->showcase_timeline))
    <section class="showcase-timeline relative overflow-hidden bg-[#0a5c58] py-16 text-white sm:py-20">
        @include('partials.site.section-shapes', ['variant' => 'dark'])

        <div class="site-container relative">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Perjalanan Kolaborasi</p>
                <h2 class="mt-3 font-display text-3xl font-semibold text-white sm:text-4xl">
                    {{ str($partner->name)->before(' ')->upper() }} × IBGK Sumsel
                </h2>
                <div class="ornament-divider mt-4">
                    <svg class="h-3.5 w-3.5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                        <path d="M12 2l1.8 5.5L20 9.2l-4.5 3.5L17 19l-5-3.2L7 19l1.5-6.3L4 9.2l6.2-1.7L12 2z"/>
                    </svg>
                </div>
            </div>

            <div class="mt-12 overflow-x-auto pb-3">
                <ol class="mx-auto flex min-w-[920px] items-start justify-between gap-3 px-1 lg:min-w-0">
                    @foreach ($partner->showcase_timeline as $index => $step)
                        <li class="showcase-timeline-step relative flex w-[10.5rem] flex-col items-center text-center sm:w-44">
                            @if (! $loop->last)
                                <span class="pointer-events-none absolute top-[2.4rem] left-[calc(50%+2.1rem)] hidden h-px w-[calc(100%-0.75rem)] bg-gold/45 sm:block" aria-hidden="true"></span>
                                <span class="pointer-events-none absolute top-[2.15rem] left-[calc(100%-0.2rem)] hidden text-gold/80 sm:block" aria-hidden="true">›</span>
                            @endif

                            <span class="relative flex h-[4.75rem] w-[4.75rem] items-center justify-center">
                                <span class="absolute inset-0 rounded-full border border-gold/30" aria-hidden="true"></span>
                                <span class="relative flex h-14 w-14 items-center justify-center rounded-full border-2 border-gold bg-[#064945] text-gold">
                                    <span class="absolute -top-1 -right-1 flex h-5 w-5 items-center justify-center rounded-full bg-gold text-[10px] font-bold text-navy-deep">
                                        {{ $index + 1 }}
                                    </span>
                                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3M12 3a9 9 0 100 18 9 9 0 000-18z"/>
                                    </svg>
                                </span>
                            </span>

                            <h3 class="mt-4 text-[11px] font-semibold tracking-[0.1em] text-gold uppercase sm:text-xs">
                                {{ $step['title'] ?? 'Tahap' }}
                            </h3>
                            <p class="mt-2 text-[11px] leading-relaxed text-white/75">
                                {{ $step['description'] ?? '' }}
                            </p>
                        </li>
                    @endforeach
                </ol>
            </div>
        </div>
    </section>
@endif
