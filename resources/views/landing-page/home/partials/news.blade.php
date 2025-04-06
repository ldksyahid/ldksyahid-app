@if((new \Jenssegers\Agent\Agent())->isDesktop())
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f5f6fa" fill-opacity="1" d="M0,160L30,181.3C60,203,120,245,180,256C240,267,300,245,360,202.7C420,160,480,96,540,80C600,64,660,96,720,128C780,160,840,192,900,192C960,192,1020,160,1080,144C1140,128,1200,128,1260,144C1320,160,1380,192,1410,208L1440,224L1440,320L0,320Z"></path></svg>

    <div class="py-5" style="background-color: #f5f6fa">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-5">
            <div>
                <h6 class="text-uppercase text-primary fw-bold mb-2">Berita</h6>
                <h2 class="fw-bold mb-2">Berita Terbaru dari Kami</h2>
                <p class="text-muted mb-0">Berita Terbaru yang di-publish oleh kami untuk kamu yang ketinggalan informasi.</p>
            </div>
            <div>
                <a href="/news" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium shadow-sm">
                    Lihat Semua Berita <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <div class="row g-4">
            @forelse($postnews as $key => $postnews)
            <div class="col-12">
                <div class="card border-0 shadow rounded-4 overflow-hidden mb-4 news-card wow fadeInUp" data-wow-delay="0.5s">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <a href="/news/{{ $postnews->id }}">
                                <img src="https://lh3.googleusercontent.com/d/{{ $postnews->gdrive_id }}" alt="{{ $postnews->title }}" class="img-fluid h-100 w-100 object-fit-cover">
                            </a>
                        </div>
                        <div class="col-md-8 d-flex flex-column justify-content-between p-4">
                            <div>
                                <h5 class="text-primary fw-bold mb-2">
                                    <a href="/news/{{ $postnews->id }}" class="text-decoration-none text-primary">{{ $postnews->title }}</a>
                                </h5>
                                <p class="text-muted small mb-2">
                                    {{ \Carbon\Carbon::parse($postnews->datepublish)->isoFormat('dddd, D MMMM Y') }}
                                </p>
                                <p class="text-muted" style="text-align: justify;">
                                    Reporter {{ $postnews->reporter }}; Editor {{ $postnews->editor }} <br>
                                    {!! substr(strip_tags($postnews->body), 0, 120) !!}… <a href="/news/{{ $postnews->id }}/show">Selanjutnya</a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
                <h3 class="text-center">Berita Belum Tersedia</h3>
            @endforelse
        </div>
    </div>
</div>

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f5f6fa" fill-opacity="1" d="M0,64L17.1,101.3C34.3,139,69,213,103,208C137.1,203,171,117,206,85.3C240,53,274,75,309,80C342.9,85,377,75,411,80C445.7,85,480,107,514,112C548.6,117,583,107,617,96C651.4,85,686,75,720,80C754.3,85,789,107,823,128C857.1,149,891,171,926,149.3C960,128,994,64,1029,37.3C1062.9,11,1097,21,1131,26.7C1165.7,32,1200,32,1234,58.7C1268.6,85,1303,139,1337,160C1371.4,181,1406,171,1423,165.3L1440,160L1440,0L1422.9,0C1405.7,0,1371,0,1337,0C1302.9,0,1269,0,1234,0C1200,0,1166,0,1131,0C1097.1,0,1063,0,1029,0C994.3,0,960,0,926,0C891.4,0,857,0,823,0C788.6,0,754,0,720,0C685.7,0,651,0,617,0C582.9,0,549,0,514,0C480,0,446,0,411,0C377.1,0,343,0,309,0C274.3,0,240,0,206,0C171.4,0,137,0,103,0C68.6,0,34,0,17,0L0,0Z"></path></svg>

<style>
    .object-fit-cover {
        object-fit: cover;
    }

    .news-card {
        transition: all 0.3s ease;
    }

    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }
</style>
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
