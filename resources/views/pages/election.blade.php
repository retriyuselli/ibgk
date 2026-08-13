@extends('layouts.app')

@php($org = org_profile($profile))

@section('title', $election?->name ?? $org->electionCopy('hero_title_fallback'))

@section('meta_description', $election?->short_description ?? $org->electionCopy('short_description_fallback'))

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
