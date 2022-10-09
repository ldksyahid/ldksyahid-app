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
              <div
                class="position-relative overflow-hidden ps-5 pt-5 h-100"
                style="min-height: 400px"
              >
                <img
                  class="position-absolute w-100 h-100"
                  src="{{ asset('LandingPageSource/img/about.jpg') }}"
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
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.5s">
              <div class="h-100">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                  <h6 class="text-body text-uppercase mb-2">About Us</h6>
                  <h1 class="display-6 mb-0">
                    Unique Solutions For Residentials & Industries!
                  </h1>
                </div>
                <p>
                  Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit.
                  Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit,
                  sed stet lorem sit clita duo justo magna dolore erat amet
                </p>
                <p class="mb-4">
                  Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit.
                  Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit,
                  sed stet lorem sit clita duo justo magna dolore erat amet
                </p>
                <div class="border-top mt-4 pt-4">
                  <div class="row g-4">
                    <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.1s">
                      <i
                        class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                      ></i>
                      <h6 class="mb-0">Ontime at services</h6>
                    </div>
                    <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.3s">
                      <i
                        class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                      ></i>
                      <h6 class="mb-0">24/7 hours services</h6>
                    </div>
                    <div class="col-sm-4 d-flex wow fadeIn" data-wow-delay="0.5s">
                      <i
                        class="fa fa-check fa-2x text-primary flex-shrink-0 me-3"
                      ></i>
                      <h6 class="mb-0">Verified professionals</h6>
                    </div>
                  </div>
                </div>
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

      <!-- Service Start -->
      <div class="container-xxl py-5">
        <div class="container">
          <div class="row g-5 align-items-end mb-5">
            <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="border-start border-5 border-primary ps-4">
                <h6 class="text-body text-uppercase mb-2">Our Services</h6>
                <h1 class="display-6 mb-0">
                  Construction And Renovation Solutions
                </h1>
              </div>
            </div>
            <div class="col-lg-6 text-lg-end wow fadeInUp" data-wow-delay="0.3s">
              <a class="btn btn-primary py-3 px-5" href="">More Services</a>
            </div>
          </div>
          <div class="row g-4 justify-content-center">
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="{{ asset('LandingPageSource/img/service-1.jpg') }}" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Building Construction</h5>
                  <p>
                    Tempor erat elitr rebum at clita dolor diam ipsum sit diam
                    amet diam et eos
                  </p>
                  <a class="small" href=""
                    >READ MORE<i class="fa fa-arrow-right ms-3"></i
                  ></a>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="{{ asset('LandingPageSource/img/service-2.jpg') }}" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Home Maintainance</h5>
                  <p>
                    Tempor erat elitr rebum at clita dolor diam ipsum sit diam
                    amet diam et eos
                  </p>
                  <a class="small" href=""
                    >READ MORE<i class="fa fa-arrow-right ms-3"></i
                  ></a>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="{{ asset('LandingPageSource/img/service-3.jpg') }}" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Renovation and Painting</h5>
                  <p>
                    Tempor erat elitr rebum at clita dolor diam ipsum sit diam
                    amet diam et eos
                  </p>
                  <a class="small" href=""
                    >READ MORE<i class="fa fa-arrow-right ms-3"></i
                  ></a>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="{{ asset('LandingPageSource/img/service-4.jpg') }}" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Wiring and installation</h5>
                  <p>
                    Tempor erat elitr rebum at clita dolor diam ipsum sit diam
                    amet diam et eos
                  </p>
                  <a class="small" href=""
                    >READ MORE<i class="fa fa-arrow-right ms-3"></i
                  ></a>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.3s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="{{ asset('LandingPageSource/img/service-5.jpg') }}" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Tiling and Painting</h5>
                  <p>
                    Tempor erat elitr rebum at clita dolor diam ipsum sit diam
                    amet diam et eos
                  </p>
                  <a class="small" href=""
                    >READ MORE<i class="fa fa-arrow-right ms-3"></i
                  ></a>
                </div>
              </div>
            </div>
            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
              <div class="service-item bg-light overflow-hidden h-100">
                <img class="img-fluid" src="{{ asset('LandingPageSource/img/service-6.jpg') }}" alt="" />
                <div class="service-text position-relative text-center h-100 p-4">
                  <h5 class="mb-3">Interior Design</h5>
                  <p>
                    Tempor erat elitr rebum at clita dolor diam ipsum sit diam
                    amet diam et eos
                  </p>
                  <a class="small" href=""
                    >READ MORE<i class="fa fa-arrow-right ms-3"></i
                  ></a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Service End -->

      <!-- Appointment Start -->
      <div
        class="container-fluid appointment my-5 py-5 wow fadeIn"
        data-wow-delay="0.1s"
      >
        <div class="container py-5">
          <div class="row g-5">
            <div class="col-lg-5 col-md-6 wow fadeIn" data-wow-delay="0.3s">
              <div class="border-start border-5 border-primary ps-4 mb-5">
                <h6 class="text-white text-uppercase mb-2">Appointment</h6>
                <h1 class="display-6 text-white mb-0">
                  A Company Involved In Service And Maintenance
                </h1>
              </div>
              <p class="text-white mb-0">
                Tempor erat elitr rebum at clita. Diam dolor diam ipsum sit. Aliqu
                diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet
                lorem sit clita duo justo magna dolore erat amet
              </p>
            </div>
            <div class="col-lg-7 col-md-6 wow fadeIn" data-wow-delay="0.5s">
              <form>
                <div class="row g-3">
                  <div class="col-sm-6">
                    <div class="form-floating">
                      <input
                        type="text"
                        class="form-control bg-dark border-0"
                        id="gname"
                        placeholder="Gurdian Name"
                      />
                      <label for="gname">Your Name</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-floating">
                      <input
                        type="email"
                        class="form-control bg-dark border-0"
                        id="gmail"
                        placeholder="Gurdian Email"
                      />
                      <label for="gmail">Your Email</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-floating">
                      <input
                        type="text"
                        class="form-control bg-dark border-0"
                        id="cname"
                        placeholder="Child Name"
                      />
                      <label for="cname">Your Mobile</label>
                    </div>
                  </div>
                  <div class="col-sm-6">
                    <div class="form-floating">
                      <input
                        type="text"
                        class="form-control bg-dark border-0"
                        id="cage"
                        placeholder="Child Age"
                      />
                      <label for="cage">Service Type</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <div class="form-floating">
                      <textarea
                        class="form-control bg-dark border-0"
                        placeholder="Leave a message here"
                        id="message"
                        style="height: 100px"
                      ></textarea>
                      <label for="message">Message</label>
                    </div>
                  </div>
                  <div class="col-12">
                    <button class="btn btn-primary w-100 py-3" type="submit">
                      Get Appointment
                    </button>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Appointment End -->

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
                <div class="testimonial-item">
                  <img
                    class="img-fluid mb-4"
                    src="{{ asset('LandingPageSource/img/testimonial-1.jpg') }}"
                    alt=""
                  />
                  <p class="fs-5">
                    Dolores sed duo clita tempor justo dolor et stet lorem kasd
                    labore dolore lorem ipsum. At lorem lorem magna ut et, nonumy
                    et labore et tempor diam tempor erat.
                  </p>
                  <div
                    class="bg-primary mb-3"
                    style="width: 60px; height: 5px"
                  ></div>
                  <h5>Client Name</h5>
                  <span>Profession</span>
                </div>
                <div class="testimonial-item">
                  <img
                    class="img-fluid mb-4"
                    src="{{ asset('LandingPageSource/img/testimonial-2.jpg') }}"
                    alt=""
                  />
                  <p class="fs-5">
                    Dolores sed duo clita tempor justo dolor et stet lorem kasd
                    labore dolore lorem ipsum. At lorem lorem magna ut et, nonumy
                    et labore et tempor diam tempor erat.
                  </p>
                  <div
                    class="bg-primary mb-3"
                    style="width: 60px; height: 5px"
                  ></div>
                  <h5>Client Name</h5>
                  <span>Profession</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- Testimonial End -->
@endsection
