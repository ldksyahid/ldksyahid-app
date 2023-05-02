@extends('landing-page.template.body')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5 justify-content-center">
            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-3">
                    <h6 class="text-body text-uppercase mb-2">Meet Our Team</h6>
                    <h1 class="display-6 mb-0">
                        IT Support UKM LDK Syahid
                    </h1>
                </div>
                <p class="mt-1 col-lg-7 col-md-6">
                    We will always try to give the best for UKM LDK Syahid, Especially in the Field of Technology, because we know that a Struggle is not Over when we are not Finished
                </p>
            </div>
            @forelse($postitsupport as $key => $data)
            <div class="col-md-4 col-sm-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="our-team">
                    <img src="{{ asset($data->photoProfile) }}" style="width: 315px; height:435px; object-fit:fill;">
                    <div class="team-content">
                        <h3 class="title">{{ $data->name }}</h3>
                        <h4 class="title2">{{ $data->forkat }}</h4>
                        <span class="post">{{ $data->position }}</span>
                        <ul class="social">
                            <li><a href="{{ $data->linkInstagram }}" target="_blank"><i class="fab fa-instagram"></i></a></li>
                            <li><a href="{{ $data->linkLinkedin }}" target="_blank"><i class="fab fa-linkedin"></i></a></li>
                        </ul>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-lg-12 col-md-6 wow fadeInUp text-center" data-wow-delay="0.1s">
                <h3>IT Support Not Available</h3>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
