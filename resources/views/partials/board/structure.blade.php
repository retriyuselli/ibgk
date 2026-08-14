@php
    $officerCount = $officers->count();
    $showBidangTab = $divisionMembers->isNotEmpty();
@endphp
<section class="relative overflow-hidden bg-cream py-14 sm:py-16 lg:py-20">
    @include('partials.site.section-shapes', ['variant' => 'light'])

    <div class="site-container relative">
        <div class="board-tabs" role="tablist" aria-label="Bagian kepengurusan">
            <button
                type="button"
                class="board-tab is-active"
                id="board-tab-struktur"
                data-board-tab="struktur"
                role="tab"
                aria-selected="true"
                aria-controls="board-panel-struktur"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7h8M8 12h8M8 17h8M5 5h14a1 1 0 011 1v12a1 1 0 01-1 1H5a1 1 0 01-1-1V6a1 1 0 011-1z"/>
                </svg>
                <span>Struktur Kepengurusan</span>
            </button>

            <button
                type="button"
                class="board-tab"
                id="board-tab-pembina"
                data-board-tab="pembina"
                role="tab"
                aria-selected="false"
                aria-controls="board-panel-pembina"
            >
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4l2.1 4.3 4.7.7-3.4 3.3.8 4.7L12 14.8 7.8 17l.8-4.7-3.4-3.3 4.7-.7L12 4z"/>
                </svg>
                <span>Dewan Pembina</span>
            </button>

            @if ($showBidangTab)
                <button
                    type="button"
                    class="board-tab"
                    id="board-tab-bidang"
                    data-board-tab="bidang"
                    role="tab"
                    aria-selected="false"
                    aria-controls="board-panel-bidang"
                >
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 21v-2a4 4 0 00-4-4H7a4 4 0 00-4 4v2"/>
                        <circle cx="9" cy="7" r="3"/>
                        <path d="M23 21v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"/>
                    </svg>
                    <span>Bidang</span>
                </button>
            @endif
        </div>

        <div
            id="board-panel-struktur"
            class="mt-10 sm:mt-12"
            role="tabpanel"
            data-board-panel="struktur"
            aria-labelledby="board-tab-struktur"
        >
            @if ($hasStructure && $chair)
                <div class="board-org-chart">
                    <div class="board-org-chair">
                        @include('partials.board.member-card', ['member' => $chair, 'size' => 'lg'])
                    </div>

                    @if ($officerCount > 0)
                        <div class="board-org-stem" aria-hidden="true"></div>
                        <div class="board-org-officers" style="--board-count: {{ $officerCount }}">
                            <div class="board-org-bar" aria-hidden="true"></div>
                            @foreach ($officers as $officer)
                                <div class="board-org-node">
                                    <span class="board-org-twig" aria-hidden="true"></span>
                                    @include('partials.board.member-card', ['member' => $officer])
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if ($moreMembers->isNotEmpty())
                        <div id="board-more" class="board-org-more hidden w-full" hidden>
                            <div class="board-org-stem mx-auto" aria-hidden="true"></div>
                            <div class="grid w-full gap-4 sm:grid-cols-2 xl:grid-cols-4">
                                @foreach ($moreMembers as $member)
                                    @include('partials.board.member-card', ['member' => $member])
                                @endforeach
                            </div>
                        </div>

                        <div class="mt-8 flex justify-center">
                            <button
                                type="button"
                                id="board-more-toggle"
                                class="board-more-btn"
                                aria-expanded="false"
                                aria-controls="board-more"
                            >
                                <span data-board-more-label>Lihat Selengkapnya</span>
                                <svg class="h-4 w-4 transition-transform duration-300" data-board-more-icon fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/>
                                </svg>
                            </button>
                        </div>
                    @endif
                </div>
            @else
                <div class="rounded-lg border border-navy/10 bg-white px-6 py-14 text-center">
                    <p class="font-display text-xl font-semibold text-navy">Data kepengurusan belum tersedia</p>
                    <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">
                        Struktur pengurus periode {{ $period?->yearRange() ?? 'aktif' }} akan ditampilkan di sini setelah data diisi melalui panel admin.
                    </p>
                </div>
            @endif
        </div>

        <div
            id="board-panel-pembina"
            class="mt-10 hidden sm:mt-12"
            role="tabpanel"
            data-board-panel="pembina"
            aria-labelledby="board-tab-pembina"
            hidden
        >
            @if ($honoraryMembers->isNotEmpty())
                <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                    @foreach ($honoraryMembers as $member)
                        @include('partials.board.honorary-card', ['member' => $member])
                    @endforeach
                </div>
            @else
                <div class="rounded-lg border border-navy/10 bg-white px-6 py-14 text-center">
                    <p class="font-display text-xl font-semibold text-navy">Dewan Pembina belum tersedia</p>
                    <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">
                        Nama dewan pembina atau anggota kehormatan akan tampil di sini setelah data diisi melalui panel admin.
                    </p>
                </div>
            @endif
        </div>

        @if ($showBidangTab)
            <div
                id="board-panel-bidang"
                class="mt-10 hidden sm:mt-12"
                role="tabpanel"
                data-board-panel="bidang"
                aria-labelledby="board-tab-bidang"
                hidden
            >
                @if ($divisionMembers->count() > 4)
                    <div class="relative">
                        <button type="button" id="board-bidang-prev" class="absolute top-1/2 left-0 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-navy/15 bg-white text-navy shadow-sm transition hover:border-gold hover:text-gold sm:-left-1" aria-label="Bidang sebelumnya">
                            ←
                        </button>
                        <button type="button" id="board-bidang-next" class="absolute top-1/2 right-0 z-10 flex h-10 w-10 -translate-y-1/2 items-center justify-center rounded-full border border-navy/15 bg-white text-navy shadow-sm transition hover:border-gold hover:text-gold sm:-right-1" aria-label="Bidang berikutnya">
                            →
                        </button>
                        <div id="board-bidang-track" class="alumni-track px-10 sm:px-12">
                            @foreach ($divisionMembers as $member)
                                <div class="alumni-card w-[min(100%,17.5rem)] shrink-0">
                                    @include('partials.board.member-card', ['member' => $member])
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
                        @foreach ($divisionMembers as $member)
                            @include('partials.board.member-card', ['member' => $member])
                        @endforeach
                    </div>
                @endif
            </div>
        @endif
    </div>
</section>
