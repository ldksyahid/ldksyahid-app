@if((new \Jenssegers\Agent\Agent())->isDesktop())

<!-- Hover Animation Style -->
<style>
    .event-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 12px; /* bisa kamu atur, misalnya 8px, 16px, dst */
    }

    .event-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .event-image {
        transition: transform 0.3s ease;
        border-radius: 12px;
    }

    .event-image:hover {
        transform: scale(1.05);
    }
</style>

<div class="py-5">
    <div class="container">
        <div class="row mb-5 align-items-center justify-content-between wow fadeInUp" data-wow-delay="0.5s">
            <div class="col-lg-8">
                <h6 class="text-primary text-uppercase">Yuk Ikuti Kegiatan Kami!</h6>
                <h1 class="display-5 fw-bold">Kegiatan Terbaru Kami</h1>
                <p class="text-muted">Kegiatan terbaru UKM LDK Syahid untuk kamu yang ingin menambah teman dan ilmu</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="/events" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium shadow-sm">
                    Lihat Semua Kegiatan <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        @forelse($postevent as $event)
        @php $date = \Carbon\Carbon::parse($event->start ?? $event->dateevent); @endphp
        <div class="row mb-4 align-items-center bg-white shadow p-3 overflow-hidden wow fadeInUp event-card" data-wow-delay="0.5s">
            <!-- Text Content -->
            <div class="col-lg-8">
                <div class="d-flex align-items-center mb-2">
                    <div class="text-center me-4 border-end pe-4">
                        <div class="fw-bold text-primary fs-3">{{ $date->format('d') }}</div>
                        <small class="text-muted d-block">{{ $date->isoFormat('MMMM Y') }}</small>
                        <div class="text-muted small">{{ $date->isoFormat('dddd') }}</div>
                    </div>
                    <div>
                        <span class="badge bg-primary mb-2 rounded-pill">{{ $event->division }}</span>
                        <h4 class="fw-bold mb-1">
                            <a href="/events/{{ $event->id }}" class="text-dark text-decoration-none">{{ $event->title }}</a>
                        </h4>
                        <p class="text-muted mb-2" style="max-width: 90%">
                            {!! \Illuminate\Support\Str::limit(strip_tags($event->broadcast), 120, '...') !!}
                        </p>
                        <a href="/events/{{ $event->id }}" class="text-primary fw-semibold">Baca Selengkapnya</a>
                    </div>
                </div>
            </div>
            <!-- Image -->
            <div class="col-lg-4 text-end">
                <a href="/events/{{ $event->id }}">
                    <img src="https://lh3.googleusercontent.com/d/{{ $event->gdrive_id }}" alt="{{ $event->title }}"
                         class="img-fluid shadow-sm event-image" style="max-height: 220px; object-fit: cover;">
                </a>
            </div>
        </div>
        @empty
        <div class="text-center py-5">
            <h5 class="text-muted">Kegiatan Belum Tersedia</h5>
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
                        <a href="/events/{{ $postevent->id }}" class="d-flex justify-content-center"><img class="shadow" src="https://lh3.googleusercontent.com/d/{{ $postevent->gdrive_id }}" alt="{{ $postevent->title }}" style="width: 65%; border-radius: 2%;" /></a>
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
