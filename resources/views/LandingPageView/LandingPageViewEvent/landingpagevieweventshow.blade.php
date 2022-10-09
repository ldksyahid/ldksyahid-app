@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-2 col-md-6 wow fadeInLeft" data-wow-delay="0.5s">
                <div class="ps-4 mb-5 text-center">
                    <h5 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postevent->dateevent )->isoFormat('Y') }}</h5>
                    <h6 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postevent->dateevent )->isoFormat('MMMM') }}</h6>
                    <h1 class="display-6 mb-0">{{ \Carbon\Carbon::parse( $postevent->dateevent )->isoFormat('DD') }}</h1>
                    <p class="mb-0">{{ \Carbon\Carbon::parse( $postevent->dateevent )->isoFormat('dddd') }}</p>
                </div>
            </div>
            <div class="col-lg-10 col-md-6 wow fadeInRight" data-wow-delay="0.5s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                <h6 class="text-body text-uppercase mb-2">{{ $postevent->division }}</h6>
                <h1 class="display-6 mb-0" style="text-align: left">{{ $postevent->title }}</h1>
                </div>
            </div>
            <div class="shadow wow fadeInUp p-5 rounded" data-wow-delay="1.0s" style="background-color: #F8F9FA;">
                <div class="col-lg-12 col-md-6 text-center">
                    <img src="{{asset('Images/uploads/eventsposter')}}/{{$postevent->poster}}"alt="" class="img-fluid rounded" width="700px" height="800">
                </div>
                {{-- <div class="col-lg-12 col-md-6 wow fadeInLeft text-center" data-wow-delay="0.5s">
                    <img src="{{ asset('Images/Testing/testevent.jpg') }}"alt="" width="700px" height="800">
                </div> --}}
                <div class="mb-1  rounded-bottom p-3">
                    <p data-wow-delay="0.5s">{!! $postevent->broadcast !!}</p>
                </div>
                {{-- <p data-wow-delay="0.5s">{!! $postevent->broadcast !!}</p> --}}
                @if ($postevent->linkembedgform == null)

                @else
                    <div class="col-lg-12 col-md-6  text-center mb-3" >
                        <iframe src="{{ $postevent->linkembedgform }}" width="640" height="740" frameborder="0" marginheight="20" marginwidth="20" class="container-fluid">Memuat…</iframe>
                    </div>
                @endif
            </div>
            <div class="col-12 d-flex wow fadeInLeft" data-wow-delay="0.5s">
                <a class="btn btn-primary w-100 py-3 mr-1" href="/event" type="submit">Kembali ke Halaman Kegiatan</a>
            </div>
        </div>
    </div>
</div>
@endsection
