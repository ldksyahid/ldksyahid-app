<!-- Carousel Start -->
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            {{-- <div class="carousel-item active">
                <img class="w-100" src="Images/Testing/testjumbotron.png" alt="Image" />
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10 text-center">
                                <h5 class="text-light mb-3 animated slideInDown">Selamat Datang di Website LDK Syahid</h5>
                                <h1 class="display-4 text-light mb-3 animated slideInDown">KITA ADALAH SAUDARA</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Earum consequuntur quam sunt, dolore sed suscipit esse perspiciatis, doloribus molestiae fuga iste commodi assumenda ea, soluta eligendi adipisci. Cum, corporis modi.</p>
                                <a href="" class="btn btn-primary py-3 px-5">Tentang Kami  </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}
            @forelse($postjumbotron as $key => $postjumbotron)
            <div class="carousel-item {{($key + 1 === 1) ? "active" : ""}}">
                <img class="w-100" src="images/uploads/jumbotrons/{{$postjumbotron->picture}}" alt="Image" />
                <div class="carousel-caption">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10 text-{{$postjumbotron->textalign}}">
                                <h5 class="text-light text-uppercase mb-3 animated slideInDown">{{$postjumbotron->title}}</h5>
                                <h1 class="display-4 text-light mb-3 animated slideInDown">{{$postjumbotron->subtitle}}</h1>
                                <p>{{$postjumbotron->sentence}}</p>
                                <a href="{{$postjumbotron->btnlink}}" target="_blank" class="btn btn-primary py-3 px-5">{{$postjumbotron->btnname}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @empty
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('LandingPageSource/img/carousel-1.jpg') }}" alt="Image" />
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12 col-lg-10 text-center">
                                    <h5 class="text-light mb-3 animated slideInDown">Belum Ada Jumbotron</h5>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#header-carousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#header-carousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</div>
<!-- Carousel End -->
