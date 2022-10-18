@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-4 text-uppercase">
            Jadwal LDK Syahid
        </h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <p class="text-white">Cari tahu dan catat Jadwalnya, Jangan sampai ketinggalan ya</p>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->
<div class="container-xxl py-5">
    <div class="container">
        @forelse($postschedule as $key => $postschedule)
        <div class="row g-5 mt-3">
            <div class="col-lg-4 col-md-6 wow fadeInLeft" data-wow-delay="0.5s">
                <div class="ps-4 mb-5 text-center">
                    <h5 class="text-body mb-2">Syahid Jadwal-in</h5>
                    <h6 class="text-body mb-2">Edisi</h6>
                    <h1 class="display-6 mb-0 text-uppercase">{{ $postschedule->month }}</h1>
                    <p class="mb-0">{{ $postschedule->year }}</p>
                </div>
            </div>
            <div class="col-lg-8 col-md-6 wow fadeInRight" data-wow-delay="0.5s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h1 class="display-6 mb-0" style="text-align: left">{{ $postschedule->title }}</h1>
                </div>
                <img src="{{ asset($postschedule->picture) }}" alt="{{ $postschedule->title }}" class="img-fluid rounded" width="1080px" height="1350px">
            </div>
        </div>
        @empty
        <div class="row g-5 mt-3 text-center">
            <h1>Jadwal Belum Tersedia</h1>
        </div>
        @endforelse
    </div>
</div>
@endsection
