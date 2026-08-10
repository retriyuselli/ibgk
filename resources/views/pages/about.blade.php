@extends('layouts.app')

@section('title', 'Tentang IBGK Sumatera Selatan')

@section('meta_description', $profile->short_description ?? 'Sejarah, visi, misi, dan keanggotaan Ikatan Bujang Gadis Kampus Sumatera Selatan.')

@section('content')
    @include('partials.about.hero')
    @include('partials.about.history')
    @include('partials.about.journey')
    @include('partials.about.membership')
    @include('partials.about.vision')
    @include('partials.about.quote')
@endsection
