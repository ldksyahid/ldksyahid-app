@if((new \Jenssegers\Agent\Agent())->isDesktop())
<style>
.gallery-hover {
  transition: transform 0.4s ease, box-shadow 0.4s ease;
  border-radius: 1rem;
  cursor: pointer;
}

.gallery-hover:hover {
  transform: scale(1.03);
  box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
}

.rounded-custom {
  border-radius: 1.5rem;
}



</style>
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f5f6fa" fill-opacity="1" d="M0,192L34.3,197.3C68.6,203,137,213,206,202.7C274.3,192,343,160,411,133.3C480,107,549,85,617,112C685.7,139,754,213,823,218.7C891.4,224,960,160,1029,112C1097.1,64,1166,32,1234,37.3C1302.9,43,1371,85,1406,106.7L1440,128L1440,320L0,320Z"></path></svg>

<div style="background-color: #f5f6fa">
    <div class="container py-5">
        <div class="row mb-5 align-items-center justify-content-between wow fadeInUp" data-wow-delay="0.3s">
            <div class="col-lg-8">
                <h6 class="text-primary text-uppercase">Galeri</h6>
                <h1 class="display-5 fw-bold">Dokumentasi Kegiatan Kami</h1>
                <p class="text-muted mb-0">Dokumentasi terbaru dari kegiatan UKM LDK Syahid yang memberikan banyak manfaat untuk umat.</p>
            </div>
            <div class="col-lg-4 text-end">
                <a href="/about/gallery" class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium shadow-sm">
                    Dokumentasi Lainnya <i class="fas fa-arrow-right ms-2"></i>
                </a>
            </div>
        </div>

        <div class="row">
            @forelse($postgallery as $postgallery)
            <div class="col-12 mb-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="bg-white rounded-4 shadow p-4 rounded-custom shadow">
                    <h6 class="text-primary">{{ $postgallery->eventName }}</h6>
                    <h3 class="mb-2">{{ $postgallery->eventTheme }}</h3>
                    <p class="text-muted" style="text-align: justify">{{ $postgallery->eventDescription }}</p>

                    @if (!empty($postgallery->linkDoc))
                        <p class="mt-2">Link Dokumentasi:
                            <a href="{{ $postgallery->linkDoc }}" target="_blank" rel="noopener noreferrer">
                                {{ \Illuminate\Support\Str::limit($postgallery->linkDoc, 70, '...') }}
                            </a>
                        </p>
                    @endif

                    <div class="row g-3 mt-3">
                        @if ($postgallery->gdrive_id)
                        <div class="col-lg-12">
                            <div class="position-relative overflow-hidden rounded-4 gallery-hover">
                                <img class="img-fluid w-100 rounded-4" src="https://lh3.googleusercontent.com/d/{{ $postgallery->gdrive_id }}" alt="Main photo">
                            </div>
                        </div>
                        @endif

                        @for($i = 1; $i <= 12; $i++)
                            @php $gdriveKey = 'gdrive_id_' . $i; @endphp
                            @if ($postgallery->$gdriveKey)
                            <div class="col-lg-4 col-md-6 col-sm-6">
                                <div class="overflow-hidden rounded-4 gallery-hover">
                                    <img class="img-fluid w-100 rounded-4" src="https://lh3.googleusercontent.com/d/{{ $postgallery->$gdriveKey }}" alt="Photo {{ $i }}">
                                </div>
                            </div>
                            @endif
                        @endfor

                        @if ($postgallery->linkEmbedYoutube)
                        <div class="col-lg-12 mt-4">
                            <div class="ratio ratio-16x9 rounded-4 overflow-hidden gallery-hover">
                                <iframe class="rounded-4" src="{{ $postgallery->linkEmbedYoutube }}" title="YouTube video player" allowfullscreen></iframe>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center">
                <h4 class="text-muted">Dokumentasi Kegiatan Belum Tersedia</h4>
            </div>
            @endforelse
        </div>
    </div>
