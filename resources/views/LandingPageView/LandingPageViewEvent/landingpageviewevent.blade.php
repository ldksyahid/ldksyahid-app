@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Page Header Start -->
<div
class="container-fluid page-header py-5 mb-5 wow fadeIn"
data-wow-delay="0.1s"
>
<div class="container text-center py-5">
  <h1 class="display-4 text-white animated slideInDown mb-4 text-uppercase">
    Kegiatan LDK Syahid
  </h1>
  <nav aria-label="breadcrumb animated slideInDown">
    <ol class="breadcrumb justify-content-center mb-0">
      <p class="text-white">Yuk Hadir dan Ikuti Kegiatan LDK Syahid untuk menambah Teman dan Ilmu Kamu</p>
    </ol>
  </nav>
</div>
</div>
<!-- Page Header End -->
<div class="container-xxl py-5">
    <div class="container">
        @forelse($postevent as $key => $postevent)
        <div class="row g-5 my-1">
            <div class="col-lg-2 col-md-6 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="ps-4">
                    <h5 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postevent->dateevent )->format('Y') }}</h5>
                    <h6 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postevent->dateevent )->isoFormat('MMMM') }}</h6>
                    <h1 class="display-6 mb-0">{{ \Carbon\Carbon::parse( $postevent->dateevent )->isoFormat('DD') }}</h1>
                    <p class="mb-0">{{ \Carbon\Carbon::parse( $postevent->dateevent )->isoFormat('dddd') }}</p>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                <h6 class="text-body text-uppercase mb-2">{{ $postevent->division }}</h6>
                <h1 class="display-6 mb-0" style="text-align: left">{{ $postevent->title }}</h1>
                </div>
                <p class="mb-1">
                    {!! substr($postevent->broadcast, 0, 300) !!}
                </p>
                <a class="mb-0" href="/event/{{ $postevent->id }}/show">Baca Selengkapnya</a>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInRight" data-wow-delay="0.5s">
                <img src="{{ asset($postevent->poster) }}" alt="{{ $postevent->title }}" class="img-fluid" width="300px" height="400px">
            </div>
        </div>
        @empty
        <div class="row g-5 my-1">
            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <h1 class="display-6 mb-0" style="text-align: center">Kegiatan Belum Tersedia</h1>
            </div>
        </div>
        @endforelse
    </div>
</div>
@endsection
