@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination Navigation" class="flex items-center justify-center gap-2">
        @if ($paginator->onFirstPage())
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-sm border border-navy/10 text-navy/30">←</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center rounded-sm border border-navy/15 text-navy transition hover:border-gold hover:text-gold" aria-label="Halaman sebelumnya">
                ←
            </a>
        @endif

        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-1 text-sm text-muted">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="inline-flex h-9 w-9 items-center justify-center rounded-sm bg-gold text-sm font-semibold text-navy-deep" aria-current="page">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}" class="inline-flex h-9 w-9 items-center justify-center rounded-sm border border-navy/15 text-sm font-medium text-navy transition hover:border-gold hover:text-gold">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" class="inline-flex h-9 w-9 items-center justify-center rounded-sm border border-navy/15 text-navy transition hover:border-gold hover:text-gold" aria-label="Halaman berikutnya">
                →
            </a>
        @else
            <span class="inline-flex h-9 w-9 items-center justify-center rounded-sm border border-navy/10 text-navy/30">→</span>
        @endif
    </nav>
@endif
