@if ($pastElections->isNotEmpty())
    @php($org = $org ?? org_profile($profile))
    <section class="relative bg-white py-14 sm:py-16">
        <div class="site-container">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                <div>
                    <h2 class="section-title">{{ $org->electionCopy('past_elections_title') }}</h2>
                    <div class="mt-3 h-px w-16 bg-gold"></div>
                </div>
            </div>

            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($pastElections as $past)
                    <article class="border border-navy/8 bg-cream/40 px-5 py-5">
                        <p class="font-display text-2xl font-semibold text-gold">{{ $past->year }}</p>
                        <h3 class="mt-2 text-sm font-semibold text-navy">{{ $past->name }}</h3>
                        @if ($past->theme)
                            <p class="mt-2 line-clamp-2 text-xs leading-relaxed text-muted">{{ $past->theme }}</p>
                        @endif
                        @if ($past->grand_final_date)
                            <p class="mt-3 text-[11px] text-muted">
                                Grand Final: {{ $past->grand_final_date->translatedFormat('d F Y') }}
                            </p>
                        @endif
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endif
