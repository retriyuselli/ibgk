@php
    $people = $anggota ?? collect();
@endphp
@if ($people->isNotEmpty())
    <div class="board-anggota-grid">
        @foreach ($people as $alumni)
            @include('partials.board.anggota-card', ['alumni' => $alumni])
        @endforeach
    </div>
@endif
