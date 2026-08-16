@php
    $popup = $homepagePopup ?? null;
    $popupHref = $popup?->buttonHref();
@endphp

@if ($popup?->imageUrl())
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
            <h2 id="home-popup-title" class="sr-only">{{ $popup->title }}</h2>

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

            @if ($popupHref)
                <a href="{{ $popupHref }}" class="home-popup-media" aria-label="{{ $popup->buttonText() }}">
                    <img src="{{ $popup->imageUrl() }}" alt="{{ $popup->title }}" class="home-popup-image">
                </a>
            @else
                <div class="home-popup-media">
                    <img src="{{ $popup->imageUrl() }}" alt="{{ $popup->title }}" class="home-popup-image">
                </div>
            @endif
        </div>
    </div>
@endif
