<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-end mb-5">
            <div class="col-lg-3 text-lg-start wow fadeInUp" data-wow-delay="0.3s">
                <a class="btn btn-primary py-3 px-5" href="/event">Kegiatan Lainnya</a>
            </div>
            <div class="col-lg-9 wow fadeInUp text-end" data-wow-delay="0.1s">
                <div class="border-end border-5 border-primary px-4">
                    <h6 class="text-body text-uppercase mb-2">Yuk Ikuti Kegiatan Kami!</h6>
                    <h1 class="display-6 mb-0">
                        Kegiatan Terbaru Kami
                    </h1>
                    <p class="mb-0 mt-1">
                        Kegiatan Terbaru UKM LDK Syahid untuk Kamu yang ingin menambah Teman dan Ilmu
                    </p>
                </div>
            </div>
        </div>
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
                <div class=" mb-3">
                <h6 class="text-body text-uppercase mb-2">{{ $postevent->division }}</h6>
                <h1 class="display-6 mb-0" style="text-align: left">{{ $postevent->title }}</h1>
                </div>
                <p class="mb-1">
                    {!!  substr(strip_tags($postevent->broadcast), 0, 100) !!} …
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
                <h3 class="mb-0" style="text-align: center">Kegiatan Belum Tersedia</h3>
            </div>
        </div>
        @endforelse
    </div>
</div>
