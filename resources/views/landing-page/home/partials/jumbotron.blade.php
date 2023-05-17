
<div class="container-fluid p-0 mb-5 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            @forelse($postjumbotron as $key => $postjumbotron)
            <div class="carousel-item {{($key + 1 === 1) ? "active" : ""}}">
                <img class="w-100" src="{{ asset($postjumbotron->picture) }}" alt="Image" />
                @if ($postjumbotron->btnname != null || $postjumbotron->btnlink != null)
                    <div class="carousel-caption">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-12 col-lg-10 text-start">
                                    <a href="{{$postjumbotron->btnlink}}" target="_blank" class="btn btn-primary py-lg-3 px-lg-5 buttonphone">{{$postjumbotron->btnname}}</a>
                                </div>
                            </div>
                        </div>
                    </div>
                @else

                @endif
            </div>
            <div class="carousel-item">
                <img class="w-100" src="{{ asset('Images/fixImage/billboardimage/jumbotron.png') }}" alt="Image" />
            </div>
            @empty
                <div class="carousel-item active">
                    <img class="w-100" src="{{ asset('Images/fixImage/billboardimage/jumbotron.png') }}" alt="Image" />
                </div>
            @endforelse
        </div>
    </div>
</div>
