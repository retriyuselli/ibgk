@extends('layouts.app')

@section('title', $partner->name.' × '.org_profile($profile)->displayShortName().' — Kemitraan')

@section('meta_description', $partner->showcase_intro ?: $partner->description)

@section('content')
    @php
        $org = org_profile($profile);
    @endphp
    <div class="partner-showcase bg-white" data-showcase-theme="{{ $partner->showcaseTheme() }}">
        @include('partials.partnership.showcase.hero')

        @if ($partner->isFullShowcase())
            @include('partials.partnership.showcase.strategic-values')
        @endif

        @include('partials.partnership.showcase.programs-detail')

        @if ($partner->isFullShowcase())
            @include('partials.partnership.showcase.program-quote')
        @endif

        @include('partials.partnership.showcase.contact-footer')
        @include('partials.partnership.showcase.footer')
    </div>
@endsection
