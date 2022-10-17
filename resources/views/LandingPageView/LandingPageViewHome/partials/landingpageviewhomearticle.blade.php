<!-- Article Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-end mb-5">
            <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4">
                    <h6 class="text-body text-uppercase mb-2">Artikel</h6>
                    <h1 class="display-6 mb-0">
                        Karya Tulis Anggota UKM LDK Syahid
                    </h1>
                    <p class="mb-0 mt-1" style="text-align: justify">
                        Artikel ini merupakan Hasil Karya Tulis murni dari para Anggota UKM LDK Syahid yang memiliki kemampuan dibidang Karya Tulis
                    </p>
                </div>
            </div>
            <div class="col-lg-5 text-lg-end wow fadeInUp" data-wow-delay="0.3s">
                <a class="btn btn-primary py-3 px-5" href="/article">Artikel Lainnya</a>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            @forelse($postarticle as $key => $postarticle)
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="service-item bg-light overflow-hidden h-100">
                    <img class="img-fluid" src="{{ asset($postarticle->poster) }}" alt="{{$postarticle->title}}" />
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
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <h3>Artikel Belum Tersedia</h3>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Article End -->
