@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('style')
<link href="{{ asset('css/multiselectcelengan.css') }}" rel="stylesheet" />
@endsection


@section('content')
<div class="container-xxl" style="background-color: #f5f6fa;">
    <div class="row g-5">
        <div class="col col-lg-8">
            <div class="p-5" style="margin-right: -20px">
                <img class="w-100 " src="{{ asset('Images/fixImage/dummy/excamp.png') }}" alt="Image" style="border-radius: 15px;"/>
            </div>
        </div>
        <div class="col col-lg-4">
            <div class="p-5" style="margin-left:-80px ">
                <div class="badge mb-3" style="margin-left:-8px;"> <span>Sosial Dakwah</span> </div>
                <div class="d-flex flex-row align-items-center">
                    <h2 class="text-body mb-0">Pojok Baca Pelosok Negeri : Membangun Bangsa Dengan Literasi</h2>
                </div>
                <hr>
                <div class="d-flex justify-content-between">
                    <div class="d-flex flex-row align-items-center" style="height: 2em;">
                        <img src="{{ asset('Images/Logos/logoldksyahid.png') }}" alt="logo" width="30" height="30">
                        <div class="ms-2 c-details">
                            <h6 style="font-size: 18px" class="mb-0 text-body"><a href="https://www.ldksyah.id/" target="_blank">UKM LDK Syahid</a></h6>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="progress mt-3">
                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"><strong>50%</strong></div>
                </div>
                <div class="mt-0">
                    <div class="row d-flex flex-row align-items-center">
                        <div class="col-lg-8 text-start my-3">
                            <p style="font-size: 12px;">
                                0.63% dari target Rp. 100.000.000,-
                            </p>
                        </div>
                        <div class="col text-end my-3">
                            <p style="font-size: 12px;" class="d-flex flex-row align-items-center">
                                <i class="far fa-clock fa-1x text-primary me-1"></i>341 hari lagi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('scripts')
@endsection
