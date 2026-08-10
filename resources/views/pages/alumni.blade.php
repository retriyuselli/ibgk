@extends('layouts.app')

@section('title', 'Alumni IBGK Sumatera Selatan')

@section('meta_description', 'Direktori keluarga besar alumni Ikatan Bujang Gadis Kampus Sumatera Selatan dari berbagai angkatan.')

@section('content')
    @include('partials.alumni.hero')
    @include('partials.alumni.directory')
    @include('partials.alumni.cta')
@endsection
