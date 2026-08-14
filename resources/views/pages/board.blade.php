@extends('layouts.app')

@section('title', 'Kepengurusan IBGK Sumatera Selatan')

@section('meta_description', 'Struktur kepengurusan Ikatan Bujang Gadis Kampus Sumatera Selatan periode '.($period?->yearRange() ?? 'aktif').'.')

@section('content')
    @include('partials.board.hero')
    @include('partials.board.structure')
    @include('partials.board.about')
@endsection
