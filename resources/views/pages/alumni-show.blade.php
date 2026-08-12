@extends('layouts.app')

@section('title', $alumni->name.' — Alumni IBGK Sumsel')

@section('meta_description', $alumni->bio ?: 'Profil alumni IBGK Sumatera Selatan.')

@section('content')
    @php
        use App\Models\AlumniBatch;
    @endphp
    <section class="alumni-show-section auth-section relative isolate min-h-[36rem] overflow-hidden bg-cream py-10 sm:py-12 lg:py-14">
        @include('partials.partnership.showcase.shapes', ['variant' => 'light', 'density' => 'rich', 'section' => 'alumni-show'])

        <div
            class="pointer-events-none absolute inset-0 z-0 opacity-[0.07]"
            style="background-image: radial-gradient(circle at 20% 20%, #0B1F3A 0.8px, transparent 1px), radial-gradient(circle at 80% 60%, #c9a227 0.8px, transparent 1px); background-size: 28px 28px;"
            aria-hidden="true"
        ></div>

        <div class="pointer-events-none absolute inset-x-0 top-0 z-0 h-40 bg-gradient-to-b from-navy/8 to-transparent" aria-hidden="true"></div>

        <div class="site-container relative z-[2] max-w-4xl">
            <nav class="hero-animate text-xs text-muted" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="transition hover:text-gold">Beranda</a></li>
                    <li aria-hidden="true">›</li>
                    <li><a href="{{ route('alumni') }}" class="transition hover:text-gold">Alumni</a></li>
                    <li aria-hidden="true">›</li>
                    <li class="text-navy">{{ $alumni->name }}</li>
                </ol>
            </nav>

            <div class="mt-8 grid gap-8 lg:grid-cols-[0.85fr_1.15fr] lg:items-start">
                <figure class="alumni-show-photo hero-animate-delay relative overflow-hidden rounded-lg border border-navy/8 bg-white shadow-sm transition duration-500 hover:-translate-y-1 hover:border-gold/30 hover:shadow-lg">
                    @include('partials.partnership.showcase.shapes', ['variant' => 'light', 'density' => 'rich', 'section' => 'alumni-photo'])

                    <div class="relative z-10">
                        {!! site_image_or_storage($alumni->photo, 'images/home/alumni-placeholder.jpg', $alumni->name, ['class' => 'aspect-[3/4] w-full object-cover transition duration-700 hover:scale-[1.02]']) !!}
                    </div>
                </figure>

                <div class="relative">
                    <div class="hero-animate-delay">
                        @if ($alumni->alumniBatch)
                            <p class="text-xs font-semibold tracking-[0.16em] text-gold uppercase">
                                {{ $alumni->alumniBatch->name }}
                            </p>
                        @endif

                        <h1 class="section-title mt-3">{{ $alumni->name }}</h1>

                        <p class="mt-2 text-sm text-muted">
                            {{ $alumni->gender === 'female' ? 'Gadis Kampus' : 'Bujang Kampus' }}
                            @if ($alumni->city)
                                · {{ $alumni->city }}
                            @endif
                        </p>
                    </div>

                    <dl class="hero-animate-delay-2 mt-8 space-y-4 text-sm">
                        @if ($alumni->university)
                            <div>
                                <dt class="text-xs font-semibold tracking-[0.12em] text-gold uppercase">Perguruan Tinggi</dt>
                                <dd class="mt-1 text-navy">{{ $alumni->university }}</dd>
                            </div>
                        @endif
                        @if ($alumni->study_program)
                            <div>
                                <dt class="text-xs font-semibold tracking-[0.12em] text-gold uppercase">Program Studi</dt>
                                <dd class="mt-1 text-navy">{{ $alumni->study_program }}</dd>
                            </div>
                        @endif
                        @if ($alumni->profession)
                            <div>
                                <dt class="text-xs font-semibold tracking-[0.12em] text-gold uppercase">Profesi</dt>
                                <dd class="mt-1 text-navy">{{ $alumni->profession }}</dd>
                            </div>
                        @endif
                        @if ($alumni->company)
                            <div>
                                <dt class="text-xs font-semibold tracking-[0.12em] text-gold uppercase">Instansi / Perusahaan</dt>
                                <dd class="mt-1 text-navy">{{ $alumni->company }}</dd>
                            </div>
                        @endif
                    </dl>

                    @if ($alumni->bio)
                        <div class="hero-animate-delay-2 mt-8 border-t border-navy/10 pt-6">
                            <h2 class="text-xs font-semibold tracking-[0.12em] text-gold uppercase">Profil</h2>
                            <p class="mt-3 text-sm leading-relaxed text-muted">{{ $alumni->bio }}</p>
                        </div>
                    @endif

                    @if ($alumni->instagram || $alumni->linkedin)
                        <div class="hero-animate-delay-3 mt-8 flex flex-wrap gap-3">
                            @if ($alumni->instagram && ($instagramUrl = safe_url($alumni->instagram)))
                                <a href="{{ $instagramUrl }}" target="_blank" rel="noopener noreferrer" class="btn-outline-gold text-xs transition-transform duration-300 hover:scale-[1.02]">
                                    Instagram
                                </a>
                            @endif
                            @if ($alumni->linkedin && ($linkedinUrl = safe_url($alumni->linkedin)))
                                <a href="{{ $linkedinUrl }}" target="_blank" rel="noopener noreferrer" class="btn-outline-gold text-xs transition-transform duration-300 hover:scale-[1.02]">
                                    LinkedIn
                                </a>
                            @endif
                        </div>
                    @endif

                    <div class="hero-animate-delay-3 mt-10">
                        <a href="{{ route('alumni', array_filter([
                            'angkatan' => $alumni->alumniBatch?->slug,
                            'halaman' => $alumni->alumniBatch ? AlumniBatch::sidebarPageForBatch($alumni->alumniBatch) : null,
                        ])) }}" class="btn-outline-gold transition-transform duration-300 hover:scale-[1.01]">
                            ← Kembali ke Direktori Alumni
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
