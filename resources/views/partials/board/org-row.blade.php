@php
    $rowMembers = $members ?? collect();
    $count = $rowMembers->count();
@endphp
@if ($count > 0)
    <div class="board-org-stem" aria-hidden="true"></div>
    <div @class(['board-org-officers', 'is-single' => $count === 1]) style="--board-count: {{ max($count, 1) }}">
        <div class="board-org-bar" aria-hidden="true"></div>
        @foreach ($rowMembers as $member)
            <div class="board-org-node">
                <span class="board-org-twig" aria-hidden="true"></span>
                @include('partials.board.member-card', ['member' => $member])
            </div>
        @endforeach
    </div>
@endif
