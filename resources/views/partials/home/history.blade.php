@php
    use App\Models\AlumniBatch;

    $milestones = [
        ['year' => '1999', 'title' => 'Pendirian', 'text' => 'IBGK Sumsel lahir sebagai wadah kebanggaan generasi muda kampus.'],
        ['year' => '2002', 'title' => 'Pemilihan Pertama', 'text' => 'Pemilihan Bujang Gadis Kampus Sumsel digelar untuk pertama kali.'],
        ['year' => '2003–2004', 'title' => 'Kolaborasi', 'text' => 'Memperkuat jejaring dan kolaborasi lintas instansi.'],
        ['year' => '2005', 'title' => 'Pembinaan', 'text' => 'Pembinaan dan pengawasan program semakin terstruktur.'],
        ['year' => '2006–'.(AlumniBatch::FIRST_ELECTION_YEAR + 9), 'title' => 'Penguatan', 'text' => 'Penguatan organisasi, budaya, dan kontribusi sosial.'],
        [
            'year' => AlumniBatch::FIRST_ELECTION_YEAR.'–sekarang',
            'title' => number_format(AlumniBatch::totalPublicMembersUpToCurrentYear()).' Finalis',
            'text' => 'Setiap tahun pemilihan BGK Sumsel melahirkan '.AlumniBatch::MEMBERS_PER_YEAR.' finalis, hingga total '.number_format(AlumniBatch::totalPublicMembersUpToCurrentYear()).' anggota.',
        ],
    ];
@endphp

<section id="sejarah" class="history-section relative overflow-hidden bg-navy py-16 text-white sm:py-20 lg:py-24">
    @include('partials.site.section-shapes', ['variant' => 'dark'])

    <div class="pointer-events-none absolute inset-0 z-0 opacity-[0.07]" style="background-image: radial-gradient(circle at 20% 20%, var(--color-gold) 0.8px, transparent 1px), radial-gradient(circle at 80% 60%, var(--color-gold) 0.8px, transparent 1px); background-size: 28px 28px;"></div>

    <div class="site-container relative">
        <div class="history-header history-animate mx-auto max-w-3xl text-center">
            <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Sejarah</p>
            <h2 class="section-title-light mt-3">
                Sejarah Perjalanan IBGK Sumsel
            </h2>
        </div>

        <div class="history-timeline mt-12 overflow-x-auto pb-2">
            <ol class="relative mx-auto flex min-w-[720px] justify-between gap-4 px-2 py-3 lg:min-w-0">
                <li class="history-line pointer-events-none absolute top-[2.375rem] right-6 left-6 h-px bg-gold/40" aria-hidden="true"></li>

                @foreach ($milestones as $index => $item)
                    <li
                        class="history-item history-animate relative z-10 flex w-28 flex-col items-center text-center sm:w-32"
                        style="--history-delay: {{ $index * 0.12 }}s"
                    >
                        <span class="history-icon-wrap relative z-10 flex h-[4.75rem] w-[4.75rem] shrink-0 items-center justify-center">
                            <span class="history-icon-ring pointer-events-none absolute inset-0 rounded-full border border-gold/25" aria-hidden="true"></span>
                            <span class="history-icon relative flex h-14 w-14 items-center justify-center rounded-full border border-gold/50 bg-navy-soft text-gold">
                                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6l3 2M12 21a9 9 0 100-18 9 9 0 000 18z"/>
                                </svg>
                            </span>
                        </span>
                        <p class="mt-4 font-display text-lg font-semibold text-gold">{{ $item['year'] }}</p>
                        <p class="mt-1 text-xs font-semibold tracking-wide text-white uppercase">{{ $item['title'] }}</p>
                        <p class="mt-2 text-[11px] leading-relaxed text-white/65">{{ $item['text'] }}</p>
                    </li>
                @endforeach
            </ol>
        </div>

        <div class="history-cta history-animate mt-12 text-center" style="--history-delay: 0.78s">
            <a href="{{ route('about') }}" class="btn-outline-gold">
                Lihat Sejarah Lengkap
            </a>
        </div>
    </div>
</section>
