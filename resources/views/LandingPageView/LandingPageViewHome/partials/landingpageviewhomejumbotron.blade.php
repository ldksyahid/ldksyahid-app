<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($postjumbotron as $key => $postjumbotron)
            <div class="carousel-item {{($key + 1 === 1) ? "active" : ""}}">
                <img class="w-100" src="{{ asset($postjumbotron->picture) }}" alt="Image" />
                <div class="carousel-caption">
                    <div class="container">
                    {{-- <div class="container" style="object-fit: contain"> --}}
                        <div class="row justify-content-center">
                            <div class="col-12 col-lg-10 text-start">
                                <a href="{{$postjumbotron->btnlink}}" target="_blank" class="btn btn-primary py-lg-3 px-lg-5 buttonphone">{{$postjumbotron->btnname}}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
                @empty
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('Images/fixImage/bg_bilboard.png') }}" alt="Image" />
                    <div class="carousel-caption" style="top: 0%;right: 0%;background: rgba(0, 0, 0, .65);">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12 col-lg-10 text-center">
                                    <h1 class="text-light mb-3 animated slideInDown">Billboard Belum Tersedia</h2>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Carousel Start -->
{{-- <div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($postjumbotron as $key => $postjumbotron)
            <div class="carousel-item {{($key + 1 === 1) ? "active" : ""}}">
                <img class="w-100" src="{{ asset($postjumbotron->picture) }}" alt="Image" />
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
                    <img class="w-100" src="{{ asset('Images/fixImage/bg_bilboard.png') }}" alt="Image" />
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12 col-lg-10 text-center">
                                    <h1 class="text-light mb-3 animated slideInDown">Billboard Belum Tersedia</h2>
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
</div> --}}
<!-- Carousel End -->
