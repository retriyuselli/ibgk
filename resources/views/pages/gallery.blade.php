@extends('layouts.app')

@section('title', 'Galeri IBGK Sumatera Selatan')

@section('meta_description', 'Galeri foto dan dokumentasi kegiatan Ikatan Bujang Gadis Kampus Sumatera Selatan.')

@section('content')
    @include('partials.gallery.hero')
    @include('partials.gallery.filters')
    @include('partials.gallery.categories')
    @include('partials.gallery.featured')
    @include('partials.gallery.preview')
    @include('partials.gallery.cta')
    @include('partials.gallery.stats')
@endsection
