@extends('layouts.app')

@section('title', 'Berita IBGK Sumatera Selatan')

@section('meta_description', 'Berita dan informasi terbaru seputar kegiatan, prestasi, dan kontribusi Ikatan Bujang Gadis Kampus Sumatera Selatan.')

@section('content')
    @include('partials.news.hero')
    @include('partials.news.content')
    @include('partials.news.cta')
@endsection
