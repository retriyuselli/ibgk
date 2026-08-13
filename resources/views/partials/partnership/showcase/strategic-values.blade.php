@if (filled($partner->showcase_strategic_values))
    @php
        $defaultIcons = ['users', 'chart', 'book', 'megaphone', 'handshake', 'star'];
    @endphp

    <section class="showcase-strategic showcase-section relative overflow-hidden bg-white pb-16 pt-4 sm:pb-20">
        @include('partials.partnership.showcase.shapes', ['variant' => 'light', 'density' => 'default', 'section' => 'strategic'])

        <div class="site-container relative z-10">
            <div class="mx-auto max-w-4xl text-center">
                <div class="flex items-center justify-center gap-3">
                    <span class="h-px w-10 bg-gold/70 sm:w-16" aria-hidden="true"></span>
                    <span class="h-2 w-2 rounded-full bg-gold" aria-hidden="true"></span>
                    <h2 class="font-display text-lg font-bold text-showcase sm:text-xl lg:text-2xl">
                        {{ org_profile($profile)->showcaseCopy('strategic_heading', ['partner' => $partner->showcaseShortName()]) }}
                    </h2>
                    <span class="h-2 w-2 rounded-full bg-gold" aria-hidden="true"></span>
                    <span class="h-px w-10 bg-gold/70 sm:w-16" aria-hidden="true"></span>
                </div>
            </div>

            <ul class="mx-auto mt-12 grid max-w-6xl gap-8 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 xl:gap-6">
                @foreach ($partner->showcase_strategic_values as $index => $value)
                    @php
                        $title = is_array($value) ? ($value['title'] ?? '') : $value;
                        $description = is_array($value) ? ($value['description'] ?? $value['text'] ?? '') : '';
                        $icon = is_array($value) ? ($value['icon'] ?? $defaultIcons[$index] ?? 'default') : ($defaultIcons[$index] ?? 'default');
                    @endphp
                    <li class="text-center">
                        <span class="mx-auto flex h-[4.5rem] w-[4.5rem] items-center justify-center rounded-full bg-showcase text-white shadow-md shadow-showcase-soft">
                            @include('partials.partnership.showcase.icons', ['name' => $icon, 'class' => 'h-6 w-6'])
                        </span>
                        <h3 class="mt-4 text-xs font-bold leading-snug text-showcase uppercase">
                            {{ $title }}
                        </h3>
                        @if ($description)
                            <p class="mt-2 text-[11px] leading-relaxed text-muted">
                                {{ $description }}
                            </p>
                        @endif
                    </li>
                @endforeach
            </ul>
        </div>
    </section>
@endif
