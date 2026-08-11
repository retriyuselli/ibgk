@if (filled($partner->showcase_activations))
    @php
        $activationIcons = ['users', 'mobile', 'book', 'building', 'share', 'award'];
    @endphp

    <section class="showcase-activations bg-white py-14 sm:py-16">
        <div class="site-container">
            <div class="mx-auto max-w-3xl text-center">
                <h2 class="section-title">Aktivasi Utama</h2>
                <div class="mt-3 h-px w-16 bg-gold mx-auto"></div>
            </div>

            <div class="mx-auto mt-10 grid max-w-5xl gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($partner->showcase_activations as $index => $activation)
                    <article class="flex items-start gap-4 rounded-sm border border-[#0a5c58]/10 bg-[#f4faf9] p-5">
                        <span class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-[#0a5c58] text-white">
                            @include('partials.partnership.showcase.icons', ['name' => $activation['icon'] ?? $activationIcons[$index] ?? 'default', 'class' => 'h-5 w-5'])
                        </span>
                        <div>
                            <h3 class="text-sm font-semibold text-navy">{{ $activation['title'] ?? 'Aktivasi' }}</h3>
                            @if (! empty($activation['description']))
                                <p class="mt-1 text-xs leading-relaxed text-muted">{{ $activation['description'] }}</p>
                            @endif
                        </div>
                    </article>
                @endforeach
            </div>

            @if ($partner->showcase_privacy_note)
                <div class="mx-auto mt-8 max-w-4xl rounded-sm border border-gold/35 bg-cream/60 px-5 py-4">
                    <p class="text-xs leading-relaxed text-muted sm:text-sm">
                        <span class="font-semibold text-navy">Catatan Penting:</span>
                        {{ $partner->showcase_privacy_note }}
                    </p>
                </div>
            @endif
        </div>
    </section>
@endif
