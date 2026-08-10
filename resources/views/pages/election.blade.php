@extends('layouts.app')

@section('title', $election?->name ?? 'Pemilihan BGK Sumatera Selatan')

@section('meta_description', $election?->short_description ?? 'Pemilihan Bujang Gadis Kampus Sumatera Selatan — tahapan, jadwal, persyaratan, dan manfaat.')

@section('content')
    @include('partials.election.hero')
    @include('partials.election.about')
    @include('partials.election.stages')
    @include('partials.election.schedule')
    @include('partials.election.requirements-benefits')
    @include('partials.election.participants')
    @include('partials.election.past-elections')
    @include('partials.election.cta')
@endsection
