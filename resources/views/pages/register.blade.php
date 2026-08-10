@extends('layouts.app')

@section('title', 'Daftar Akun — IBGK Sumatera Selatan')

@section('meta_description', 'Buat akun IBGK Sumatera Selatan untuk mengakses panel admin dan fitur internal organisasi.')

@section('content')
    @include('partials.auth.register-form')
@endsection
