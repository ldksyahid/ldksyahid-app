@extends('LandingPageView.LandingPageViewTemplate.bodylandingpage')

@section('content')
<div class="container-xxl py-5">
    <div class="container">
        <div class="col-lg-12 col-md-6 wow fadeInDown" data-wow-delay="0.1s">
            <div class="border-end border-start border-5 border-primary mb-5 text-center">
                <h5 class="text-body">Kestari LDK Syahid</h5>
                <h1 class="display-6">CALL KESTARI</h1>
                <p class="text-body">Call Kestari merupakan tautan panggilan yang didalamnya terdapat laman khusus berisi informasi penting untuk di bagikan kepada para Sekretaris Bidang/Biro, Sekretaris LDKSF dan Anggota LDK Syahid, yang berfungsi membantu mengarahkan pengguna dalam berkomunikasi lebih personal terkait Kesekretariatan</p>
            </div>
        </div>
        @forelse($data as $key => $data)
        <div class="my-3 wow fadeIn{{ $data->appear }}" data-wow-delay="0.1s">
            <a class="btn btn-primary w-100 py-3" href="{{ $data->link }}" target="_blank">{{ $data->buttonName }}</a>
        </div>
        @empty
        <div class="my-3 wow fadeInUp text-center" data-wow-delay="0.1s">
            <h3>Call Kestari Belum Tersedia</h3>
        </div>
        @endforelse
    </div>
</div>
@endsection

