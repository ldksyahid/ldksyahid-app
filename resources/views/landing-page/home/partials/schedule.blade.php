@if((new \Jenssegers\Agent\Agent())->isDesktop())
<!-- Jadwal Section Start -->
<style>
    .schedule-card {
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .schedule-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
    }

    .schedule-image {
        width: 100%;
        height: auto;
        object-fit: cover;
        border-top-left-radius: 18px;
        border-bottom-left-radius: 18px;
    }

    .schedule-info {
        border-left: 4px solid #00a79d;
        padding-left: 20px;
    }
</style>

<div class="py-5">
    <div class="container">
        <!-- Heading -->
        <div class="row mb-5 align-items-center justify-content-between wow fadeInUp" data-wow-delay="0.5s">
            <div class="col-lg-8">
                <h6 class="text-primary text-uppercase">Yuk Catat Jadwalnya!</h6>
                <h1 class="display-5 fw-bold">Jadwal Terbaru Kami</h1>
                <p class="text-muted">Jadwal kegiatan UKM LDK Syahid terbaru agar kamu gak ketinggalan info penting</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="/schedule" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium shadow-sm">
                    Lihat Semua Jadwal <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>


        <!-- Content -->
        @forelse($postschedule as $key => $postschedule)
        <div class="row g-4 align-items-center schedule-card bg-white shadow p-3 mb-4 wow fadeInUp" data-wow-delay="0.2s">
            <!-- Image -->
            <div class="col-lg-9">
                <img src="https://lh3.googleusercontent.com/d/{{ $postschedule->gdrive_id }}" alt="{{ $postschedule->title }}" class="img-fluid schedule-image">
            </div>
            <!-- Info -->
            <div class="col-lg-3 text-center schedule-info">
                <h5 class="text-muted">Jadwal LDK Syahid</h5>
                <h6 class="text-secondary mb-1">Edisi</h6>
                <h2 class="text-uppercase text-primary fw-bold">{{ $postschedule->month }}</h2>
                <p class="text-muted mb-0">{{ $postschedule->year }}</p>
            </div>
        </div>
        @empty
        <div class="row text-center wow fadeInUp" data-wow-delay="0.1s">
            <h4 class="text-muted">Jadwal Belum Tersedia</h4>
        </div>
        @endforelse
    </div>
</div>
<!-- Jadwal Section End -->
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
