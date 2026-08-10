@extends('layouts.app')

@section('title', 'Dashboard — IBGK Sumatera Selatan')

@section('meta_description', 'Dashboard akun pengguna IBGK Sumatera Selatan.')

@section('content')
    @include('partials.dashboard.welcome')
    @include('partials.dashboard.overview')
    @include('partials.dashboard.quick-actions')
@endsection
