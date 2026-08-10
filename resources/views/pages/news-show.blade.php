@extends('layouts.app')

@section('title', $news->title.' — Berita IBGK Sumsel')

@section('meta_description', $news->excerpt ?: \Illuminate\Support\Str::limit(strip_tags($news->content ?? ''), 160))

@section('content')
    @php
        $months = [
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
            5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
            9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember',
        ];
        $publishedLabel = $news->published_at
            ? $news->published_at->format('j').' '.$months[(int) $news->published_at->format('n')].' '.$news->published_at->format('Y')
            : '—';
        $hasContent = filled(trim(strip_tags($news->content ?? '')));
    @endphp

    <section class="relative bg-cream py-10 sm:py-12">
        <div class="site-container max-w-4xl">
            <nav class="text-xs text-muted" aria-label="Breadcrumb">
                <ol class="flex flex-wrap items-center gap-2">
                    <li><a href="{{ route('home') }}" class="hover:text-gold">Beranda</a></li>
                    <li aria-hidden="true">›</li>
                    <li><a href="{{ route('news') }}" class="hover:text-gold">Berita</a></li>
                    <li aria-hidden="true">›</li>
                    <li class="text-navy">{{ \Illuminate\Support\Str::limit($news->title, 48) }}</li>
                </ol>
            </nav>

            @if ($news->category)
                <p class="mt-6 text-xs font-semibold tracking-[0.16em] text-gold uppercase">{{ $news->category->name }}</p>
            @endif

            <h1 class="section-title mt-3">{{ $news->title }}</h1>

            <div class="mt-4 flex flex-wrap gap-4 text-xs text-muted">
                <span>{{ $publishedLabel }}</span>
                @if ($news->location)
                    <span>{{ $news->location }}</span>
                @endif
                <span>{{ number_format($news->views) }} kali dibaca</span>
            </div>

            @if ($news->thumbnail)
                <figure class="mt-8 overflow-hidden rounded-lg shadow-md shadow-navy/10">
                    <img src="{{ asset('storage/'.$news->thumbnail) }}" alt="{{ $news->title }}" class="aspect-[16/9] w-full object-cover">
                </figure>
            @endif

            <div class="mt-8 space-y-4 text-sm leading-relaxed text-muted sm:text-base [&_p+p]:mt-4">
                @if ($hasContent)
                    {!! $news->content !!}
                @elseif ($news->excerpt)
                    <p>{{ $news->excerpt }}</p>
                @else
                    <p>Informasi dan update terbaru dari IBGK Sumatera Selatan.</p>
                @endif
            </div>

            <div class="mt-10">
                <a href="{{ route('news') }}" class="btn-outline-gold">
                    ← Kembali ke Berita
                </a>
            </div>
        </div>
    </section>

    @if ($relatedNews->isNotEmpty())
        <section class="bg-white py-12 sm:py-14">
            <div class="site-container max-w-4xl">
                <h2 class="font-display text-xl font-semibold text-navy">Berita Terkait</h2>
                <ul class="mt-6 space-y-4">
                    @foreach ($relatedNews as $item)
                        <li>
                            <a href="{{ route('news.show', $item) }}" class="group block border border-navy/8 bg-cream/40 px-4 py-4 transition hover:border-gold/35">
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
