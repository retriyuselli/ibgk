@extends('layouts.app')

@section('title', 'Kegiatan IBGK Sumatera Selatan')

@section('meta_description', 'Program dan kegiatan Ikatan Bujang Gadis Kampus Sumatera Selatan di bidang pendidikan, sosial, budaya, dan kepemudaan.')

@section('content')
    @include('partials.activities.hero')
    @include('partials.activities.categories')
    @include('partials.activities.featured')
    @include('partials.activities.gallery')
    @include('partials.activities.stats')
    @include('partials.activities.cta')
@endsection
