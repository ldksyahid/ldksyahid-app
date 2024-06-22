@if((new \Jenssegers\Agent\Agent())->isDesktop())
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f5f6fa" fill-opacity="1" d="M0,160L30,181.3C60,203,120,245,180,256C240,267,300,245,360,202.7C420,160,480,96,540,80C600,64,660,96,720,128C780,160,840,192,900,192C960,192,1020,160,1080,144C1140,128,1200,128,1260,144C1320,160,1380,192,1410,208L1440,224L1440,320L1410,320C1380,320,1320,320,1260,320C1200,320,1140,320,1080,320C1020,320,960,320,900,320C840,320,780,320,720,320C660,320,600,320,540,320C480,320,420,320,360,320C300,320,240,320,180,320C120,320,60,320,30,320L0,320Z"></path></svg>
<div class="container-xxl py-5" style="background-color: #f5f6fa">
    <div class="container">
        <div class="row g-5 align-items-end mb-5">
            <div class="col-lg-3 text-lg-start wow fadeInUp" data-wow-delay="0.3s">
                <a class="btn btn-primary py-3 px-5" href="/news">Berita Lainnya</a>
            </div>
            <div class="col-lg-9 wow fadeInUp text-end" data-wow-delay="0.1s">
                <div class="border-end border-5 border-primary px-4">
                    <h6 class="text-body text-uppercase mb-2">Berita</h6>
                    <h1 class="display-6 mb-0">
                        Berita Terbaru dari Kami
                    </h1>
                    <p class="mb-0 mt-1">
                        Berita Terbaru yang di publish oleh kami untuk kamu yang ketinggalan Informasi
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-5">
            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                @forelse($postnews as $key => $postnews)
                <div class="mb-4">
                    <h4 class=" mb-1"><a href="/news/{{ $postnews->id }}">{{ $postnews->title }}</a></h4>
                    <h6 class="text-body mb-1">{{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('D') }} {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('Y') }}</h6>
                    <p class="mb-0" style="text-align: justify">{{ $postnews->title }} Reporter {{ $postnews->reporter }}; Editor {{ $postnews->editor }} {!!  substr(strip_tags($postnews->body), 0, 80) !!} … <a href="/news/{{ $postnews->id }}/show">Selanjutnya</a></p>
                </div>
                @empty
                    <h3 class="text-center">Berita Belum Tersedia</h3>
                @endforelse
            </div>
        </div>
    </div>
</div>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f5f6fa" fill-opacity="1" d="M0,64L17.1,101.3C34.3,139,69,213,103,208C137.1,203,171,117,206,85.3C240,53,274,75,309,80C342.9,85,377,75,411,80C445.7,85,480,107,514,112C548.6,117,583,107,617,96C651.4,85,686,75,720,80C754.3,85,789,107,823,128C857.1,149,891,171,926,149.3C960,128,994,64,1029,37.3C1062.9,11,1097,21,1131,26.7C1165.7,32,1200,32,1234,58.7C1268.6,85,1303,139,1337,160C1371.4,181,1406,171,1423,165.3L1440,160L1440,0L1422.9,0C1405.7,0,1371,0,1337,0C1302.9,0,1269,0,1234,0C1200,0,1166,0,1131,0C1097.1,0,1063,0,1029,0C994.3,0,960,0,926,0C891.4,0,857,0,823,0C788.6,0,754,0,720,0C685.7,0,651,0,617,0C582.9,0,549,0,514,0C480,0,446,0,411,0C377.1,0,343,0,309,0C274.3,0,240,0,206,0C171.4,0,137,0,103,0C68.6,0,34,0,17,0L0,0Z"></path></svg>
@endif


@if((new \Jenssegers\Agent\Agent())->isMobile())
<div class="container-xxl py-3" style="background-color: #f5f6fa">
    <div class="container">
        <div class="row g-5 mb-5 wow fadeInUp" data-wow-delay="0.5s">
            <div class="col col-12 text-end">
                <div class="border-end border-5 border-primary px-4">
                    <h6 class="text-body text-uppercase mb-2 mobile-font-2">&mdash; Berita</h6>
                    <h1 class="display-6 mb-0 mobile-font-4">
                        Berita Terbaru <br> dari Kami
                    </h1>
                </div>
                <p class="mb-0 mt-1 mobile-font-2">
                    Berita Terbaru yang di publish oleh kami untuk kamu yang ketinggalan Informasi
                </p>
            </div>
            <div class="col-lg-12 mt-4">
                @forelse($postnews as $key => $postnews)
                <div class="row">
                    <div class="col-5" style="padding-right:2.5px">
                        <div>
                            <a href="/news/{{ $postnews->id }}"><img src="https://lh3.googleusercontent.com/d/{{ $postnews->gdrive_id }}" alt="" class="card-img w-100" style="border-radius: 5px;"></a>
                        </div>
                    </div>
                    <div class="col-7" style="padding-left:2.5px;">
                        <div style="">
                            <a href="/news/{{ $postnews->id }}"><h1 class="display-6 mb-0 mobile-font-2 text-primary">{{ $postnews->title }}</h1></a>
                            <p class="mobile-font-1">{!!  substr(strip_tags($postnews->body), 0, 60) !!} <br> <span style="font-size: 10px;">({{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('dddd') }}, {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('D') }} {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('MMMM') }} {{ \Carbon\Carbon::parse( $postnews->datepublish )->isoFormat('Y') }})</span></p>
                        </div>
                    </div>
                </div>
                <hr>
                @empty
                    <h3 class="text-center">Berita Belum Tersedia</h3>
                @endforelse
                <div class="text-center">
                    <a href="/news"><i class="fas fa-angle-down fa-2x text-primary flex-shrink-0 me-3"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
