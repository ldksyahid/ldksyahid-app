@if((new \Jenssegers\Agent\Agent())->isDesktop())
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-end mb-5">
            <div class="col-lg-3 text-lg-start wow fadeInUp" data-wow-delay="0.3s">
                <a class="btn btn-primary py-3 px-5" href="/events">Kegiatan Lainnya</a>
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
            <div class="col-lg-2 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                @if ($postevent->start != null)
                <div class="ps-4">
                    <h5 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postevent->start )->format('Y') }}</h5>
                    <h6 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('MMMM') }}</h6>
                    <h1 class="display-6 mb-0">{{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('DD') }}</h1>
                    <p class="mb-0">{{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('dddd') }}</p>
                </div>
                @else
                <div class="ps-4">
                    <h5 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postevent->dateevent )->format('Y') }}</h5>
                    <h6 class="text-body text-uppercase mb-2">{{ \Carbon\Carbon::parse( $postevent->dateevent )->isoFormat('MMMM') }}</h6>
                    <h1 class="display-6 mb-0">{{ \Carbon\Carbon::parse( $postevent->dateevent )->isoFormat('DD') }}</h1>
                    <p class="mb-0">{{ \Carbon\Carbon::parse( $postevent->dateevent )->isoFormat('dddd') }}</p>
                </div>
                @endif
            </div>
            <div class="col-lg-6 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
                <div class=" mb-3">
                <h6 class="text-body text-uppercase mb-2">{{ $postevent->division }}</h6>
                <a href="/events/{{ $postevent->id }}"><h1 class="display-6 mb-0" style="text-align: left">{{ $postevent->title }}</h1></a>
                </div>
                <p class="mb-1">
                    {!!  substr(strip_tags($postevent->broadcast), 0, 100) !!} …
                </p>
                <a class="mb-0" href="/events/{{ $postevent->id }}">Baca Selengkapnya</a>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                <a href="/events/{{ $postevent->id }}"><img src="https://drive.google.com/thumbnail?id={{ $postevent->gdrive_id }}" alt="{{ $postevent->title }}" class="img-fluid" width="300px" height="400px"></a>
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
@endif

@if((new \Jenssegers\Agent\Agent())->isMobile())
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-end mb-2 wow fadeInUp" data-wow-delay="0.5s">
            <div class="col-12 text-end">
                <div class="border-end border-5 border-primary px-4">
                    <h6 class="text-body text-uppercase mb-2 mobile-font-2">Yuk Ikuti Kegiatan Kami!</h6>
                    <h1 class="display-6 mb-0 mobile-font-4">
                        Kegiatan Terbaru Kami
                    </h1>
                </div>
                <div>
                    <p class="mb-0 mt-1 mobile-font-2" style="text-align: justify">
                        Kegiatan Terbaru UKM LDK Syahid untuk Kamu yang ingin menambah Teman dan Ilmu
                    </p>
                </div>
            </div>
            <div class="mt-4">
                <div class="owl-event owl-carousel owl-theme">
                @forelse($postevent as $key => $postevent)
                <div class="item">
                    <div class="my-3">
                        <a href="/events/{{ $postevent->id }}" class="d-flex justify-content-center"><img class="shadow" src="{{ asset($postevent->poster) }}" alt="{{ $postevent->title }}" style="width: 65%; border-radius: 2%;" /></a>
                    </div>
                    <div>
                        <div class="row pb-2">
                            <div class="col-6">
                                @if ($postevent->tag != null)
                                <button type="button" class="btn btn-outline-secondary mobile-font-1" style="border-radius: 5px; padding:2px 10px; font-size:12px;" disabled>{{ $postevent->tag }}</button>
                                @else
                                <button type="button" class="btn btn-outline-secondary mobile-font-1" style="border-radius: 5px; padding:2px 10px; font-size:12px;" disabled>Seminar</button>
                                @endif
                            </div>
                            <div class="col-6 mt-1 text-end mobile-body-font">
                                <u>{{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('DD') }} {{ \Carbon\Carbon::parse( $postevent->start )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postevent->start )->format('Y') }}</u>
                            </div>
                        </div>
                        <h2 class="mb-2 mobile-font-3">{{ $postevent->title }}</h2>
                        <p class="mobile-body-font">Diselenggarakan oleh: {{ $postevent->division }}</p>
                    </div>
                </div>
                @empty
                <h3>Kegiatan Belum Tersedia</h3>
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
