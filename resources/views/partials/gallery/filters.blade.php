@php
    $queryParams = array_filter([
        'q' => $search ?: null,
        'urut' => $sort !== 'terbaru' ? $sort : null,
        'kategori' => filled($selectedCategory['slug']) ? $selectedCategory['slug'] : null,
    ]);
@endphp

<section class="border-b border-navy/8 bg-cream py-6 sm:py-8">
    <div class="site-container">
        <form method="GET" action="{{ route('gallery') }}" class="flex flex-col gap-3 lg:flex-row lg:items-center">
            @if (filled($selectedCategory['slug']))
                <input type="hidden" name="kategori" value="{{ $selectedCategory['slug'] }}">
            @endif
            @if ($showAll)
                <input type="hidden" name="semua" value="1">
            @endif

            <div class="relative flex-1">
                <label class="sr-only" for="gallery-search">Cari foto atau album</label>
                <svg class="pointer-events-none absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-muted" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
                </svg>
                <input
                    id="gallery-search"
                    type="search"
                    name="q"
                    value="{{ $search }}"
                    placeholder="Cari foto atau album..."
                    class="w-full rounded-md border border-navy/15 bg-white py-2.5 pr-4 pl-10 text-sm text-navy outline-none transition focus:border-gold"
                >
            </div>

            <div class="flex flex-wrap gap-3">
                <select
                    name="kategori"
                    class="min-w-[10rem] rounded-md border border-navy/15 bg-white py-2.5 pr-8 pl-3 text-sm font-medium text-navy outline-none transition focus:border-gold"
                    onchange="this.form.submit()"
                >
                    @foreach ($categories as $category)
                        <option value="{{ $category['slug'] }}" @selected($selectedCategory['slug'] === $category['slug'])>
                            {{ $category['name'] }}
                        </option>
                    @endforeach
                </select>

                <select
                    name="urut"
                    class="min-w-[8rem] rounded-md border border-navy/15 bg-white py-2.5 pr-8 pl-3 text-sm font-medium text-navy outline-none transition focus:border-gold"
                    onchange="this.form.submit()"
                >
                    <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
                    <option value="terlama" @selected($sort === 'terlama')>Terlama</option>
                    <option value="a-z" @selected($sort === 'a-z')>A–Z</option>
                </select>

                <a
                    href="{{ route('gallery', array_merge($queryParams, ['semua' => 1])) }}"
                    class="btn-outline-gold px-4 py-2.5 text-xs tracking-[0.12em] uppercase"
                >
                    Lihat Semua
                </a>
            </div>
        </form>
    </div>
</section>
