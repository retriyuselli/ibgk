@if (filled($partner->showcase_programs))
    @php
        $org = $org ?? org_profile($profile);
        $programIcons = ['users', 'mobile', 'building', 'book', 'map', 'trophy', 'campus', 'card', 'award', 'share', 'star', 'database'];
        $benefitIcons = ['users', 'mobile', 'spark', 'heart', 'chart', 'shield'];
        $year = $partner->showcase_year ?? now()->year;
    @endphp

    <section class="showcase-programs-detail showcase-section relative overflow-hidden bg-white py-14 sm:py-16 lg:py-20">
        @include('partials.partnership.showcase.shapes', ['variant' => 'light', 'density' => 'rich', 'section' => 'programs'])

        <div class="site-container relative z-10">
            <div class="showcase-programs-detail__header mx-auto max-w-4xl border-b border-showcase-10 pb-8 text-center">
                <div class="mx-auto flex w-fit max-w-full items-center gap-4 sm:gap-6">
                    @if (filled($org->logo))
                        <img src="{{ asset('storage/'.$org->logo) }}" alt="{{ $org->displayShortName() }}" class="h-9 w-auto max-w-[8rem] object-contain sm:h-10">
                    @endif
                    @include('partials.partnership.showcase.partner-brand', [
                        'partner' => $partner,
                        'boxClass' => 'h-9 w-9 rounded-md sm:h-10 sm:w-10',
                        'iconClass' => 'h-4 w-4',
                    ])
                </div>
                <h2 class="mt-6 font-display text-xl font-bold leading-tight text-showcase sm:text-2xl lg:text-[1.75rem]">
                    {{ $partner->showcaseShortName() }} × {{ $org->formalName() }} {{ $year }}
                </h2>
                <p class="mt-3 text-sm font-bold tracking-[0.12em] text-gold uppercase sm:text-base">
                    {{ $partner->showcaseProgramCountLabel($org) }}
                </p>
            </div>

            <div @class([
                'mt-10 grid gap-10',
                'xl:grid-cols-[minmax(0,1fr)_20rem] xl:gap-8 2xl:grid-cols-[minmax(0,1fr)_22rem]' => filled($partner->showcase_benefits) || ($partner->isFullShowcase() && (filled($partner->showcase_kpis) || filled($partner->showcase_targets))),
            ])>
                <div class="showcase-programs-grid grid self-start content-start gap-x-3 gap-y-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($partner->showcaseProgramsForDisplay() as $index => $program)
                        <article class="showcase-program-card flex h-full w-full flex-col rounded-sm border border-showcase-12 bg-showcase-card p-4 shadow-sm transition hover:border-gold/40 hover:shadow-md sm:p-5">
                            <div class="flex items-start justify-between gap-3">
                                <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-showcase text-white">
                                    @include('partials.partnership.showcase.icons', ['name' => $program['icon'] ?? $programIcons[$index] ?? 'default', 'class' => 'h-4 w-4'])
                                </span>
                                <span class="font-display text-xl font-bold text-gold/75">{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <h3 class="mt-3 text-xs font-bold leading-snug tracking-[0.04em] text-showcase uppercase">
                                {{ $program['title'] ?? 'Program' }}
                            </h3>
                            <p class="mt-2 flex-1 text-[11px] leading-relaxed text-muted">
                                {{ $program['description'] ?? '' }}
                            </p>
                        </article>
                    @endforeach
                </div>

                <aside class="space-y-6 xl:sticky xl:top-24 xl:self-start">
                    @if (filled($partner->showcase_benefits))
                        <div class="rounded-sm border border-showcase-15 bg-showcase p-5 text-white shadow-lg">
                            <h3 class="text-xs font-bold tracking-[0.1em] uppercase">{{ $org->showcaseCopy('benefits_heading', ['partner' => $partner->showcaseShortName()]) }}</h3>
                            <ul class="mt-4 space-y-3">
                                @foreach ($partner->showcase_benefits as $index => $benefit)
                                    <li class="flex gap-3">
                                        <span class="mt-0.5 flex h-7 w-7 shrink-0 items-center justify-center rounded-full bg-white/15 text-gold">
                                            @include('partials.partnership.showcase.icons', ['name' => $benefit['icon'] ?? $benefitIcons[$index] ?? 'default', 'class' => 'h-3.5 w-3.5'])
                                        </span>
                                        <div>
                                            <p class="text-[11px] font-bold leading-snug uppercase">{{ $benefit['title'] ?? '' }}</p>
                                            <p class="mt-1 text-[10px] leading-relaxed text-white/80">{{ $benefit['description'] ?? '' }}</p>
                                        </div>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($partner->isFullShowcase() && filled($partner->showcase_kpis))
                        <div class="rounded-sm border border-gold/30 bg-cream p-5">
                            <h3 class="text-xs font-bold tracking-[0.1em] text-showcase uppercase">{{ $org->showcaseCopy('kpi_heading') }}</h3>
                            <ul class="mt-4 space-y-3">
                                @foreach ($partner->showcaseKpisForDisplay() as $kpi)
                                    <li @class([
                                        'flex items-baseline justify-between gap-3 border-b border-navy/8 pb-3 last:border-0 last:pb-0',
                                        'border-gold/30' => ! empty($kpi['is_total']),
                                    ])>
                                        <span @class([
                                            'font-display text-xl font-bold text-showcase',
                                            'text-gold' => ! empty($kpi['is_total']),
                                        ])>{{ $kpi['value'] ?? '' }}</span>
                                        <span class="text-right text-[10px] leading-snug text-muted">{{ $kpi['label'] ?? '' }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if ($partner->isFullShowcase() && filled($partner->showcase_targets))
                        <div class="rounded-sm border border-showcase-12 bg-white p-5 shadow-sm">
                            <h3 class="text-xs font-bold tracking-[0.1em] text-showcase uppercase">{{ $org->showcaseCopy('targets_heading') }}</h3>
                            <ul class="mt-4 space-y-3">
                                @foreach ($partner->showcase_targets as $target)
                                    <li class="rounded-sm bg-showcase-surface px-3 py-3">
                                        <p class="text-[10px] font-bold text-showcase uppercase">{{ $target['label'] ?? '' }}</p>
                                        <p class="mt-1 text-sm font-semibold text-navy">{{ $target['value'] ?? '' }}</p>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </aside>
            </div>
        </div>
    </section>
@endif
