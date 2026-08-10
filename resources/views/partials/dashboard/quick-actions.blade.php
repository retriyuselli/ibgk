<section class="bg-white py-10 sm:py-12">
    <div class="site-container">
        <h2 class="font-display text-2xl font-semibold text-navy">Aksi Cepat</h2>
        <div class="mt-3 h-px w-12 bg-gold"></div>

        <div class="mt-8 grid gap-4 sm:grid-cols-2 xl:grid-cols-4">
            @if ($canAccessAdmin)
                <a href="{{ url('/admin') }}" class="dashboard-action-card group">
                    <span class="dashboard-action-icon bg-navy text-gold">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h7"/></svg>
                    </span>
                    <span>
                        <span class="block font-semibold text-navy group-hover:text-gold">Panel Admin</span>
                        <span class="mt-1 block text-xs leading-relaxed text-muted">Kelola konten, kegiatan, dan data organisasi.</span>
                    </span>
                </a>
            @endif

            <a href="{{ route('election.register') }}" class="dashboard-action-card group">
                <span class="dashboard-action-icon bg-gold/15 text-navy">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M16 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2M8.5 11a4 4 0 100-8 4 4 0 000 8zM20 8v6m3-3h-6"/></svg>
                </span>
                <span>
                    <span class="block font-semibold text-navy group-hover:text-gold">Daftar BGK</span>
                    <span class="mt-1 block text-xs leading-relaxed text-muted">Ikuti pemilihan Bujang Gadis Kampus Sumsel.</span>
                </span>
            </a>

            <a href="{{ route('home') }}" class="dashboard-action-card group">
                <span class="dashboard-action-icon bg-cream-muted text-navy">
                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>
                </span>
                <span>
                    <span class="block font-semibold text-navy group-hover:text-gold">Beranda Situs</span>
                    <span class="mt-1 block text-xs leading-relaxed text-muted">Kembali ke halaman utama IBGK Sumsel.</span>
                </span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="dashboard-action-card group text-left">
                @csrf
                <button type="submit" class="flex w-full items-start gap-4 text-left">
                    <span class="dashboard-action-icon bg-rose-50 text-rose-700">
                        <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8"><path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/></svg>
                    </span>
                    <span>
                        <span class="block font-semibold text-navy group-hover:text-gold">Keluar</span>
                        <span class="mt-1 block text-xs leading-relaxed text-muted">Akhiri sesi login Anda dengan aman.</span>
                    </span>
                </button>
            </form>
        </div>
    </div>
</section>
