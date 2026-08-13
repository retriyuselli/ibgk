@extends('layouts.app')

@php($org = org_profile($profile))

@section('title', $org->registrationCopy('hero_title', ['year' => $election?->year ?? now()->year]))

@section('meta_description', $election?->short_description ?? $org->registrationCopy('hero_description_fallback'))

@section('content')
    @include('partials.registration.hero')
    @include('partials.registration.content')
@endsection
