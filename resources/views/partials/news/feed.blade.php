@php
    $months = [
        1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
        5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
        9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
    ];

    $formatDate = function ($date) use ($months): string {
        if (! $date) {
            return '—';
        }

        return $date->format('j').' '.$months[(int) $date->format('n')].' '.$date->format('Y');
    };

    $badgeClasses = [
        'kegiatan' => 'bg-amber-100 text-amber-800',
        'pendidikan' => 'bg-sky-100 text-sky-800',
        'sosial' => 'bg-violet-100 text-violet-800',
        'budaya' => 'bg-rose-100 text-rose-800',
        'prestasi' => 'bg-emerald-100 text-emerald-800',
        'internal' => 'bg-slate-200 text-slate-700',
    ];

    $placeholders = [
        'images/home/news-1.jpg',
        'images/home/news-2.jpg',
        'images/home/news-3.jpg',
        'images/home/about-1.jpg',
        'images/home/about-2.jpg',
        'images/home/about-3.jpg',
        'images/home/election-poster.jpg',
        'images/home/sejarah-grand-final.jpg',
        'images/home/alumni-placeholder.jpg',
    ];
@endphp

<div>
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <form method="GET" action="{{ route('news') }}" class="relative w-full sm:max-w-md">
            @if ($selectedCategory)
                <input type="hidden" name="kategori" value="{{ $selectedCategory->slug }}">
            @endif
            @if ($sort !== 'terbaru')
                <input type="hidden" name="urut" value="{{ $sort }}">
            @endif
            <label class="sr-only" for="news-search">Cari berita</label>
            <input
                id="news-search"
                type="search"
                name="q"
                value="{{ $search }}"
                placeholder="Cari berita..."
                class="w-full rounded-md border border-navy/15 bg-white py-2.5 pr-10 pl-4 text-sm text-navy outline-none transition focus:border-gold"
            >
            <button type="submit" class="absolute top-1/2 right-3 -translate-y-1/2 text-muted transition hover:text-gold" aria-label="Cari">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35M10.5 18a7.5 7.5 0 100-15 7.5 7.5 0 000 15z"/>
                </svg>
            </button>
        </form>

        <form method="GET" action="{{ route('news') }}" class="sm:w-44">
            @if ($selectedCategory)
                <input type="hidden" name="kategori" value="{{ $selectedCategory->slug }}">
            @endif
            @if ($search !== '')
                <input type="hidden" name="q" value="{{ $search }}">
            @endif
            <label class="sr-only" for="news-sort">Urutkan</label>
            <select
                id="news-sort"
                name="urut"
                class="w-full rounded-md border border-navy/15 bg-white py-2.5 pr-8 pl-3 text-sm font-medium text-navy outline-none transition focus:border-gold"
                onchange="this.form.submit()"
            >
                <option value="terbaru" @selected($sort === 'terbaru')>Terbaru</option>
                <option value="terlama" @selected($sort === 'terlama')>Terlama</option>
                <option value="populer" @selected($sort === 'populer')>Populer</option>
            </select>
        </form>
    </div>

    @if ($selectedCategory || $search !== '')
        <div class="mt-4 flex flex-wrap items-center gap-2 text-xs text-muted">
            <span>Filter aktif:</span>
            @if ($selectedCategory)
                <a href="{{ route('news', array_filter(['q' => $search ?: null, 'urut' => $sort !== 'terbaru' ? $sort : null])) }}" class="rounded-full bg-white px-3 py-1 text-navy ring-1 ring-navy/10 hover:text-gold">
                    {{ $selectedCategory->name }} ×
                </a>
            @endif
            @if ($search !== '')
                <a href="{{ route('news', array_filter(['kategori' => $selectedCategory?->slug, 'urut' => $sort !== 'terbaru' ? $sort : null])) }}" class="rounded-full bg-white px-3 py-1 text-navy ring-1 ring-navy/10 hover:text-gold">
                    "{{ $search }}" ×
                </a>
            @endif
        </div>
    @endif

    @if ($news->isNotEmpty())
        <div class="mt-8 grid gap-5 sm:grid-cols-2 xl:grid-cols-3">
            @foreach ($news as $index => $item)
                @php
                    $slug = $item->category?->slug ?? 'kegiatan';
                    $badgeClass = $badgeClasses[$slug] ?? 'bg-cream-muted text-navy';
                @endphp
                <article class="overflow-hidden rounded-sm border border-navy/8 bg-white shadow-sm transition hover:border-gold/35 hover:shadow-md">
                    <a href="{{ route('news.show', $item) }}" class="block">
                    <div class="relative">
                        <img
                            src="{{ $item->thumbnail ? asset('storage/'.$item->thumbnail) : asset($placeholders[$index % count($placeholders)]) }}"
                            alt="{{ $item->title }}"
                            class="aspect-[4/3] w-full object-cover"
                        >
                        @if ($item->category)
                            <span class="absolute top-3 left-3 rounded px-2 py-1 text-[10px] font-semibold tracking-wide uppercase {{ $badgeClass }}">
                                {{ $item->category->name }}
                            </span>
                        @endif
                    </div>
                    <div class="px-4 py-4">
                        <h2 class="font-display text-base font-semibold leading-snug text-navy">
                            {{ $item->title }}
                        </h2>
                        <p class="mt-2 line-clamp-3 text-xs leading-relaxed text-muted">
                            {{ $item->excerpt ?: 'Informasi dan update terbaru dari IBGK Sumatera Selatan.' }}
                        </p>
                        <div class="mt-4 flex flex-wrap gap-3 text-[11px] text-muted">
                            <span class="inline-flex items-center gap-1">
                                <svg class="h-3.5 w-3.5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3M4 11h16M6 5h12a2 2 0 012 2v12a2 2 0 01-2 2H6a2 2 0 01-2-2V7a2 2 0 012-2z"/></svg>
                                {{ $formatDate($item->published_at) }}
                            </span>
                            @if ($item->location)
                                <span class="inline-flex items-center gap-1">
                                    <svg class="h-3.5 w-3.5 text-gold" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M12 21s7-5.2 7-11a7 7 0 10-14 0c0 5.8 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/></svg>
                                    {{ $item->location }}
                                </span>
                            @endif
                        </div>
                    </div>
                    </a>
                </article>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $news->onEachSide(1)->links('partials.news.pagination') }}
        </div>
    @else
        <div class="mt-10 border border-dashed border-navy/15 bg-white px-6 py-12 text-center">
            <p class="font-display text-xl text-navy">Berita tidak ditemukan</p>
            <p class="mt-2 text-sm text-muted">Coba kata kunci lain atau pilih kategori berbeda.</p>
            <a href="{{ route('news') }}" class="mt-5 inline-flex items-center gap-2 text-sm font-semibold text-gold hover:text-navy">
                Lihat semua berita →
            </a>
        </div>
    @endif
</div>
