@extends('layouts.app')

@section('title', 'Kontak IBGK Sumatera Selatan')

@section('meta_description', 'Hubungi Ikatan Bujang Gadis Kampus Sumatera Selatan untuk informasi, kolaborasi, dan pertanyaan.')

@section('content')
    @include('partials.contact.hero')
    @include('partials.contact.info-cards')
    @include('partials.contact.form-map')
    @include('partials.contact.social-partnership')
@endsection
