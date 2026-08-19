@extends('layouts.app')

@section('title', $batch->name.' — Alumni IBGK Sumsel')

@section('meta_description', $batch->description ?: 'Angkatan '.$batch->name.' Ikatan Bujang Gadis Kampus Sumatera Selatan.')

@section('content')
    @php
        $heroImage = filled($batch->photo)
            ? asset('storage/'.$batch->photo)
            : asset('images/home/alumni-placeholder.jpg');
        $memberCount = $batch->displayMemberCount();
        $listingBadge = $batch->isHonorary() ? 'Anggota' : 'Finalis';
    @endphp

    <section class="relative isolate overflow-hidden bg-navy text-white">
        @include('partials.site.section-shapes', ['variant' => 'dark'])
        {!! site_image_from_src($heroImage, $batch->name, ['class' => 'absolute inset-0 h-full w-full object-cover opacity-35', 'lazy' => false]) !!}
        <div class="absolute inset-0 bg-gradient-to-r from-navy-deep via-navy-deep/90 to-navy/75"></div>

        <div class="site-container relative py-16 sm:py-20 lg:py-24">
            <nav class="hero-animate text-xs text-white/65" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="hover:text-gold">Beranda</a></li>
                    <li aria-hidden="true">›</li>
                    <li><a href="{{ route('alumni') }}" class="hover:text-gold">Alumni</a></li>
                    <li aria-hidden="true">›</li>
                    <li class="text-white/90">{{ $batch->name }}</li>
                </ol>
            </nav>

            <div class="hero-animate-delay mt-8 max-w-3xl">
                <p class="text-xs font-semibold tracking-[0.2em] text-gold uppercase">Angkatan</p>
                <h1 class="mt-3 font-display text-3xl font-semibold tracking-tight text-gold sm:text-4xl lg:text-5xl">
                    {{ $batch->name }}
                </h1>
                @if (filled($batch->description))
                    <p class="mt-5 max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base">
                        {{ $batch->description }}
                    </p>
                @endif
            </div>

            <div class="hero-animate-delay-2 mt-8 flex flex-wrap items-center gap-3">
                <span class="rounded-full border border-gold/30 bg-navy-deep/50 px-4 py-1.5 text-xs font-semibold tracking-wide text-gold">
                    {{ number_format($memberCount) }} {{ $listingBadge }}
                </span>
                @if ($batch->year)
                    <span class="rounded-full border border-white/15 bg-navy-deep/50 px-4 py-1.5 text-xs font-semibold tracking-wide text-white/80">
                        Tahun {{ $batch->year }}
                    </span>
                @endif
            </div>
        </div>
    </section>

    <section class="relative bg-cream py-14 sm:py-16 lg:py-20 overflow-hidden">
        <div class="site-container">
            @if (filled($batch->photo))
                <figure class="overflow-hidden rounded-md border border-navy/8 bg-white shadow-sm">
                    {!! site_image_or_storage($batch->photo, 'images/home/alumni-placeholder.jpg', 'Foto angkatan '.$batch->name, ['class' => 'aspect-[16/9] w-full object-cover sm:aspect-[21/9]']) !!}
                </figure>
            @endif

            <div class="{{ filled($batch->photo) ? 'mt-10' : '' }} flex flex-wrap items-end justify-between gap-4">
                <div>
                    <h2 class="section-title">Finalis {{ $batch->name }}</h2>
                    <p class="mt-2 text-sm text-muted">
                        Profil publik alumni dari angkatan ini.
                    </p>
                </div>
                <a href="{{ route('alumni', ['angkatan' => $batch->slug]) }}" class="text-xs font-semibold tracking-[0.12em] text-gold uppercase hover:text-navy">
                    Lihat di direktori →
                </a>
            </div>

            @if ($alumni->isNotEmpty())
                <div class="mt-8 grid grid-cols-2 gap-3 sm:gap-5 xl:grid-cols-3 2xl:grid-cols-4">
                    @include('partials.alumni.card-items')
                </div>
            @else
                <div class="mt-8 border border-dashed border-navy/15 bg-white px-6 py-12 text-center">
                    <p class="font-display text-xl text-navy">Data alumni sedang dilengkapi</p>
                    <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-muted">
                        Profil publik untuk {{ $batch->name }} belum tersedia.
                        Historis tercatat {{ number_format($memberCount) }} {{ strtolower($listingBadge) }}.
                    </p>
                </div>
            @endif

            @if ($newerBatch || $olderBatch)
                <div class="mt-12 flex items-center justify-between gap-4">
                    @if ($newerBatch)
                        <a href="{{ route('alumni.batch', $newerBatch) }}" class="text-sm font-semibold text-navy transition hover:text-gold">
                            ← {{ $newerBatch->year }}
                        </a>
                    @else
                        <span></span>
                    @endif

                    @if ($olderBatch)
                        <a href="{{ route('alumni.batch', $olderBatch) }}" class="text-sm font-semibold text-navy transition hover:text-gold">
                            {{ $olderBatch->year }} →
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </section>

    @include('partials.alumni.cta')
@endsection
