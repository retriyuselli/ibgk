@php
    $people = $anggota ?? collect();
    $label = $label ?? 'Anggota';
@endphp
@if ($people->isNotEmpty())
    <div class="relative">
        <button
            type="button"
            class="board-slide-prev absolute top-1/2 left-0 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-navy/15 bg-white text-navy shadow-sm transition hover:border-gold hover:text-gold sm:-left-1"
            aria-label="{{ $label }} sebelumnya"
        >
            ←
        </button>
        <button
            type="button"
            class="board-slide-next absolute top-1/2 right-0 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-navy/15 bg-white text-navy shadow-sm transition hover:border-gold hover:text-gold sm:-right-1"
            aria-label="{{ $label }} berikutnya"
        >
            →
        </button>

        <div class="alumni-track board-anggota-track px-8 sm:px-10" data-board-slider>
            @foreach ($people as $alumni)
                <div class="alumni-card board-slide-card">
                    @include('partials.board.anggota-card', ['alumni' => $alumni])
                </div>
            @endforeach
        </div>
    </div>
@endif
