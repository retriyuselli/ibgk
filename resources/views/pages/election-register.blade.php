@extends('layouts.app')

@section('title', 'Daftar BGK '.($election?->year ?? now()->year))

@section('meta_description', 'Formulir pendaftaran Pemilihan Bujang Gadis Kampus Sumatera Selatan.')

@section('content')
    @include('partials.registration.hero')
    @include('partials.registration.content')
@endsection
