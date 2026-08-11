@extends('layouts.app')

@section('title', $partner->name.' × IBGK Sumsel — Kemitraan')

@section('meta_description', $partner->showcase_intro ?: $partner->description)

@section('content')
    <div class="partner-showcase bg-white">
        @include('partials.partnership.showcase.hero')
        @include('partials.partnership.showcase.strategic-values')
        @include('partials.partnership.showcase.programs-detail')
        @include('partials.partnership.showcase.program-quote')
        @include('partials.partnership.showcase.contact-footer')
        @include('partials.partnership.showcase.footer')
    </div>
@endsection
