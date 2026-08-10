@php
    $categoryIcons = [
        'kegiatan' => 'flag',
        'pendidikan' => 'academic',
        'sosial' => 'users',
        'budaya' => 'building',
        'prestasi' => 'star',
        'internal' => 'folder',
    ];

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

    $queryParams = array_filter([
        'q' => $search ?: null,
        'urut' => $sort !== 'terbaru' ? $sort : null,
    ]);
@endphp

<aside class="space-y-6">
    <div class="border border-navy/8 bg-white p-5 shadow-sm">
        <h2 class="font-display text-lg font-semibold text-navy">Kategori Berita</h2>
        <div class="mt-4 h-px w-10 bg-gold"></div>

        <ul class="mt-5 space-y-1">
            <li>
                <a
                    href="{{ route('news', $queryParams) }}"
                    @class([
                        'flex items-center gap-3 rounded-md px-2 py-2.5 text-sm transition',
                        ! $selectedCategory ? 'bg-cream font-semibold text-navy' : 'text-muted hover:bg-cream/70 hover:text-navy',
                    ])
                >
                    <span class="flex h-8 w-8 items-center justify-center rounded-full bg-cream text-gold">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10l6 6v10a2 2 0 01-2 2z"/></svg>
                    </span>
                    <span class="flex-1">Semua Berita</span>
                    <span class="text-xs font-semibold text-gold">{{ $totalNewsCount }}</span>
                </a>
            </li>

            @foreach ($categories as $category)
                @php $icon = $categoryIcons[$category->slug] ?? 'folder'; @endphp
                <li>
                    <a
                        href="{{ route('news', array_merge($queryParams, ['kategori' => $category->slug])) }}"
                        @class([
                            'flex items-center gap-3 rounded-md px-2 py-2.5 text-sm transition',
                            $selectedCategory?->id === $category->id ? 'bg-cream font-semibold text-navy' : 'text-muted hover:bg-cream/70 hover:text-navy',
                        ])
                    >
                        <span class="flex h-8 w-8 items-center justify-center rounded-full bg-cream text-gold">
                            @switch($icon)
                                @case('academic')
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 14l9-5-9-5-9 5 9 5zm0 0l6.16-3.42A12 12 0 0112 21a12 12 0 01-6.16-10.42L12 14z"/></svg>
                                    @break
                                @case('users')
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/></svg>
                                    @break
                                @case('building')
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8l7-4 7 4v13"/></svg>
                                    @break
                                @case('star')
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 3l2.2 4.4L19 8.2l-3.5 3.4.8 4.7L12 14.2 7.7 16.3l.8-4.7L5 8.2l4.8-.8L12 3z"/></svg>
                                    @break
                                @case('flag')
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M4 21V4m0 0h10l-1.5 3L16 10H4"/></svg>
                                    @break
                                @default
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"/></svg>
                            @endswitch
                        </span>
                        <span class="flex-1">{{ $category->name }}</span>
                        <span class="text-xs font-semibold text-gold">{{ $category->news_count }}</span>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>

    <div class="border border-navy/8 bg-white p-5 shadow-sm">
        <h2 class="font-display text-lg font-semibold text-navy">Berita Populer</h2>
        <div class="mt-4 h-px w-10 bg-gold"></div>

        <ul class="mt-5 space-y-4">
            @forelse ($popularNews as $index => $item)
                <li>
                    <a href="{{ route('news.show', $item) }}" class="flex gap-3 group">
                        {!! site_image_or_storage($item->thumbnail, 'images/home/news-'.(($index % 3) + 1).'.jpg', $item->title, ['class' => 'h-16 w-16 shrink-0 rounded-sm object-cover']) !!}
                        <div class="min-w-0">
                            <p class="line-clamp-2 text-sm font-semibold leading-snug text-navy group-hover:text-gold">
                                {{ $item->title }}
                            </p>
                            <p class="mt-1 text-[11px] text-muted">{{ $formatDate($item->published_at) }}</p>
                        </div>
                    </a>
                </li>
            @empty
                <li class="text-sm text-muted">Belum ada berita populer.</li>
            @endforelse
        </ul>
    </div>

    <div class="overflow-hidden rounded-sm bg-navy p-5 text-white shadow-sm">
        <h2 class="font-display text-lg font-semibold text-gold">Dapatkan Berita Terbaru</h2>
        <p class="mt-2 text-xs leading-relaxed text-white/75">
            Langganan newsletter untuk menerima update kegiatan, prestasi, dan informasi IBGK Sumsel langsung ke email Anda.
        </p>

        @if (session('newsletter_success'))
            <p class="mt-4 rounded-md bg-white/10 px-3 py-2 text-xs text-gold">
                {{ session('newsletter_success') }}
            </p>
        @endif

        <form method="POST" action="{{ route('news.subscribe') }}" class="mt-4 space-y-3">
            @csrf
            <label class="sr-only" for="newsletter-email">Email</label>
            <input
                id="newsletter-email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required
                placeholder="Masukkan email Anda"
                class="w-full rounded-md border border-white/15 bg-white px-3 py-2.5 text-sm text-navy outline-none placeholder:text-muted focus:border-gold"
            >
            @error('email')
                <p class="text-xs text-rose-300">{{ $message }}</p>
            @enderror
            <button type="submit" class="btn-gold w-full justify-center text-xs tracking-[0.12em] uppercase">
                Berlangganan
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
            </button>
        </form>
    </div>
</aside>
