@php
    use App\Models\AlumniBatch;

    $hero = $cmsPages->hero('alumni', [
        'title' => 'Alumni IBGK Sumatera Selatan',
        'excerpt' => 'Keluarga besar IBGK Sumsel terdiri dari finalis Pemilihan Bujang Gadis Kampus dari berbagai perguruan tinggi di Sumatera Selatan yang terus berkarya dan berkontribusi.',
        'image' => 'images/home/about-4.jpg',
        'imageAlt' => 'Keluarga besar alumni IBGK Sumatera Selatan',
    ]);
    $alumniSinceYear = AlumniBatch::FIRST_ELECTION_YEAR;
@endphp
<section class="relative isolate overflow-hidden bg-navy text-white">
    @include('partials.site.section-shapes', ['variant' => 'dark'])
    {!! site_image_from_src($hero['image'], $hero['imageAlt'], ['class' => 'absolute inset-0 h-full w-full object-cover opacity-35', 'lazy' => false]) !!}
    <div class="absolute inset-0 bg-gradient-to-r from-navy-deep via-navy-deep/90 to-navy/75"></div>

    <div class="site-container relative py-16 sm:py-20 lg:py-24">
        <nav class="hero-animate text-xs text-white/65" aria-label="Breadcrumb">
            <ol class="flex flex-wrap items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-gold">Beranda</a></li>
                <li aria-hidden="true">›</li>
                <li class="text-white/90">Alumni</li>
            </ol>
        </nav>

        <div class="hero-animate-delay mt-8 max-w-3xl">
            <h1 class="font-display text-3xl font-semibold tracking-tight text-gold sm:text-4xl lg:text-5xl">
                {{ $hero['title'] }}
            </h1>
            <p class="mt-5 max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base">
                {{ $hero['excerpt'] }}
            </p>
        </div>

        <div class="hero-animate-delay-2 mt-10 grid gap-6 sm:grid-cols-3">
            <div class="flex items-start gap-3 border border-gold/25 bg-navy-deep/50 px-4 py-4 backdrop-blur-sm">
                <span class="mt-0.5 text-gold">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" d="M17 20v-1a3 3 0 00-3-3H6a3 3 0 00-3 3v1"/><circle cx="10" cy="8" r="3"/><path d="M21 20v-1a3 3 0 00-2-2.83M16 4.13a3 3 0 010 5.74"/></svg>
                </span>
                <div>
                    <p class="font-display text-2xl font-semibold text-gold">{{ number_format($totalAlumni) }}</p>
                    <p class="text-xs font-semibold tracking-[0.12em] text-white uppercase">Finalis</p>
                    <p class="mt-1 text-[11px] leading-relaxed text-white/60">Tercatat sebagai anggota IBGK Sumsel {{ $alumniSinceYear }}–sekarang</p>
                </div>
            </div>
            <div class="flex items-start gap-3 border border-gold/25 bg-navy-deep/50 px-4 py-4 backdrop-blur-sm">
                <span class="mt-0.5 text-gold">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M5 21V8l7-4 7 4v13M9 21v-6h6v6"/></svg>
                </span>
                <div>
                    <p class="font-display text-2xl font-semibold text-gold">{{ $batchCount }}</p>
                    <p class="text-xs font-semibold tracking-[0.12em] text-white uppercase">Angkatan</p>
                    <p class="mt-1 text-[11px] leading-relaxed text-white/60">Periode Pemilihan BGK Sumsel {{ $alumniSinceYear }}–sekarang</p>
                </div>
            </div>
            <a href="{{ route('alumni', ['angkatan' => \App\Models\HonoraryMember::DIRECTORY_SLUG]) }}" class="flex items-start gap-3 border border-gold/25 bg-navy-deep/50 px-4 py-4 backdrop-blur-sm transition hover:border-gold/50">
                <span class="mt-0.5 text-gold">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11.48 3.5l1.76 3.56 3.93.57-2.84 2.77.67 3.91-3.52-1.85-3.52 1.85.67-3.91-2.84-2.77 3.93-.57L11.48 3.5z"/></svg>
                </span>
                <div>
                    <p class="font-display text-2xl font-semibold text-gold">{{ $honoraryCount }}</p>
                    <p class="text-xs font-semibold tracking-[0.12em] text-white uppercase">Anggota Kehormatan</p>
                    <p class="mt-1 text-[11px] leading-relaxed text-white/60">Telah berjasa dan berkontribusi bagi IBGK Sumsel</p>
                </div>
            </a>
        </div>
    </div>
</section>
