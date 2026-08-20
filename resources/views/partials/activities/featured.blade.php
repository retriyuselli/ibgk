<section class="relative overflow-hidden bg-white py-14 sm:py-16 lg:py-20">
    <div class="site-container">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <h2 class="section-title">Program & Kegiatan Unggulan</h2>
                <div class="mt-3 h-px w-16 bg-gold"></div>
            </div>

            <form method="GET" action="{{ route('activities') }}" class="sm:w-56">
                <label class="sr-only" for="kategori">Kategori</label>
                <select
                    id="kategori"
                    name="kategori"
                    class="w-full rounded-md border border-navy/15 bg-cream py-2.5 pr-8 pl-3 text-sm font-medium text-navy outline-none transition focus:border-gold"
                    onchange="this.form.submit()"
                >
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->slug }}" @selected($selectedCategory?->id === $category->id)>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if ($featuredActivities->isNotEmpty())
            <div id="activities-grid" class="mt-10 grid gap-5 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">
                @include('partials.activities.card-items', [
                    'featuredActivities' => $featuredActivities,
                    'placeholderOffset' => ($featuredActivities->currentPage() - 1) * $featuredActivities->perPage(),
                ])
            </div>

            @if ($featuredActivities->hasMorePages())
                <div class="mt-10 text-center" id="activities-load-more-wrap">
                    <button
                        type="button"
                        id="activities-load-more"
                        class="btn-outline-gold min-w-44"
                        data-next-page="{{ $featuredActivities->currentPage() + 1 }}"
                    >
                        More
                        <span aria-hidden="true">→</span>
                    </button>
                </div>
            @endif
        @else
            <div class="mt-10 border border-dashed border-navy/15 bg-cream/50 px-6 py-12 text-center">
                <p class="font-display text-xl text-navy">Belum ada kegiatan pada filter ini</p>
                <p class="mt-2 text-sm text-muted">Silakan pilih kategori lain atau kembali ke semua kategori.</p>
            </div>
        @endif
    </div>
</section>
