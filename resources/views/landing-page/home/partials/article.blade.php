<!-- Article Start -->
@if((new \Jenssegers\Agent\Agent())->isDesktop())
<div class="py-5">
    <div class="container">
        <div class="row g-5 align-items-end mb-5">
            <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4">
                    <h6 class="text-body text-uppercase mb-2">Artikel</h6>
                    <h1 class="display-6 mb-0">
                        Karya Tulis Anggota UKM LDK Syahid
                    </h1>
                    <p class="mb-0 mt-1" style="text-align: justify">
                        Artikel ini merupakan Hasil Karya Tulis dari para Anggota UKM LDK Syahid yang memiliki kemampuan dan sederet Prestasi dibidang Karya Tulis
                    </p>
                </div>
            </div>
            <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay="0.3s">
                <a class="btn btn-primary py-3 px-5" href="/articles">Artikel Lainnya</a>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            @forelse($postarticle as $key => $postarticle)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light overflow-hidden h-100 shadow">
                    <a href="/articles/{{ $postarticle->id }}"><img class="img-fluid" src="https://lh3.googleusercontent.com/d/{{ $postarticle->gdrive_id }}" alt="{{$postarticle->title}}" /></a>
                    <div class="service-text position-relative text-center h-100 p-4">
                        <p class="text-end">{{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postarticle->dateevent )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postarticle->dateevent )->format('Y') }}</p>
                        <h6 class="text-body text-uppercase mb-2 text-start">{{ $postarticle->theme }}</h6>
                        <a href="/articles/{{ $postarticle->id }}"><h4 class="" style="text-align: left;">{{ $postarticle->title }}</h4></a>
                        <p class="text-start mb-0">Penulis : {{ $postarticle->writer }}</p>
                        <p class="text-start mt-0">Editor : {{ $postarticle->editor }}</p>
                        <div class="text-end">
                            <a class="small" href="/articles/{{ $postarticle->id }}">BACA SELENGKAPNYA<i class="fa fa-arrow-right ms-3"></i></a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <h3>Artikel Belum Tersedia</h3>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endif

@if((new \Jenssegers\Agent\Agent())->isMobile())
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-end mb-5 wow fadeInUp" data-wow-delay="0.5s">
            <div class="col-12" style="margin-bottom: -5px;">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h6 class="text-body text-uppercase mb-2 mobile-font-2">&mdash; Artikel</h6>
                    <h1 class="display-6 mb-0 mobile-font-4">
                        Karya Tulis Anggota <br> UKM LDK Syahid
                    </h1>
                </div>
                <p class="mb-2 mt-1 mobile-font-2" style="text-align: justify">
                    Artikel ini merupakan Hasil Karya Tulis dari para Anggota UKM LDK Syahid yang memiliki kemampuan dan sederet Prestasi dibidang Karya Tulis
                </p>
            </div>
            <div class="mt-2">
                <div class="owl-article owl-carousel owl-theme">
                @forelse($postarticle as $key => $postarticle)
                <div class="item">
                    <div class="my-3">
                        <a href="/articles/{{ $postarticle->id }}" class="d-flex justify-content-center"><img class="shadow" src="https://lh3.googleusercontent.com/d/{{ $postarticle->gdrive_id }}" alt="{{$postarticle->title}}" style="width: 100%; border-radius: 2%;" /></a>
                    </div>
                </div>
                @empty
                <div class="text-center">
                    <h3>Artikel Belum Tersedia</h3>
                </div>
                @endforelse
                <div class="item">
                    <div class="my-3">
                        <div class="d-flex justify-content-center" style="margin-top:115px;">
                            <a href="/articles"><i class="fas fa-angle-right fa-4x text-primary flex-shrink-0 me-3"></i></a>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
<!-- Article End -->
