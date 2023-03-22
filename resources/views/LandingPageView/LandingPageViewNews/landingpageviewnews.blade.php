@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
  <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
          <div class="carousel-item active">
              <img class="w-100" src="{{ asset('Images/fixImage/billboardimage/berita.png') }}" alt="Image" />
          </div>
      </div>
  </div>
</div>
<!-- Page Header End -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                @forelse($postnews as $key => $postnews)
                <div class="border-start border-5 border-primary ps-4 mb-4">
                    <h4 class=" mb-1"><a href="/news/{{ $postnews->id }}/{{ strtolower(str_replace(' ', '-', $postnews->title)) }}">{{ $postnews->title }}</a></h4>
                    <h6 class="text-body mb-1">{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('D') }} {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('Y') }}</h6>
                    <p class="mb-0" style="text-align: justify">{{ $postnews->title }} Reporter {{ $postnews->reporter }}; Editor {{ $postnews->editor }} {!!  substr(strip_tags($postnews->body), 0, 80) !!} … <a href="/news/{{ $postnews->id }}/{{ strtolower(str_replace(' ', '-', $postnews->title)) }}">Selanjutnya</a></p>
                </div>
                @empty
                    <h1 class="text-center">Berita Belum Tersedia</h1>
                @endforelse
            </div>
        </div>
    </div>
</div>

@endsection
