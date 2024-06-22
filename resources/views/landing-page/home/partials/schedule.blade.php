@if((new \Jenssegers\Agent\Agent())->isDesktop())
<!-- Article Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-end mb-5">
            <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4">
                    <h6 class="text-body text-uppercase mb-2">Jadwal</h6>
                    <h1 class="display-6 mb-0">
                        Jadwal Terbaru Kami
                    </h1>
                    <p class="mb-0 mt-1" style="text-align: justify">
                        Yuk catet tanggalnya biar kamu gak ketinggalan Kegiatan UKM LDK Syahid
                    </p>
                </div>
            </div>
        </div>
        <div class="row g-4 justify-content-center">
            @forelse($postschedule as $key => $postschedule)
            <div class="row g-5 mt-3">
                <div class="col-lg-9 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <img src="https://lh3.googleusercontent.com/d/{{ $postschedule->gdrive_id }}" alt="{{ $postschedule->title }}" class="img-fluid rounded" width="1080px" height="1350px">
                </div>
                <div class="col-lg-3 col-md-6 wow fadeInDown" data-wow-delay="0.5s">
                    <div class="ps-3 mb-5 text-center">
                        <h5 class="text-body mb-2">Jadwal LDK Syahid</h5>
                        <h6 class="text-body mb-2">Edisi</h6>
                        <h1 class=" mb-0 text-uppercase">{{ $postschedule->month }}</h3>
                        <p class="mb-0">{{ $postschedule->year }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="row g-5 mt-3 text-center wow fadeInUp" data-wow-delay="0.1s">
                <h3>Jadwal Belum Tersedia</h3>
            </div>
            @endforelse
        </div>
    </div>
</div>
<!-- Article End -->
@endif

@if((new \Jenssegers\Agent\Agent())->isMobile())
<!-- Article Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 align-items-end wow fadeInUp" data-wow-delay="0.5s" style="margin-bottom:-40px;">
            <div class="col-lg-12">
                <div class="border-start border-5 border-primary ps-4">
                    <h6 class="text-body text-uppercase mb-2 mobile-font-2">Jadwal &mdash;</h6>
                    <h1 class="display-6 mb-0 mobile-font-4">
                        Jadwal Terbaru Kami
                    </h1>
                </div>
                <p class="mb-0 mt-2" style="text-align: justify mobile-font-2">
                    Yuk catet tanggalnya biar kamu gak ketinggalan Kegiatan UKM LDK Syahid
                </p>
            </div>
            <div>
                @forelse($postschedule as $key => $postschedule)
                <div>
                    <div class="col-lg-9">
                        <img src="https://lh3.googleusercontent.com/d/{{ $postschedule->gdrive_id }}" alt="{{ $postschedule->title }}" class="img-fluid shadow" width="100%" style="border-radius: 2%">
                    </div>
                </div>
                @empty
                <div class="text-center">
                    <h3>Jadwal Belum Tersedia</h3>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
<!-- Article End -->
@endif
