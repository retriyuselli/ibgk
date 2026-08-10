@extends('layouts.app')

@section('title', ($profile->short_name ?? 'IBGK Sumsel').' — Beranda')

@section('meta_description', $profile->short_description ?? 'Ikatan Bujang Gadis Kampus Sumatera Selatan')

@section('content')
@endsection
