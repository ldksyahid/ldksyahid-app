<!-- Article Start -->
@if((new \Jenssegers\Agent\Agent())->isDesktop())
<div class="py-5">
    <div class="container">
        <div class="row align-items-center mb-5 wow fadeInUp" data-wow-delay="0.5s">
            <div class="col-lg-8">
                <h6 class="text-primary text-uppercase mb-2">Artikel</h6>
                <h2 class="fw-bold mb-2">Karya Tulis Anggota LDK Syahid</h2>
                <p class="text-muted" style="text-align: justify;">
                    Artikel-artikel ini adalah hasil tulisan para anggota UKM LDK Syahid yang penuh semangat dan prestasi.
                </p>
            </div>
            <div class="col-lg-4 text-lg-end mt-3 mt-lg-0">
                <a href="/articles" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium shadow-sm">
                    Lihat Semua Artikel <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <div class="row g-4 justify-content-center">
            @forelse($postarticle as $post)
            <div class="col-lg-4 col-md-6">
                <div class="card h-100 border-0 shadow rounded-4 overflow-hidden article-card wow fadeInUp" data-wow-delay="0.5s">
                    <a href="/articles/{{ $post->id }}">
                        <div class="ratio ratio-16x9">
                            <img src="https://lh3.googleusercontent.com/d/{{ $post->gdrive_id }}"
                                 alt="{{ $post->title }}"
                                 class="w-100 h-100 object-fit-cover">
                        </div>
                    </a>
                    <div class="card-body d-flex flex-column justify-content-between">
                        <p class="text-muted small text-end mb-1">
                            {{ \Carbon\Carbon::parse($post->dateevent)->isoFormat('dddd, D MMMM Y') }}
                        </p>
                        <h6 class="text-uppercase text-primary mb-1">{{ $post->theme }}</h6>
                        <h5 class="fw-bold mb-2">
                            <a href="/articles/{{ $post->id }}" class="text-dark text-decoration-none">{{ $post->title }}</a>
                        </h5>
                        <p class="text-muted small mb-0">Penulis: {{ $post->writer }}</p>
                        <p class="text-muted small">Editor: {{ $post->editor }}</p>
                        <div class="text-end mt-auto">
                            <a href="/articles/{{ $post->id }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                Baca Selengkapnya <i class="fa fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <h4 class="text-muted">Artikel Belum Tersedia</h4>
            </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .object-fit-cover {
        object-fit: cover;
         object-position: top;
    }
    .article-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .article-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .ratio.ratio-16x9 {
        height: 450px;
    }
</style>
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
