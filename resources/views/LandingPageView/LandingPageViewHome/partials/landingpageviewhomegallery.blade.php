<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f5f6fa" fill-opacity="1" d="M0,192L34.3,197.3C68.6,203,137,213,206,202.7C274.3,192,343,160,411,133.3C480,107,549,85,617,112C685.7,139,754,213,823,218.7C891.4,224,960,160,1029,112C1097.1,64,1166,32,1234,37.3C1302.9,43,1371,85,1406,106.7L1440,128L1440,320L1405.7,320C1371.4,320,1303,320,1234,320C1165.7,320,1097,320,1029,320C960,320,891,320,823,320C754.3,320,686,320,617,320C548.6,320,480,320,411,320C342.9,320,274,320,206,320C137.1,320,69,320,34,320L0,320Z"></path></svg>
<!-- Galery Start -->
<div class="container-xxl" style="background-color: #f5f6fa">
    <div class="container">
        <div class="row g-5 align-items-end mb-5">
            <div class="col-lg-3 text-lg-start wow fadeInUp" data-wow-delay="0.3s">
                <a class="btn btn-primary py-3 px-5" href="/about/gallery">Dokumentasi Lainnya</a>
            </div>
            <div class="col-lg-9 wow fadeInUp text-end" data-wow-delay="0.1s">
                <div class="border-end border-5 border-primary px-4">
                    <h6 class="text-body text-uppercase mb-2">Galeri</h6>
                    <h1 class="display-6 mb-0">
                        Dokumentasi Kegiatan Kami
                    </h1>
                    <p class="mb-0 mt-1">
                        Dokumentasi Terbaru dari kegiatan UKM LDK Syahid yang memberikan banyak Manfaat untuk Umat
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-6">
            @forelse($postgallery as $key => $postgallery)
            <div class="col-lg-12 col-md-6 wow fadeInUp mb-5 text-center" data-wow-delay="0.1s">
                <div class="mb-3">
                    <h6 class="text-body mb-2">{{ $postgallery->eventName }}</h6>
                    <h2 class="mb-0">{{ $postgallery->eventTheme }}</h2>
                    <p class="mb-0 mt-2" style="text-align: center">
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
                <h3>Dokumentasi Kegiatan Belum Tersedia</h3>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Galery End -->
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f5f6fa" fill-opacity="1" d="M0,192L34.3,192C68.6,192,137,192,206,208C274.3,224,343,256,411,245.3C480,235,549,181,617,144C685.7,107,754,85,823,74.7C891.4,64,960,64,1029,96C1097.1,128,1166,192,1234,186.7C1302.9,181,1371,107,1406,69.3L1440,32L1440,0L1405.7,0C1371.4,0,1303,0,1234,0C1165.7,0,1097,0,1029,0C960,0,891,0,823,0C754.3,0,686,0,617,0C548.6,0,480,0,411,0C342.9,0,274,0,206,0C137.1,0,69,0,34,0L0,0Z"></path></svg>
