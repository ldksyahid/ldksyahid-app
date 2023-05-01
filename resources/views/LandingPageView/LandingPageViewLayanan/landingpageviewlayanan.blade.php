@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid p-0 mb-0 wow fadeIn" data-wow-delay="0.2s">
    <div id="header-carousel" class="carousel slide" data-bs-ride="carousel" >
        <div class="carousel-inner" >
            <div class="carousel-item active">
                <img class="w-100" src="{{ asset('Images/fixImage/billboardimage/layanan.png') }}" alt="Image" />
            </div>
        </div>
    </div>
</div>
<!-- Page Header End -->
<div class="container-xxl" style="background-color: #f5f6fa">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-4 mt-5 wow fadeInUp" data-wow-delay="0.1s">
                <div class="card card-margin" style="height: 515px;">
                    <img src="{{asset('Images/fixImage/serviceimage/callkestari.png')}}" alt="" class="m-5">
                    <div class="card-body pt-0">
                        <h5 class="card-title">Call kestari</h5>
                        <div class="widget-49">
                            <div class="widget-49-meeting-points">
                                <p style="text-align: justify">Call Kestari merupakan tautan panggilan yang didalamnya terdapat laman khusus berisi informasi penting untuk di bagikan kepada para Sekretaris Bidang/Biro, Sekretaris LDKSF dan Anggota LDK Syahid, yang berfungsi membantu mengarahkan pengguna dalam berkomunikasi lebih personal terkait Kesekretariatan.</p>
                            </div>
                            <div class="widget-49-meeting-action">
                                <a href="/service/callkestari" target="_blank" class="btn btn-primary w-100 py-2" >Mulai</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-5 wow fadeInUp" data-wow-delay="0.2s">
                <div class="card card-margin" style="height: 515px;">
                    <img src="{{asset('Images/fixImage/serviceimage/kalkulatorkestari.png')}}" alt="" class="m-5">
                    <div class="card-body pt-0">
                        <h5 class="card-title">Kalkulator Kestari</h5>
                        <div class="widget-49">
                            <div class="widget-49-meeting-points">
                                <p style="text-align: justify">Kalkulator Kestari merupakan sebuah program untuk membantu menghitung penilaian Program Kerja UKM LDK Syahid yang biasanya digunakan sebelum MSG atau MUSA/F.</p>
                                <br><br><br>
                            </div>
                            <div class="widget-49-meeting-action">
                                <a href="/service/hitungproker" target="_blank" class="btn btn-primary w-100 py-2" >Mulai</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-5 wow fadeInUp" data-wow-delay="0.3s">
                <div class="card card-margin" style="height: 515px;">
                    <img src="{{asset('Images/fixImage/serviceimage/shortlink.png')}}" alt="" class="m-5">
                    <div class="card-body pt-0">
                        <h5 class="card-title">Perpendek URL</h5>
                        <div class="widget-49">
                            <div class="widget-49-meeting-points">
                                <p style="text-align: justify">Perpendek URL merupakah sebuah layanan untuk Membuat URL/Link yang panjang menjadi Singkat sehingga memudahkan untuk di ketik, Tetapi Layanan ini hanya dapat digunakan oleh anggota UKM LDK Syahid UIN Jakarta.</p>
                                <br><br>
                            </div>
                            <div class="widget-49-meeting-action">
                                <a href="/service/shortlink" target="_blank" class="btn btn-primary w-100 py-2" >Mulai</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4 mt-5 wow fadeInUp" data-wow-delay="0.4s">
                <div class="card card-margin" style="height: 515px;">
                    <img src="{{asset('Images/fixImage/serviceimage/celengan-syahid.png')}}" alt="" class="m-5">
                    <div class="card-body pt-0">
                        <h5 class="card-title">Celengan Syahid</h5>
                        <div class="widget-49">
                            <div class="widget-49-meeting-points">
                                <p style="text-align: justify">
                                    Celengan Syahid adalah sebuah layanan Donasi Crowdfunding secara online untuk membantu orang yang membutuhkan. Melalui Celengan Syahid, kita dapat berdonasi untuk berbagai keperluan seperti kemanusiaan, pendidikan, dan kebutuhan dasar lainnya.
                                </p>
                                <br><br>
                            </div>
                            <div class="widget-49-meeting-action">
                                <a href="/service/celengansyahid" target="_blank" class="btn btn-outline-secondary w-100 py-2" style="pointer-events: none;cursor: default;">SEGERA HADIR</a>
                                {{-- <a href="/service/celengansyahid" target="_blank" class="btn btn-primary w-100 py-2">Mulai</a> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.body.style.backgroundColor = "#f5f6fa";
</script>
@endsection