</div>

<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f5f6fa" fill-opacity="1" d="M0,192L34.3,192C68.6,192,137,192,206,208C274.3,224,343,256,411,245.3C480,235,549,181,617,144C685.7,107,754,85,823,74.7C891.4,64,960,64,1029,96C1097.1,128,1166,192,1234,186.7C1302.9,181,1371,107,1406,69.3L1440,32L1440,0L0,0Z"></path></svg>
@endif



@if((new \Jenssegers\Agent\Agent())->isMobile())
<div class="container-xxl" style="background-color: #f5f6fa">
    <div class="container">
        <div class="row g-5 align-items-end mb-5 wow fadeInUp" data-wow-delay="0.5s">
            <div class="col-12">
                <div class="border-end border-5 mt-5 border-primary px-4 text-end">
                    <h6 class="text-body text-uppercase mb-2 mobile-font-2">&mdash; Galeri</h6>
                    <h1 class="display-6 mb-0 mobile-font-4">
                        Dokumentasi <br> Kegiatan Kami
                    </h1>
                </div>
                <p class="mb-0 mt-2 mobile-font-2 text-center">
                    Dokumentasi Terbaru dari kegiatan UKM LDK Syahid yang memberikan banyak Manfaat untuk Umat
                </p>
            </div>
            <div class="mt-3">
                @forelse($postgallery as $key => $postgallery)
                <div class="mb-3">
                   <h6 class="text-body mobile-font-1 text-center">{{ $postgallery->eventName }}</h6>
                    <h3 class="mb-0 mobile-font-2">{{ $postgallery->eventTheme }}</h3>
                    @if (!empty($postgallery->linkDoc))
                    <div class="mobile-font-1">
                        <p>Link Dokumentasi : <a href="{{ $postgallery->linkDoc }}" target="_blank" rel="noopener noreferrer">{{ \Illuminate\Support\Str::limit($postgallery->linkDoc, 40, '...') }}</a></p>
                    </div>
                    @endif
                </div>
                <div class="col-12 mb-3 text-start" data-wow-delay="0.1s">
                    <div class="row g-0">
                        <div class="col-12 wow fadeIn" data-wow-delay="0.1s">
                            <div class="position-relative m-1">
                                <img class="img-fluid w-100" src="https://lh3.googleusercontent.com/d/{{ $postgallery->gdrive_id }}" alt="" width="700" height="500"/>
                            </div>
                        </div>
                        @for($i = 1; $i <= 12; $i++)
                            @php $gdriveKey = 'gdrive_id_' . $i; @endphp
                            @if ($postgallery->$gdriveKey)
                            <div class="col-6 wow fadeIn" data-wow-delay="0.1s">
                                <div class="position-relative m-1 img-hover-zoom">
                                    <img class="img-fluid w-100" src="https://lh3.googleusercontent.com/d/{{ $postgallery->$gdriveKey }}" alt="Photo {{ $i }}" />
                                </div>
                            </div>
                            @endif
                        @endfor
                        @if ($postgallery->linkEmbedYoutube == null)

                        @else
                        <div class="col-12 wow fadeIn" data-wow-delay="0.1s" style="margin-top:-60px;">
                            <div class="position-relative m-1 img-hover-zoom text-ceter">
                                <iframe  data-wow-delay="0.1s" width="100%" height="225px" src="{{ $postgallery->linkEmbedYoutube }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
                @empty
                <div class="col-lg-12 col-md-6 wow fadeInUp mb-5" data-wow-delay="0.1s" style="text-align: center">
                    <h3>Dokumentasi Kegiatan Belum Tersedia</h3>
                </div>
                @endforelse
                <div class="text-center col-12 mb-5" data-wow-delay="0.1s">
                    <a href="/about/gallery"><i class="fas fa-angle-down fa-2x text-primary flex-shrink-0 me-3"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
