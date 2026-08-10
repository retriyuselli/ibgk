@php
    $variant = $variant ?? 'dark';
    $density = $density ?? 'default';
@endphp

<div class="section-shapes section-shapes--{{ $variant }} auth-shapes auth-shapes--{{ $density }}" aria-hidden="true">
    <span class="shape-ring-sm shape-pos-tl"></span>
    <span class="shape-diamond shape-pos-diamond"></span>
    <span class="shape-dot shape-pos-dot-a"></span>

    @if ($density === 'rich')
        <span class="shape-ring-lg auth-shape-ring-tr"></span>
        <span class="shape-orb auth-shape-orb"></span>
        <span class="shape-shimmer-line auth-shape-shimmer"></span>
        <span class="shape-dot auth-shape-dot-b"></span>
    @endif
</div>
