@if (filled($partner->showcase_programs))
    @php
        $programIcons = ['users', 'mobile', 'building', 'book', 'map', 'trophy', 'campus', 'card', 'award', 'share', 'star', 'database'];
    @endphp

    <section class="showcase-programs relative overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
        <div class="pointer-events-none absolute inset-0 opacity-[0.35]" style="background-image: radial-gradient(circle at 1px 1px, #0a5c58 1px, transparent 0); background-size: 28px 28px;" aria-hidden="true"></div>

        <div class="site-container relative">
            <div class="mx-auto max-w-3xl text-center">
                <p class="text-xs font-semibold tracking-[0.2em] text-[#0a5c58] uppercase">Program Kolaborasi</p>
                <h2 class="mt-3 font-display text-3xl font-semibold text-navy sm:text-4xl">
                    12 Program Kolaborasi<br>
                    <span class="text-[#0a5c58]">{{ str($partner->name)->before(' ')->upper() }} × IBGK Sumsel</span>
                </h2>
                <div class="mt-4 h-px w-20 bg-gold mx-auto"></div>
            </div>

            <div class="showcase-programs-grid mt-12 grid content-start gap-x-3 gap-y-3 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @foreach ($partner->showcase_programs as $index => $program)
                    <article class="showcase-program-card group relative flex h-full w-full flex-col overflow-hidden rounded-sm border border-[#0a5c58]/10 bg-white p-5 shadow-sm transition duration-300 hover:-translate-y-1 hover:border-gold/45 hover:shadow-lg">
                        <div class="absolute top-0 right-0 h-16 w-16 translate-x-6 -translate-y-6 rounded-full bg-[#0a5c58]/6 transition group-hover:bg-gold/10" aria-hidden="true"></div>

                        <div class="relative flex items-start gap-3">
                            <span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-full bg-[#0a5c58]/10 text-[#0a5c58]">
                                @include('partials.partnership.showcase.icons', ['name' => $program['icon'] ?? $programIcons[$index] ?? 'default', 'class' => 'h-5 w-5'])
                            </span>
                            <span class="font-display text-2xl font-semibold leading-none text-gold/80">
                                {{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}
                            </span>
                        </div>

                        <h3 class="relative mt-4 text-sm font-semibold leading-snug text-navy">
                            {{ $program['title'] ?? 'Program' }}
                        </h3>
                        <p class="relative mt-2 flex-1 text-xs leading-relaxed text-muted">
                            {{ $program['description'] ?? '' }}
                        </p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
