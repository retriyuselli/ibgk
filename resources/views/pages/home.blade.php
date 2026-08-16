@extends('layouts.app')

@section('title', ($profile->short_name ?? 'IBGK Sumsel').' — Beranda')

@section('meta_description', $profile->short_description ?? 'Ikatan Bujang Gadis Kampus Sumatera Selatan')

@section('content')
    @include('partials.home.hero')
    @include('partials.home.stats')
    @include('partials.home.about')
    @include('partials.home.history')
    @include('partials.home.programs-news')
    @include('partials.home.alumni')
    @include('partials.home.partners')
    @include('partials.home.popup')
@endsection
