@if (filled($partner->showcase_benefits))
    @php
        $benefitIcons = ['users', 'mobile', 'spark', 'heart', 'chart', 'shield'];
    @endphp

    <section class="showcase-benefits relative overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
        <div class="site-container">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-semibold tracking-[0.2em] text-[#0a5c58] uppercase">Dampak Kolaborasi</p>
                <h2 class="section-title mt-3">KPI & Manfaat untuk {{ str($partner->name)->before(' ')->upper() }}</h2>
                <div class="mt-3 h-px w-16 bg-gold mx-auto"></div>
            </div>

            <div class="mx-auto mt-10 grid max-w-5xl gap-4 sm:grid-cols-2">
                @foreach ($partner->showcase_benefits as $index => $benefit)
                    <article class="flex gap-4 rounded-sm border border-navy/8 bg-white p-5 shadow-sm">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-md bg-[#0a5c58]/10 text-[#0a5c58]">
                            @include('partials.partnership.showcase.icons', ['name' => $benefit['icon'] ?? $benefitIcons[$index] ?? 'default', 'class' => 'h-5 w-5'])
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold tracking-[0.06em] text-navy uppercase">
                                {{ $benefit['title'] ?? 'Manfaat' }}
                            </h3>
                            <p class="mt-2 text-xs leading-relaxed text-muted sm:text-sm">
                                {{ $benefit['description'] ?? '' }}
                            </p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
