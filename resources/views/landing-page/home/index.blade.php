@extends('landing-page.template.body')

@section('content')
{{-- PopUp Landing Page Start --}}
{{-- @include('landing-page.home.partials.popup') --}}
{{-- PopUp Landing Page End --}}

{{-- Jumbotron Landing Page Start --}}
@include('landing-page.home.partials.jumbotron.index')
{{-- Jumbptron Landing Page End --}}

{{-- Verification Email Page Start --}}
@include('landing-page.home.partials.verify-email.index')
{{-- Verification Email Page END --}}

{{-- About Landing Page Start --}}
@include('landing-page.home.partials.about.index')
{{-- About Landing Page End --}}

{{-- KMB Landing Page Start --}}
@include('landing-page.home.partials.kmb-class.index')
{{-- KMB Landing Page End --}}

{{-- Article Landing Page Start --}}
@include('landing-page.home.partials.article.index')
{{-- Article Landing Page End --}}

{{-- News Landing Page Start --}}
@include('landing-page.home.partials.news.index')
{{-- News Landing Page End --}}

{{-- Library Landing Page Start --}}
@include('landing-page.home.partials.library.index')
{{-- Library Landing Page End --}}

{{-- Event Landing Page Start --}}
@include('landing-page.home.partials.event.index')
{{-- Event Landing Page End --}}

{{-- Schedule Landing Page Start --}}
@include('landing-page.home.partials.schedule.index')
{{-- Schedule Landing Page End --}}

{{-- Gallery Landing Page Start --}}
@include('landing-page.home.partials.gallery.index')
{{-- Gallery Landing Page End --}}

{{-- Testimony Landing Page Start --}}
@include('landing-page.home.partials.testimony.index')
{{-- Testimony Landing Page End --}}

{{-- Contact Us Landing Page Start --}}
@include('landing-page.home.partials.contact-us.index')
{{-- Contact Us Landing Page End --}}

@endsection
