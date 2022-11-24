@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<!-- Page Header Start -->
<div class="container-fluid page-header py-5 wow fadeIn" data-wow-delay="0.1s">
    <div class="container text-center py-5">
        <h1 class="display-4 text-white animated slideInDown mb-4 text-uppercase">
            Layanan LDK Syahid
        </h1>
        <nav aria-label="breadcrumb animated slideInDown">
            <ol class="breadcrumb justify-content-center mb-0">
                <p class="text-white">Kami akan Selalu Berusaha Memberikan Layanan yang Terbaik Untuk Kamu</p>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header End -->
<div class="container-xxl" style="background-color: #f5f6fa">
    <div class="container">
        <div class="row justify-content-center wow fadeInRight" data-wow-delay="0.1s">
            <div class="col-lg-4 mt-5">
                <div class="card card-margin">
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
            <div class="col-lg-4 mt-5">
                <div class="card card-margin">
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
            <div class="col-lg-4 mt-5">
                <div class="card card-margin">
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
        </div>
    </div>
</div>
{{-- Start Wave --}}
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="#f5f6fa" fill-opacity="1" d="M0,256L34.3,250.7C68.6,245,137,235,206,213.3C274.3,192,343,160,411,176C480,192,549,256,617,277.3C685.7,299,754,277,823,240C891.4,203,960,149,1029,160C1097.1,171,1166,245,1234,277.3C1302.9,309,1371,299,1406,293.3L1440,288L1440,0L1405.7,0C1371.4,0,1303,0,1234,0C1165.7,0,1097,0,1029,0C960,0,891,0,823,0C754.3,0,686,0,617,0C548.6,0,480,0,411,0C342.9,0,274,0,206,0C137.1,0,69,0,34,0L0,0Z"></path></svg>
{{-- End Wave --}}
@endsection
