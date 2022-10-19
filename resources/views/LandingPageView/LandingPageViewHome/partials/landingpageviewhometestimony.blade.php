<!-- Testimonial Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h6 class="text-body text-uppercase mb-2">Testimonial</h6>
                    <h1 class="display-6 mb-0">What Our Happy Clients Say!</h1>
                </div>
                <p class="mb-4">
                    Diam dolor diam ipsum sit. Aliqu diam amet diam et eos. Clita erat
                    ipsum et lorem et sit, sed stet lorem sit clita duo justo magna
                    dolore erat amet
                </p>
                <div class="row g-4">
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-users fa-2x text-primary flex-shrink-0"></i>
                            <h1 class="ms-3 mb-0">123+</h1>
                        </div>
                        <h5 class="mb-0">Happy Clients</h5>
                    </div>
                    <div class="col-sm-6">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa fa-check fa-2x text-primary flex-shrink-0"></i>
                            <h1 class="ms-3 mb-0">123+</h1>
                        </div>
                        <h5 class="mb-0">Projects Done</h5>
                    </div>
                </div>
            </div>
            <div class="col-lg-7 wow fadeInUp" data-wow-delay="0.5s">
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
                        <h5>Testimoni Belum Tersedia</h5>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonial End -->
