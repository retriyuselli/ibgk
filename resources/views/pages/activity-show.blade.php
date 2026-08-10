@extends('layouts.app')

@section('title', $activity->title.' — Kegiatan IBGK Sumsel')

@section('meta_description', $activity->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($activity->content ?? ''), 160))

@section('content')
    @php
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $formatDate = function ($date) use ($months): ?string {
            if (! $date) {
                return null;
            }

            return $date->format('j').' '.$months[(int) $date->format('n')].' '.$date->format('Y');
        };
        $hasContent = filled(trim(strip_tags($activity->content ?? '')));
        $banner = $activity->banner ?: $activity->thumbnail;
    @endphp

    <section class="relative bg-cream py-10 sm:py-12">
        <div class="site-container max-w-4xl">
            <nav class="text-xs text-muted" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="hover:text-gold">Beranda</a></li>
                    <li aria-hidden="true">›</li>
                    <li><a href="{{ route('activities') }}" class="hover:text-gold">Kegiatan</a></li>
                    <li aria-hidden="true">›</li>
                    <li class="text-navy">{{ \Illuminate\Support\Str::limit($activity->title, 48) }}</li>
                </ol>
            </nav>

            @if ($activity->category)
                <p class="mt-6 text-xs font-semibold tracking-[0.16em] text-gold uppercase">{{ $activity->category->name }}</p>
            @endif

            <h1 class="section-title mt-3">{{ $activity->title }}</h1>

            <div class="mt-4 flex flex-wrap gap-4 text-xs text-muted">
                @if ($formatDate($activity->activity_date))
                    <span>{{ $formatDate($activity->activity_date) }}</span>
                @endif
                @if ($activity->location)
                    <span>{{ $activity->location }}</span>
                @endif
            </div>

            @if ($banner)
                <figure class="mt-8 overflow-hidden rounded-lg shadow-md shadow-navy/10">
                    <img src="{{ asset('storage/'.$banner) }}" alt="{{ $activity->title }}" class="aspect-[16/9] w-full object-cover">
                </figure>
            @endif

            <div class="mt-8 space-y-4 text-sm leading-relaxed text-muted sm:text-base [&_p+p]:mt-4">
                @if ($hasContent)
                    {!! $activity->content !!}
                @elseif ($activity->excerpt)
                    <p>{{ $activity->excerpt }}</p>
                @else
                    <p>Dokumentasi program kegiatan IBGK Sumatera Selatan.</p>
                @endif
            </div>

            <div class="mt-10">
                <a href="{{ route('activities') }}" class="btn-outline-gold">
                    ← Kembali ke Kegiatan
                </a>
            </div>
        </div>
    </section>

    @if ($relatedActivities->isNotEmpty())
        <section class="bg-white py-12 sm:py-14">
            <div class="site-container max-w-4xl">
                <h2 class="font-display text-xl font-semibold text-navy">Kegiatan Terkait</h2>
                <ul class="mt-6 space-y-4">
                    @foreach ($relatedActivities as $item)
                        <li>
                            <a href="{{ route('activities.show', $item) }}" class="group block border border-navy/8 bg-cream/40 px-4 py-4 transition hover:border-gold/35">
                                <p class="text-sm font-semibold text-navy group-hover:text-gold">{{ $item->title }}</p>
                                @if ($item->category)
                                    <p class="mt-1 text-xs text-muted">{{ $item->category->name }}</p>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </section>
    @endif
@endsection
