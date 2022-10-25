@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')

{{-- Jumbotron Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomejumbotron')
{{-- Jumbptron Landing Page End --}}


<!-- About Start -->
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="position-relative overflow-hidden ps-5 pt-5 h-90 " style="min-height: 500px">
                    <img class="position-absolute w-90 h-90 img-fluid" src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt=""/>
                </div>
                <div class="border-top pt-3" style="margin-top: -10%">
                    <div class="row">
                        <p style="text-align: justify">
                            LDK Syahid adalah salah satu Unit Kegiatan Mahasiswa (UKM) yang berada di Universitas Islam Negeri Syarif Hidayatullah Jakarta. UKM LDK Syahid ini bergerak
                            dalam meningkatkan wawasan keilmuan & amal ibadah, pembinaan karakter & mental, serta pengasahan minat & bakat.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
                <div class="h-100">
                    <div class="border-start border-5 border-primary ps-4 mb-5">
                        <h6 class="text-body text-uppercase mb-2">Tentang Kita</h6>
                        <h1 class="display-6 mb-0">UKM LDK Syahid UIN Syarif Hidayatullah Jakarta</h1>
                    </div>
                    <h5>Visi</h5>
                    <p style="text-align: justify">
                        Menjadikan LDK Syahid sebagai tempat lahirnya insan dakwah yang memiliki high critical thinking, inkubator pelopor Amar Ma'ruf Nahi Munkar, dan mampu
                        berkolaborasi serta berkontribusi dalam transformasi bangsa menuju Indonesia Madani
                    </p>
                    <h5>Misi</h5>
                    <ol style="text-align: justify">
                        <li>Membangungun kompetisi anggota yang rendah hati, open minded, objektif serta prestatif kontributif</li>
                        <li>Meningkatkan jiwa critical thinking internal organisasi</li>
                        <li>Pionir penebar kebermanfaatan baik skala nasional maupun internasional</li>
                        <li>Berkolaborasi dengan berbagai pihak yang menunjang aktivitas dakwah baik secara internal maupun eksternal kampus</li>
                        <li>Sebagai wadah konsolidasi para pemimpin menuju Indonesia Madani</li>
                    </ol>
                    {{-- <div class="border-top mt-3 pt-3">
                        <div class="row g-4">
                            <p style="text-align: justify">
                                LDK Syahid adalah salah satu Unit Kegiatan Mahasiswa (UKM) yang berada di Universitas Islam Negeri Syarif Hidayatullah Jakarta. <br> LDK Syahid ini bergerak
                                dalam meningkatkan wawasan keilmuan & amal ibadah, pembinaan karakter & mental, serta pengasahan minat & bakat.
                            </p>
                        </div>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About End -->

      <!-- Facts Start -->
      <div class="container-fluid my-5 p-0">
        <div class="row g-0">
          <div class="col-xl-3 col-sm-6 wow fadeIn" data-wow-delay="0.1s">
            <div class="position-relative">
              <img class="img-fluid w-100" src="{{ asset('LandingPageSource/img/fact-1.jpg') }}" alt="" />
              <div class="facts-overlay">
                <h1 class="display-1">01</h1>
                <h4 class="text-white mb-3">Construction</h4>
                <p class="text-white">
                  Aliqu diam amet diam et eos erat ipsum lorem stet lorem sit
                  clita duo justo erat amet
                </p>
                <a class="text-white small" href=""
                  >READ MORE<i class="fa fa-arrow-right ms-3"></i
                ></a>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 wow fadeIn" data-wow-delay="0.3s">
            <div class="position-relative">
              <img class="img-fluid w-100" src="{{ asset('LandingPageSource/img/fact-2.jpg') }}" alt="" />
              <div class="facts-overlay">
                <h1 class="display-1">02</h1>
                <h4 class="text-white mb-3">Mechanical</h4>
                <p class="text-white">
                  Aliqu diam amet diam et eos erat ipsum lorem stet lorem sit
                  clita duo justo erat amet
                </p>
                <a class="text-white small" href=""
                  >READ MORE<i class="fa fa-arrow-right ms-3"></i
                ></a>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 wow fadeIn" data-wow-delay="0.5s">
            <div class="position-relative">
              <img class="img-fluid w-100" src="{{ asset('LandingPageSource/img/fact-3.jpg') }}" alt="" />
              <div class="facts-overlay">
                <h1 class="display-1">03</h1>
                <h4 class="text-white mb-3">Architecture</h4>
                <p class="text-white">
                  Aliqu diam amet diam et eos erat ipsum lorem stet lorem sit
                  clita duo justo erat amet
                </p>
                <a class="text-white small" href=""
                  >READ MORE<i class="fa fa-arrow-right ms-3"></i
                ></a>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 wow fadeIn" data-wow-delay="0.7s">
            <div class="position-relative">
              <img class="img-fluid w-100" src="{{ asset('LandingPageSource/img/fact-4.jpg') }}" alt="" />
              <div class="facts-overlay">
                <h1 class="display-1">04</h1>
                <h4 class="text-white mb-3">Interior Design</h4>
                <p class="text-white">
                  Aliqu diam amet diam et eos erat ipsum lorem stet lorem sit
                  clita duo justo erat amet
                </p>
                <a class="text-white small" href=""
                  >READ MORE<i class="fa fa-arrow-right ms-3"></i
                ></a>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Facts End -->

      <!-- Features Start -->
      <div class="container-xxl py-5">
        <div class="container">
          <div class="row g-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="border-start border-5 border-primary ps-4 mb-5">
                <h6 class="text-body text-uppercase mb-2">Why Choose Us!</h6>
                <h1 class="display-6 mb-0">
                  Our Specialization And Company Features
                </h1>
              </div>
              <p class="mb-5">
                Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu
                diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet
                lorem sit clita duo justo magna dolore erat amet
              </p>
              <div class="row gy-5 gx-4">
                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.1s">
                  <div class="d-flex align-items-center mb-3">
                    <i
                      class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                    ></i>
                    <h6 class="mb-0">Large number of services provided</h6>
                  </div>
                  <span
                    >Magna sea eos sit dolor, ipsum amet ipsum lorem diam</span
                  >
                </div>
                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.2s">
                  <div class="d-flex align-items-center mb-3">
                    <i
                      class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                    ></i>
                    <h6 class="mb-0">25+ years of professional experience</h6>
                  </div>
                  <span
                    >Magna sea eos sit dolor, ipsum amet ipsum lorem diam</span
                  >
                </div>
                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.3s">
                  <div class="d-flex align-items-center mb-3">
                    <i
                      class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                    ></i>
                    <h6 class="mb-0">A large number of grateful customers</h6>
                  </div>
                  <span
                    >Magna sea eos sit dolor, ipsum amet ipsum lorem diam</span
                  >
                </div>
                <div class="col-sm-6 wow fadeIn" data-wow-delay="0.4s">
                  <div class="d-flex align-items-center mb-3">
                    <i
                      class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                    ></i>
                    <h6 class="mb-0">Always reliable and affordable prices</h6>
                  </div>
                  <span
                    >Magna sea eos sit dolor, ipsum amet ipsum lorem diam</span
                  >
                </div>
              </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
              <div
                class="position-relative overflow-hidden ps-5 pt-5 h-100"
                style="min-height: 400px"
              >
                <img
                  class="position-absolute w-100 h-100"
                  src="{{ asset('LandingPageSource/img/feature.jpg') }}"
                  alt=""
                  style="object-fit: cover"
                />
                <div
                  class="position-absolute top-0 start-0 bg-white pe-3 pb-3"
                  style="width: 200px; height: 200px"
                >
                  <div
                    class="d-flex flex-column justify-content-center text-center bg-primary h-100 p-3"
                  >
                    <h1 class="text-white">25</h1>
                    <h2 class="text-white">Years</h2>
                    <h5 class="text-white mb-0">Experience</h5>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Features End -->

{{-- Article Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomearticle')
{{-- Article Landing Page End --}}

{{-- Article Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhomecontactus')
{{-- Article Landing Page End --}}

      <!-- Team Start -->
      <div class="container-xxl py-5">
        <div class="container">
          <div class="row g-5 align-items-end mb-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="border-start border-5 border-primary ps-4">
                <h6 class="text-body text-uppercase mb-2">Our Team</h6>
                <h1 class="display-6 mb-0">Our Expert Worker</h1>
              </div>
            </div>
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.3s">
              <p class="mb-0">
                Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu
                diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet
                lorem sit clita duo justo magna dolore erat amet
              </p>
            </div>
          </div>
          <div class="row g-4">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="team-item position-relative">
                <img class="img-fluid" src="{{ asset('LandingPageSource/img/team-1.jpg') }}" alt="" />
                <div class="team-text bg-white p-4">
                  <h5>Full Name</h5>
                  <span>Engineer</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
              <div class="team-item position-relative">
                <img class="img-fluid" src="{{ asset('LandingPageSource/img/team-2.jpg') }}" alt="" />
                <div class="team-text bg-white p-4">
                  <h5>Full Name</h5>
                  <span>Engineer</span>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
              <div class="team-item position-relative">
                <img class="img-fluid" src="{{ asset('LandingPageSource/img/team-2.jpg') }}" alt="" />
                <div class="team-text bg-white p-4">
                  <h5>Full Name</h5>
                  <span>Engineer</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Team End -->

{{-- Testimony Landing Page Start --}}
@include('LandingPageView.LandingPageViewHome.partials.landingpageviewhometestimony')
{{-- Testimony Landing Page End --}}
@endsection
