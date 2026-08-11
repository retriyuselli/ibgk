@php
    $variant = $variant ?? 'light';
    $density = $density ?? 'rich';
    $section = $section ?? 'default';
@endphp

<div @class(['showcase-shapes', "showcase-shapes--{$section}"]) aria-hidden="true">
    <div @class(['section-shapes', "section-shapes--{$variant}", 'auth-shapes', 'auth-shapes--rich' => $density === 'rich'])>
        <span class="shape-ring-sm shape-pos-tl"></span>
        <span class="shape-diamond shape-pos-diamond"></span>
        <span class="shape-dot shape-pos-dot-a"></span>

        @if ($density === 'rich')
            <span class="shape-ring-lg auth-shape-ring-tr"></span>
            <span class="auth-shape-orb"></span>
            <span class="auth-shape-shimmer"></span>
            <span class="shape-dot auth-shape-dot-b"></span>
        @endif
    </div>
</div>
