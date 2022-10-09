@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-4 text-uppercase">
            Artikel LDK Syahid
        </h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <p class="text-white">asdwadaw</p>
            </ol>
        </nav>
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
                    <img class="img-fluid" src="{{asset('Images/uploads/articlesposter')}}/{{$postarticle->poster}}" alt="{{$postarticle->title}}" />
                    <div class="service-text position-relative text-center h-100 p-4">
                        <p class="text-end">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postarticle->dateevent )->format('Y') }}</p>
                        <h6 class="text-body text-uppercase mb-2 text-start">{{ $postarticle->theme }}</h6>
                        <h4 class="" style="text-align: left;">{{ $postarticle->title }}</h4>
                        <p class="text-start mb-0">Penulis : {{ $postarticle->writer }}</p>
                        <p class="text-start mt-0">Editor : {{ $postarticle->editor }}</p>
                        <div class="text-end">
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
