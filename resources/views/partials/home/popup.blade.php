@php
    $popup = $homepagePopup ?? null;
    $popupHref = $popup?->buttonHref();
@endphp

@if ($popup)
    <div
        id="home-popup"
        class="home-popup"
        hidden
        role="dialog"
        aria-modal="true"
        aria-labelledby="home-popup-title"
        data-popup-key="{{ $popup->dismissKey() }}"
    >
        <div class="home-popup-backdrop" data-home-popup-close tabindex="-1" aria-hidden="true"></div>

        <div class="home-popup-panel">
            <button
                type="button"
                class="home-popup-close"
                data-home-popup-close
                aria-label="Tutup pengumuman"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                    <path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/>
                </svg>
            </button>

            @if ($popup->imageUrl())
                <div class="home-popup-media">
                    @if ($popupHref)
                        <a href="{{ $popupHref }}">
                            <img src="{{ $popup->imageUrl() }}" alt="{{ $popup->title }}" class="home-popup-image">
                        </a>
                    @else
                        <img src="{{ $popup->imageUrl() }}" alt="{{ $popup->title }}" class="home-popup-image">
                    @endif
                </div>
            @endif

            <div class="home-popup-body">
                <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Pengumuman</p>
                <h2 id="home-popup-title" class="mt-2 font-display text-2xl font-semibold text-navy sm:text-3xl">
                    {{ $popup->title }}
                </h2>
                @if (filled($popup->body))
                    <div class="mt-3 h-px w-12 bg-gold"></div>
                    <p class="mt-4 text-sm leading-relaxed text-muted sm:text-base">
                        {{ $popup->body }}
                    </p>
                @endif

                @if ($popupHref)
                    <a href="{{ $popupHref }}" class="btn-gold mt-6 w-full justify-center">
                        {{ $popup->buttonText() }}
                        <span aria-hidden="true">→</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
@endif
