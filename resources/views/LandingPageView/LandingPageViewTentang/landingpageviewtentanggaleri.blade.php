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
            <div class="col-lg-12 col-md-6 wow fadeInUp mb-5" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h6 class="text-body mb-2">Islamic Movement Festival Season 3</h6>
                    <h2 class="mb-0">Actualization Of Islamic Value in Youth Moslem For Modernity</h2>
                    <p class="mb-0 mt-1" style="text-align: justify">
                        Islamic Movement Festival 2022 ini adalah rangkaian yang ditujukan untuk mahasiswa juga rangkaian acara Bedah Buku, Tabligh Akbar dan Penampilan Guest Star yang diisi oleh pemateri yang ahli di bidangnya
                    </p>
                </div>
                <div class="row g-0">
                    <div class="col-lg-12 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('Images/Testing/galeri5.jpg') }}" alt="" width="700" height="500"/>
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('Images/Testing/galeri1.jpg') }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('Images/Testing/galeri4.jpg') }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('Images/Testing/galeri2.jpg') }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('Images/Testing/galeri4.jpg') }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('Images/Testing/galeri2.jpg') }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('Images/Testing/galeri3.jpg') }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('Images/Testing/galeri4.jpg') }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('Images/Testing/galeri1.jpg') }}" alt="" />
                        </div>
                    </div>
                    <div class="col-lg-4 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                        <div class="position-relative">
                            <img class="img-fluid w-100" src="{{ asset('Images/Testing/galeri3.jpg') }}" alt="" />
                        </div>
                    </div>
                    <iframe class="wow fadeIn" data-wow-delay="0.1s" width="700" height="600" src="https://www.youtube.com/embed/bnefWnvfIfc" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Galery End -->
@endsection
{{-- <div class="col-lg-12 col-md-6 wow fadeInUp mb-5" data-wow-delay="0.1s">
    <h1>Dokumentasi Kegiatan Belum Tersedia</h1>
</div> --}}
