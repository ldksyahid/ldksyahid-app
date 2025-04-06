@if((new \Jenssegers\Agent\Agent())->isDesktop())
<div class="py-5">
    <div class="container bg-white testimonial-card p-5 shadow rounded-4">
        <div class="row g-5">
            <!-- Side Content -->
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-4">
                    <h6 class="text-body text-uppercase mb-2">Apa Kata Mereka?</h6>
                    <h1 class="display-6 mb-0">Kenapa Mereka Memilih UKM LDK Syahid?</h1>
                </div>
                <p class="mb-4 text-muted text-justify">
                    Banyak dari Mahasiswa/i UIN Syarif Hidayatullah Jakarta bergabung bersama UKM LDK Syahid karena ingin belajar dan berkembang bersama-sama di lingkungan Islami.
                </p>
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-users fa-2x text-primary flex-shrink-0"></i>
                            <h1 class="ms-3 mb-0">1000+</h1>
                        </div>
                        <h6 class="mb-0 text-secondary">Anggota Aktif</h6>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-gift fa-2x text-primary flex-shrink-0"></i>
                            <h1 class="ms-3 mb-0">1001</h1>
                        </div>
                        <h6 class="mb-0 text-secondary">Berbagi Manfaat</h6>
                    </div>
                </div>
            </div>

            <!-- Carousel Testimoni -->
            <div class="col-lg-7 wow fadeInDown" data-wow-delay="0.5s">
                <div class="owl-carousel testimonial-carousel bg-white shadow-sm px-2 py-4 rounded-4 overflow-hidden">
                    @forelse($posttestimony as $posttestimony)
                    <div class="testimonial-item p-4 bg-light position-relative transition-hover h-100 rounded-4">
                        <img class="img-fluid mb-3 rounded-circle border border-primary border-3 shadow-sm testimonial-img"
                             src="https://lh3.googleusercontent.com/d/{{ $posttestimony->gdrive_id }}"
                             alt="Foto Testimoni"
                             style="width: 100px; height: 100px;" />
                        <p class="fs-6 fst-italic text-dark">"{{ $posttestimony->testimony }}"</p>
                        <div class="bg-primary mb-2" style="width: 50px; height: 4px; border-radius: 2px;"></div>
                        <h5 class="mb-1 text-primary">{{ $posttestimony->name }}</h5>
                        <span class="text-muted small">{{ $posttestimony->profession }}</span>
                    </div>
                    @empty
                    <div class="testimonial-item text-center p-5 bg-light rounded-4">
                        <h5 class="text-muted">Testimoni Belum Tersedia</h5>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .transition-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        border-radius: 1rem;
    }

    .transition-hover:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 24px rgba(0, 0, 0, 0.1);
    }

    .testimonial-carousel,
    .testimonial-item,
    .testimonial-img {
        border-radius: 1rem !important;
    }

    .testimonial-img {
        object-fit: cover;
        width: 100px;
        height: 100px;
    }

    .testimonial-card {
        border-radius: 18px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
</style>
@endif

@if((new \Jenssegers\Agent\Agent())->isMobile())
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-12 wow fadeInUp" data-wow-delay="0.5s">
                <div class="border-start border-5 border-primary ps-4 mb-2">
                    <h6 class="text-body text-uppercase mb-2 mobile-font-2">Apa Kata Mereka?</h6>
                    <h1 class="display-6 mb-0 mobile-font-4">Kenapa Mereka Memilih UKM LDK Syahid?</h1>
                </div>
                <p class="mb-4 mobile-font-2" style="text-align: justify">
                    Banyak dari Mahasiswa/i UIN Syarif Hidayatullah Jakarta Bergabung bersama UKM LDK Syahid karena ingin belajar dan berkembang bersama-sama didalam lingkungan Islami
                </p>
                <div class="row g-4">
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-users fa-2x text-primary flex-shrink-0"></i>
                            <h1 class="ms-3 mb-0 mobile-font-1">1000+</h1>
                        </div>
                        <h5 class="mb-0 mobile-font-2">Anggota</h5>
                    </div>
                    <div class="col-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-gift fa-2x text-primary flex-shrink-0"></i>
                            <h1 class="ms-3 mb-0 mobile-font-1">1001</h1>
                        </div>
                        <h5 class="mb-0 mobile-font-2">Berbagi Manfaat</h5>
                    </div>
                </div>
                <div class="col-12 mt-4">
                    <div class="owl-testimony owl-carousel owl-theme">
                    @forelse($posttestimony as $key => $posttestimony)
                    <div class="item card shadow my-4 mx-3">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-4">
                                    <img class="img-fluid mb-4" src="https://lh3.googleusercontent.com/d/{{ $posttestimony->gdrive_id }}" alt="" style="border-radius:2px;"/>
                                </div>
                                <div class="col-8">
                                    <h5 class="mobile-font-3">{{$posttestimony->name}}</h5>
                                    <p class="mobile-font-profesion pt-0" >{{$posttestimony->profession}}</p>
                                </div>
                            </div>
                            <div class="bg-primary mb-3" style="width: 60px; height: 5px"></div>
                            <p class="mobile-body-font" style="text-align: justify">
                                {{$posttestimony->testimony}}
                            </p>
                        </div>
                    </div>
                    @empty
                    <div class="text-center">
                        <h3>Testimoni Belum Tersedia</h3>
                    </div>
                    @endforelse
                    </div>
                </div>
            </div>
            {{-- <div class="col-12">
                <div class="owl-carousel testimonial-carousel">
                    @forelse($posttestimony as $key => $posttestimony)
                    <div class="testimonial-item">
                        <img
                            class="img-fluid mb-4"
                            src="{{ asset($posttestimony->picture) }}"
                            alt=""
                        />
                        <p class="fs-5 small">
                            {{$posttestimony->testimony}}
                        </p>
                        <div class="bg-primary mb-3" style="width: 60px; height: 5px"></div>
                        <h5>{{$posttestimony->name}}</h5>
                        <span>{{$posttestimony->profession}}</span>
                    </div>
                    @empty
                    <div class="testimonial-item">
                        <h3>Testimoni Belum Tersedia</h3>
                    </div>
                    @endforelse
                </div>
            </div> --}}
        </div>
    </div>
</div>
@endif
<!-- Testimonial End -->
