@extends('landing-page.template.body')

@section('content')
    <div class="container-xxl py-5">
        <div class="container">
            <div class="col-lg-12 col-md-6 wow fadeInDown" data-wow-delay="0.1s">
                <div class="border-end border-start border-5 border-primary mb-5 text-center">
                    <h5 class="text-body">Kestari LDK Syahid</h5>
                    <h1 class="display-6">CALL KESTARI</h1>
                    <p class="text-body px-5">Call Kestari merupakan tautan panggilan yang didalamnya terdapat laman khusus berisi
                        informasi penting untuk di bagikan kepada para Sekretaris Bidang/Biro, Sekretaris LDKSF dan Anggota
                        LDK Syahid, yang berfungsi membantu mengarahkan pengguna dalam berkomunikasi lebih personal terkait
                        Kesekretariatan</p>
                </div>
            </div>
            <div class="row justify-content-center flex-lg-row flex-column gap-lg-3 gap-3">
                @forelse($data as $key => $data)
                    <div class="col col-lg-3 card shadow-c no-border wow fadeIn{{ $data->appear }} " data-wow-delay="0.1s">
                        <div class="row text-center card-body align-items-center">
                            <span class=" fw-bold">{{ $data->buttonName }}</span>
                            <span class="p-2">Non deserunt anim sit esse aliqua officia commodo deserunt. Dolore ad
                                dolore amet nulla adipisicing fugiat anim.</span>
                        </div>
                        <div class="card-footer text-center">
                            <a class="btn btn-outline-primary w-75 m-1" href="{{ $data->link }}" target="_blank">Hubungi</a>
                        </div>
                    </div>
                @empty
                    <div class="my-3 wow fadeInUp text-center" data-wow-delay="0.1s">
                        <h3>Call Kestari Belum Tersedia</h3>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
