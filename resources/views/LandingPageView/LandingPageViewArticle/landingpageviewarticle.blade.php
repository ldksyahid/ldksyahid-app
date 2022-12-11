@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="w-100" src="{{ asset('Images/fixImage/billboardimage/artikel.png') }}" alt="Image" />
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
<!-- Article Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-4 justify-content-center">
            @forelse($postarticle as $key => $postarticle)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light overflow-hidden h-100">
                    <a href="/article/{{ $postarticle->id }}/show"><img class="img-fluid" src="{{ asset($postarticle->poster) }}" alt="{{$postarticle->title}}" /></a>
                    <div class="service-text position-relative text-center h-100 p-4">
                        <p class="text-end">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postarticle->dateevent )->format('Y') }}</p>
                        <h6 class="text-body text-uppercase mb-2 text-start">{{ $postarticle->theme }}</h6>
                        <a href="/article/{{ $postarticle->id }}/show"><h4 class="" style="text-align: left;">{{ $postarticle->title }}</h4></a>
                        <p class="text-start mb-0">Penulis :  {{ $postarticle->writer }}</p>
                        <p class="text-start mt-0">Editor : {{ $postarticle->editor }}</p>
                        <div class="text-end align-bottom">
                            <a class="small" href="/article/{{ $postarticle->id }}/show">BACA SELENGKAPNYA<i class="fa fa-arrow-right ms-3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-lg-12 col-md-6 wow fadeInUp text-center" data-wow-delay="0.1s">
                <h1>Artikel Belum Tersedia</h1>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Article End -->
@endsection
