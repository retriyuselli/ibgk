@if (filled($partner->showcase_program_quote))
    <section class="showcase-program-quote showcase-section relative overflow-hidden bg-white py-8 sm:py-10">
        @include('partials.partnership.showcase.shapes', ['variant' => 'light', 'density' => 'default', 'section' => 'quote'])

        <div class="site-container relative z-10">
            <blockquote class="showcase-program-quote__box relative overflow-hidden rounded-sm border border-gold/35 bg-gradient-to-r from-gold/15 via-cream to-gold/10 px-6 py-6 sm:px-8 sm:py-7">
                <span class="pointer-events-none absolute top-3 left-4 font-display text-5xl leading-none text-gold/40" aria-hidden="true">“</span>
                <p class="relative pl-6 font-display text-base leading-relaxed text-navy italic sm:pl-8 sm:text-lg">
                    {{ $partner->showcase_program_quote }}
                </p>
            </blockquote>
        </div>
    </section>
@endif
