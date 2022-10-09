@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <div class="col-lg-7 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h6 class="text-body">Lorem, ipsum dolor.</h6>
                    <h1 class="display-6">Update Profil Kamu disini yaaa</h1>
                    <p class="mb-0" style="text-align: justify">Lorem ipsum dolor sit amet consectetur adipisicing elit. Voluptatem accusantium obcaecati temporibus, numquam sit officiis doloremque quos ipsam iure laboriosam commodi quibusdam quam, vitae voluptatibus.</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class=" mb-5 text-end">
                    <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="LDK Syahid" width="255px" height="255px">
                </div>
            </div>
            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset('Images/Testing/strukturtest.jpg') }}" alt="Struktur Pengurus" width="100%" class="shadow rounded">
            </div>
        </div>
    </div>
</div>
@endsection
