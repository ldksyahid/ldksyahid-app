@extends('landing-page.template.body')

@section('content')
@forelse($poststructure as $key => $data)
<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <audio src="{{ asset('audio/mars-ldksyahid.mp3') }}" type="audio/mpeg" autoplay loop></audio>
            <div class="col-lg-7 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h5 class="text-body">Struktur Pengurus LDK Syahid {{ $data->batch }}</h5>
                    <h6 class="text-body">Masa Bakti {{ $data->period }}</h6>
                    <h1 class="display-6">{{ $data->structureName }}</h1>
                    <p class="mb-0" style="text-align: justify">{{ $data->structureDescription }}</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class=" mb-1 text-end">
                    <img src="{{ asset( $data->structureLogo) }}" alt="LDK Syahid" width="250px" height="250px">
                </div>
            </div>
            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset($data->structureImage) }}" alt="Struktur Pengurus" width="100%" class="shadow rounded">
            </div>
        </div>
    </div>
</div>
@empty
<div class="container-xxl py-5 wow fadeInUp" data-wow-delay="0.1s" style="text-align: center">
    <audio src="{{ asset('audio/mars-ldksyahid.mp3') }}" type="audio/mpeg" autoplay loop></audio>
    <h2>Struktur Pengurus Belum Tersedia</h2>
</div>
@endforelse
@endsection
