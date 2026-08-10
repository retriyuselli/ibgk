@extends('layouts.app')

@section('title', 'Masuk — IBGK Sumatera Selatan')

@section('meta_description', 'Masuk ke panel admin IBGK Sumatera Selatan untuk mengelola konten dan kegiatan organisasi.')

@section('content')
    @include('partials.auth.login-form')
@endsection
