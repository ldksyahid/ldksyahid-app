@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')

{{-- Jumbotron Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomejumbotron')
{{-- Jumbptron Landing Page End --}}

{{-- About Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomeabout')
{{-- About Landing Page End --}}

{{-- KMB Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomekmb')
{{-- KMB Landing Page End --}}

{{-- Article Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomearticle')
{{-- Article Landing Page End --}}

{{-- News Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomenews')
{{-- News Landing Page End --}}

{{-- Event Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomeevent')
{{-- Event Landing Page End --}}

{{-- Contact Us Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomecontactus')
{{-- Contact Us Landing Page End --}}

{{-- Schedule Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomeschedule')
{{-- Schedule Landing Page End --}}

{{-- Gallery Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomegallery')
{{-- Gallery Landing Page End --}}

{{-- Testimony Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhometestimony')
{{-- Testimony Landing Page End --}}
@endsection
