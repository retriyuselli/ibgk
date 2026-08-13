<section class="showcase-contact-footer showcase-section relative overflow-hidden border-t border-showcase-10 bg-showcase-surface py-12 sm:py-14">
    @php
        $org = $org ?? org_profile($profile);
    @endphp
    @include('partials.partnership.showcase.shapes', ['variant' => 'light', 'density' => 'default', 'section' => 'contact'])

    <div class="site-container relative z-10">
        <div class="grid gap-10 lg:grid-cols-2 lg:items-center lg:gap-12">
            <div>
                <h2 class="text-sm font-bold tracking-[0.12em] text-showcase uppercase">{{ $org->showcaseCopy('contact_heading') }}</h2>
                <p class="mt-2 font-display text-xl font-semibold text-navy">{{ $org->formalName() }}</p>

                <ul class="mt-6 space-y-4 text-sm text-muted">
                    @if (filled($org->address))
                        <li class="flex gap-3">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-showcase-soft text-showcase">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.657 0 3-1.343 3-3S13.657 5 12 5 9 6.343 9 8s1.343 3 3 3z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-6 8-12a8 8 0 10-16 0c0 6 8 12 8 12z"/></svg>
                            </span>
                            <span class="leading-relaxed">{{ $org->address }}</span>
                        </li>
                    @endif
                    @if (filled($org->phone))
                        <li class="flex gap-3">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-showcase-soft text-showcase">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" d="M5 4h4l2 5-2.5 1.5a11 11 0 005 5L15 13l5 2v4a2 2 0 01-2 2A16 16 0 015 6a2 2 0 012-2z"/></svg>
                            </span>
                            <a href="tel:{{ preg_replace('/\s+/', '', $org->phone) }}" class="transition hover:text-showcase">{{ $org->phone }}</a>
                        </li>
                    @endif
                    @if (filled($org->email))
                        <li class="flex gap-3">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-showcase-soft text-showcase">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16v12H4z"/><path stroke-linecap="round" d="M4 7l8 6 8-6"/></svg>
                            </span>
                            <a href="mailto:{{ $org->email }}" class="transition hover:text-showcase">{{ $org->email }}</a>
                        </li>
                    @endif
                    @if (filled($org->instagram))
                        <li class="flex gap-3">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-showcase-soft text-showcase">
                                <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                            </span>
                            <a href="{{ $org->instagram }}" target="_blank" rel="noopener noreferrer" class="transition hover:text-showcase">{{ $org->instagramHandle() ?? $org->instagram }}</a>
                        </li>
                    @endif
                    @if (filled($org->website))
                        <li class="flex gap-3">
                            <span class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-showcase-soft text-showcase">
                                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M3 12h18M12 3a15 15 0 010 18M12 3a15 15 0 000 18"/></svg>
                            </span>
                            <a href="{{ $org->website }}" target="_blank" rel="noopener noreferrer" class="transition hover:text-showcase">{{ parse_url($org->website, PHP_URL_HOST) ?: $org->website }}</a>
                        </li>
                    @endif
                </ul>
            </div>

            <div class="showcase-partner-card relative overflow-hidden rounded-sm border border-showcase-12 bg-white px-8 py-10 text-center shadow-sm lg:items-end lg:text-right">
                @include('partials.partnership.showcase.shapes', ['variant' => 'light', 'density' => 'rich', 'section' => 'contact-card'])

                <div class="relative z-10 flex flex-col items-center justify-center lg:items-end">
                @if ($partner->externalWebsiteUrl())
                    <a href="{{ $partner->externalWebsiteUrl() }}" target="_blank" rel="noopener noreferrer" class="inline-flex flex-col items-center lg:items-end">
                        @include('partials.partnership.showcase.partner-brand', [
                            'partner' => $partner,
                            'boxClass' => 'h-14 w-14 rounded-lg',
                            'iconClass' => 'h-7 w-7',
                        ])
                    </a>
                @else
                    @include('partials.partnership.showcase.partner-brand', [
                        'partner' => $partner,
                        'boxClass' => 'h-14 w-14 rounded-lg',
                        'iconClass' => 'h-7 w-7',
                    ])
                @endif
                @if ($partner->showcase_partner_tagline)
                    <p class="mt-5 max-w-sm font-display text-base leading-relaxed text-showcase italic lg:ml-auto">
                        “{{ $partner->showcase_partner_tagline }}”
                    </p>
                @endif
                </div>
            </div>
        </div>
    </div>
</section>
