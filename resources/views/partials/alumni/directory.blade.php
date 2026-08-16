<section class="relative bg-cream py-14 sm:py-16 lg:py-20 overflow-hidden">
    @php
        $isHonorary = $isHonorary ?? false;
    @endphp
    <div class="site-container">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
            <div class="max-w-xl">
                <h2 class="section-title">Keluarga Besar Alumni</h2>
                <p class="mt-3 text-sm text-muted sm:text-base">
                    Jelajahi alumni berdasarkan angkatan, pendiri, anggota kehormatan, nama, perguruan tinggi, atau profesi.
                </p>
            </div>

            <form method="GET" action="{{ route('alumni') }}" class="flex w-full flex-col gap-3 sm:flex-row sm:items-center lg:w-auto">
                @if ($isHonorary)
                    <input type="hidden" name="angkatan" value="{{ \App\Models\HonoraryMember::DIRECTORY_SLUG }}">
                @elseif ($selectedBatch)
                    <input type="hidden" name="angkatan" value="{{ $selectedBatch->slug }}">
                    <input type="hidden" name="halaman" value="{{ $sidebarPage }}">
                @endif

                <label class="relative block min-w-0 flex-1 lg:w-72">
                    <span class="sr-only">Cari alumni</span>
                    <span class="pointer-events-none absolute inset-y-0 left-3 flex items-center text-muted">
                        <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.3-4.3M11 18a7 7 0 100-14 7 7 0 000 14z"/></svg>
                    </span>
                    <input
                        type="search"
                        name="q"
                        value="{{ $search }}"
                        placeholder="Cari nama, kampus, profesi..."
                        class="w-full rounded-md border border-navy/15 bg-white py-2.5 pr-3 pl-10 text-sm text-navy outline-none transition focus:border-gold"
                    >
                </label>

                <label class="relative">
                    <span class="sr-only">Filter gender</span>
                    <select
                        name="gender"
                        class="w-full appearance-none rounded-md border border-navy/15 bg-white py-2.5 pr-10 pl-3 text-sm font-medium text-navy outline-none transition focus:border-gold sm:w-36"
                        onchange="this.form.submit()"
                    >
                        <option value="">Filter</option>
                        <option value="bujang" @selected(in_array($gender, ['bujang', 'male'], true))>Bujang</option>
                        <option value="gadis" @selected(in_array($gender, ['gadis', 'female'], true))>Gadis</option>
                    </select>
                </label>

                <button type="submit" class="btn-gold-sm whitespace-nowrap">
                    Cari
                </button>
            </form>
        </div>

        <div class="mt-10 grid gap-8 lg:grid-cols-[0.85fr_2.15fr] lg:gap-10">
            @include('partials.alumni.sidebar')
            @include('partials.alumni.grid')
        </div>

        @include('partials.alumni.privacy')
    </div>
</section>
