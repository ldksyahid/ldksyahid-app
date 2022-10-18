@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')

<div class="container-xxl py-5">
    <div class="container">
        <div class="row g-5">
            <audio src="{{ asset('Audio/RinduTakBersuara_FebyP.mp3') }}" type="audio/mpeg" autoplay loop></audio>
            <div class="col-lg-7 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class="border-start border-5 border-primary ps-4 mb-5">
                    <h6 class="text-body">Struktur Pengurus LDK Syahid 26</h6>
                    <h1 class="display-6">PENDAR CAKRAWALA</h1>
                    <p class="mb-0" style="text-align: justify">"Barang siapa mengerjakan kebajikan, baik laki-laki maupun perempuan dalam keadaan beriman, maka pasti akan Kami berikan kepadanya kehidupan yang baik dan akan Kami beri balasan dengan pahala yang lebih baik dari apa yang telah mereka kerjakan." &#9679; (QS. An-Nahl 16: Ayat 97)</p>
                </div>
            </div>
            <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <div class=" mb-1 text-end">
                    <img src="{{ asset('Images/Logos/pendarcakrawala.png') }}" alt="LDK Syahid" width="250px" height="250px">
                </div>
            </div>
            <div class="col-lg-12 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                <img src="{{ asset('Images/Testing/strukturtest.jpg') }}" alt="Struktur Pengurus" width="100%" class="shadow rounded">
            </div>
        </div>
    </div>
</div>
@endsection
