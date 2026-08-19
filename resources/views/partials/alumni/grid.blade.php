@php
    $isHonorary = $isHonorary ?? false;
    $isSearching = $isSearching ?? false;
    $listingTitle = $isSearching
        ? 'Hasil pencarian'
        : ($isHonorary ? 'Anggota Kehormatan' : ($selectedBatch?->name ?? 'Alumni'));
    $listingCount = ($isSearching || $isHonorary)
        ? $alumni->total()
        : ($selectedBatch?->displayMemberCount() ?? 0);
    $listingBadge = $isSearching
        ? 'Alumni'
        : ($isHonorary ? 'Anggota' : 'Finalis');
@endphp
<div>
    <div class="flex flex-wrap items-center gap-3">
        <h3 class="font-display text-2xl font-semibold text-navy">
            {{ $listingTitle }}
        </h3>
        <span class="rounded-full bg-navy px-3 py-1 text-xs font-semibold tracking-wide text-gold">
            {{ number_format($listingCount) }} {{ $listingBadge }}
        </span>
    </div>

    @if ($isSearching)
        <p class="mt-2 text-sm text-muted">
            Menampilkan alumni dari seluruh angkatan untuk “{{ $search }}”.
        </p>
    @endif

    @if (! $isSearching && ! $isHonorary && filled($selectedBatch?->photo))
        <figure class="mt-5 overflow-hidden rounded-md border border-navy/8 bg-white shadow-sm">
            {!! site_image_or_storage($selectedBatch->photo, 'images/home/alumni-placeholder.jpg', 'Foto angkatan '.$selectedBatch->name, ['class' => 'aspect-[16/9] w-full object-cover sm:aspect-[21/9]']) !!}
            @if (filled($selectedBatch->description))
                <figcaption class="border-t border-navy/8 px-4 py-3 text-sm leading-relaxed text-muted">
                    {{ $selectedBatch->description }}
                </figcaption>
            @endif
        </figure>
    @endif

    @if ($alumni->isNotEmpty())
        <div id="alumni-grid" class="mt-6 grid grid-cols-2 gap-3 sm:gap-5 xl:grid-cols-3 2xl:grid-cols-4">
            @include('partials.alumni.card-items')
        </div>

        @if ($alumni->hasMorePages())
            <div class="mt-8 text-center" id="alumni-load-more-wrap">
                <button
                    type="button"
                    id="alumni-load-more"
                    class="btn-outline-gold min-w-44"
                    data-next-page="{{ $alumni->currentPage() + 1 }}"
                >
                    Muat Lebih Banyak
                </button>
            </div>
        @endif
    @else
        <div class="mt-6 border border-dashed border-navy/15 bg-white px-6 py-12 text-center">
            @if ($isSearching)
                <p class="font-display text-xl text-navy">Tidak ada hasil</p>
                <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">
                    Tidak ditemukan alumni yang cocok dengan “{{ $search }}” di seluruh angkatan.
                </p>
            @elseif ($isHonorary)
                <p class="font-display text-xl text-navy">Data anggota kehormatan sedang dilengkapi</p>
                <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">
                    Profil publik anggota kehormatan akan tampil di sini setelah data alumni dipublikasikan.
                </p>
            @else
                <p class="font-display text-xl text-navy">Data alumni sedang dilengkapi</p>
                <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">
                    Profil publik untuk {{ $selectedBatch?->name ?? 'angkatan ini' }} belum tersedia.
                    Historis tercatat {{ number_format($selectedBatch?->displayMemberCount() ?? 0) }} finalis.
                </p>
            @endif
        </div>
    @endif
</div>
