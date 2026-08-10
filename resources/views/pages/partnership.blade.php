@extends('layouts.app')

@section('title', 'Kemitraan IBGK Sumatera Selatan')

@section('meta_description', 'Informasi kemitraan dan kolaborasi dengan Ikatan Bujang Gadis Kampus Sumatera Selatan.')

@section('content')
    @include('partials.partnership.hero')
    @include('partials.partnership.highlights')
    @include('partials.partnership.partners')
    @include('partials.partnership.types')
    @include('partials.partnership.cta')
@endsection
