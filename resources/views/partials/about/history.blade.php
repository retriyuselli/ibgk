@php
    $foundedLabel = '14 Agustus 1999';
    if ($profile?->founded_at) {
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $foundedLabel = $profile->founded_at->format('j').' '.$months[(int) $profile->founded_at->format('n')].' '.$profile->founded_at->format('Y');
    }
    $founder = $profile->founder ?? 'Romi Febriansyah';
    $hasDescription = filled(trim(strip_tags($profile?->description ?? '')));
@endphp

<section class="relative bg-white py-16 sm:py-20 lg:py-24 overflow-hidden">
    <div class="site-container grid items-center gap-10 lg:grid-cols-2 lg:gap-14">
        <div>
            <h2 class="section-title">Sejarah Singkat</h2>

            <div class="mt-6 space-y-4 text-sm leading-relaxed text-muted sm:text-base [&_p+p]:mt-4">
                @if ($hasDescription)
                    {!! clean_html($profile->description) !!}
                @else
                    <p>
                        Ikatan Bujang Gadis Kampus Sumatera Selatan (IBGK Sumsel) didirikan oleh
                        <span class="font-medium text-navy">{{ $founder }}</span>
                        pada tanggal <span class="font-medium text-navy">{{ $foundedLabel }}</span>.
                        Organisasi ini lahir sebagai wadah kebanggaan bagi generasi muda kampus di Sumatera Selatan.
                    </p>
                    <p>
                        {{ $profile->short_description ?? 'IBGK Sumsel menjadi pemersatu para alumni dan finalis Pemilihan Bujang Gadis Kampus Sumatera Selatan.' }}
                        Melalui pemilihan, pembinaan, dan jejaring alumni, IBGK Sumsel menumbuhkan semangat muda, berbudaya, berprestasi, dan menginspirasi.
                    </p>
                    <p>
                        Dari masa ke masa, IBGK Sumsel terus berkembang bersama mitra pemerintah, perguruan tinggi, dunia usaha, serta masyarakat dalam memperkuat kontribusi generasi muda bagi Sumatera Selatan.
                    </p>
                @endif
            </div>

            <a href="#visi-misi" class="btn-outline-gold mt-8">
                Visi & Misi IBGK Sumsel
                <span aria-hidden="true">→</span>
            </a>
        </div>

        <figure class="overflow-hidden rounded-lg shadow-md shadow-navy/10">
            {!! site_image('images/home/sejarah-grand-final.jpg', 'Grand Final BGK Sumatera Selatan', ['class' => 'aspect-[4/3] w-full object-cover']) !!}
            <figcaption class="bg-cream px-4 py-3 text-xs font-medium tracking-wide text-muted uppercase">
                Grand Final BGK
            </figcaption>
        </figure>
    </div>
</section>
