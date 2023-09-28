@extends('landing-page.template.body')

@section('content')
{{-- PopUp Landing Page Start --}}
@include('landing-page.home.partials.popup')
{{-- PopUp Landing Page End --}}

{{-- Jumbotron Landing Page Start --}}
@include('landing-page.home.partials.jumbotron')
{{-- Jumbptron Landing Page End --}}

{{-- Verification Email Page Start --}}
@include('landing-page.home.partials.verify-email')
{{-- Verification Email Page END --}}

{{-- About Landing Page Start --}}
@include('landing-page.home.partials.about')
{{-- About Landing Page End --}}

{{-- KMB Landing Page Start --}}
@include('landing-page.home.partials.kmb-class')
{{-- KMB Landing Page End --}}

{{-- Article Landing Page Start --}}
@include('landing-page.home.partials.article')
{{-- Article Landing Page End --}}

{{-- News Landing Page Start --}}
@include('landing-page.home.partials.news')
{{-- News Landing Page End --}}

{{-- Event Landing Page Start --}}
@include('landing-page.home.partials.event')
{{-- Event Landing Page End --}}

{{-- Contact Us Landing Page Start --}}
@include('landing-page.home.partials.contact-us')
{{-- Contact Us Landing Page End --}}

{{-- Schedule Landing Page Start --}}
@include('landing-page.home.partials.schedule')
{{-- Schedule Landing Page End --}}

{{-- Gallery Landing Page Start --}}
@include('landing-page.home.partials.gallery')
{{-- Gallery Landing Page End --}}

{{-- Testimony Landing Page Start --}}
@include('landing-page.home.partials.testimony')
{{-- Testimony Landing Page End --}}

@endsection
