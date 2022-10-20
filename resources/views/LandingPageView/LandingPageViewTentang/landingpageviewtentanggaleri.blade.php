@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 mb-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-4 text-uppercase">Galeri LDK Syahid</h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <p class="text-white">Dokumentasi Kegiatan UKM LDK Syahid</p>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->
<!-- Galery Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            @forelse($postgallery as $key => $postgallery)
            <div class="col-lg-12 col-md-6 wow fadeInUp mb-5" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h6 class="text-body mb-2">{{ $postgallery->eventName }}</h6>
                    <h2 class="mb-0">{{ $postgallery->eventTheme }}</h2>
                    <p class="mb-0 mt-1" style="text-align: justify">
                        {{ $postgallery->eventDescription }}
                    </p>
                </div>
                <div class="row g-0">
                    <div class="col-lg-12 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->groupPhoto) }}" alt="" width="700" height="500"/>
                        </div>
                    </div>

                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo1) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo2) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo3) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo4) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo5) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo6) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo7) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo8) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo9) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo10) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo11) }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative m-1 img-hover-zoom">
                            <img class="img-fluid w-100" src="{{ asset($postgallery->photo12) }}" alt="" />
                        </div>
                    </div>
                    @if ($postgallery->linkEmbedYoutube == null)

                    @else
                    <div class="col-lg-12 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="m-1">
                            <iframe  data-wow-delay="0.1s" width="100%" height="600" src="{{ $postgallery->linkEmbedYoutube }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
            @empty
            <div class="col-lg-12 col-md-6 wow fadeInUp mb-5" data-wow-delay="0.1s" style="text-align: center">
                <h1>Dokumentasi Kegiatan Belum Tersedia</h1>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Galery End -->
@endsection
