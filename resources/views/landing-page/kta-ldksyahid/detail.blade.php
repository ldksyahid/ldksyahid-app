@extends('landing-page.template.body')

@section('content')
@if((new \Jenssegers\Agent\Agent())->isDesktop())
<div>
    <div class="py-5" style="background-color: #008F8F">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 wow fadeInUp" data-wow-delay="0.1s">
                    <div style="border-radius: 100%">
                        @if (!empty($ktaData->photo))
                            <img class="wow fadeInUp" data-wow-delay="0.5s" src="{{ asset($ktaData->photo) }}" alt="" width="250px" height="300px" style="border-radius: 5%">
                        @else
                            @if ($ktaData->gender != "Male")
                                <img class="wow fadeInUp" data-wow-delay="0.5s" src="https://lh3.googleusercontent.com/d/15Q9hUkS-yvTBCtF4_KZUy9o725MZ9z6n" alt="" width="250px" height="300px" style="border-radius: 5%">
                            @else
                                <img class="wow fadeInUp" data-wow-delay="0.5s" src="https://lh3.googleusercontent.com/d/1CACDd_5vjzM82KTR08ND_nGbqtePHRsj" alt="" width="250px" height="300px" style="border-radius: 5%">
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-lg-8 wow fadeInUp" data-wow-delay="0.1s">
                    <div>
                        <div class="row">
                            <div class="col-lg-8">
                                <h1 class="text-white">{{ $ktaData->fullName }}</h1>
                                <span class="border border-white p-2 text-white small" style="border-radius: 5px;">{{ $ktaData->memberNumber }}</span>
                            </div>
                            <div class="col-lg-4">
                                <img class="wow fadeInUp" data-wow-delay="0.5s" src="https://lh3.googleusercontent.com/d/1LsDxFAt1WU66CNp-2CN3J2qWXXJHlWIY" alt="" width="60%">
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <p class="text-white" style="text-align: justify">
                            {{ $ktaData->background }}
                        </p>
                    </div>
                    <div class="my-5">
                        <h2 class="text-white">Biodata</h1>
                        <div class="row">
                            <div class="col-lg-4">
                                <h5 class="text-white">NIM</h5>
                                <p class="text-white">{{ $ktaData->nim }}</p>
                            </div>
                            <div class="col-lg-4">
                                <h5 class="text-white">Fakultas</h5>
                                <p class="text-white">{{ $ktaData->getFaculty->facultyName }}</p>
                            </div>
                            <div class="col-lg-4">
                                @if (!empty($ktaData->email))
                                <h5 class="text-white">Email</h5>
                                <p class="text-white">{{ $ktaData->email }}</p>
                                @endif
                            </div>
                            <div class="col-lg-4">
                                <h5 class="text-white">Forum Angkatan</h5>
                                <p class="text-white">{{ $ktaData->getGeneration->generationName }}</p>
                            </div>
                            <div class="col-lg-8">
                                <h5 class="text-white">Program Studi</h5>
                                <p class="text-white">{{ $ktaData->getMajor->majorName }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5 wow fadeInUp pb-5 border-bottom border-5 border-primary" data-wow-delay="0.1s" style="border-radius: 5px">
                    <h3>
                        Slogan
                    </h3>
                    <h5 class="text-body">{{ $ktaData->slogan }}</h5>
                </div>
                <div class="col-lg-2">
                </div>
                @if (!empty($ktaData->instagram) || !empty($ktaData->linkedIn))
                    <div class="col-lg-5 wow fadeInUp pb-5 border-bottom border-5 border-primary text-end" data-wow-delay="0.1s" style="border-radius: 5px">
                        <h3 class="text-end">Sosial Media</h3>
                        @if (!empty($ktaData->instagram))
                            <a href="{{ $ktaData->instagram }}" target="_blank"><button type="button" class="btn btn-outline-primary m-2" style="border-radius: 5px;"><span class="small">Instagram</span> <i class="fab fa-instagram"></i></button></a>
                        @endif
                        @if (!empty($ktaData->linkedIn))
                            <a href="{{ $ktaData->linkedIn }}" target="_blank"><button type="button" class="btn btn-outline-primary m-2" style="border-radius: 5px;"><span class="small">LinkedIn</span> <i class="fab fa-linkedin"></i></button></a>
                        @endif
                    </div>
                @endif
                <div class="col-lg-12 text-center wow fadeInUp" data-wow-delay="0.1s">
                    <img class="wow fadeInUp" data-wow-delay="0.5s" src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" alt="" width="20%">
                    <p class="mt-5 wow fadeInDown" data-wow-delay="0.1s" style="text-align: justify">LDK Syahid adalah Salah satu Unit Kegiatan Mahasiswa (UKM) bidang keislaman di UIN Jakarta. Kegiatan-kegiatan yang dilakukan oleh LDK Syahid ialah Mentoring Pekanan, Kajian Keislaman, Rihlah, Upgrading Softskill, Menguatkan Ukhuwah Islamiyah, Management SDM, Management Problem Solved, Pembentukan Karakter Kepemimpinan, dan masih banyak lagi. Outputnya adalah Anggota LDK Syahid menjadi generasi emas menyongsong kehidupan masyarakat madani.</p>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h3 class="text-center">
                        Visi
                    </h3>
                    <p style="text-align: justify">
                        “Terciptanya insan-insan dakwah yang memiliki kekokohan spiritualitas, intelektualitas, dan solidaritas dengan etos profesionalisme menuju kampus yang islami dalam rangka mewujudkan khairu ummah.”
                    </p>
                </div>
                <div class="col-lg-6 wow fadeInUp" data-wow-delay="0.1s">
                    <h3 class="text-center">
                        Misi
                    </h3>
                    <ol style="text-align: justify">
                        <li>Tarbiyah Madal Hayah (Pendidikan Sepanjang Hidup)</li>
                        <li>Amal Sholeh (Perbuatan yang Baik)</li>
                        <li>Amar Ma’ruf Nahi Mungkar (Memerintahkan yang Baik dan Mencegah yang Mungkar)</li>
                        <li>Khidmatul Ummah (Pengabdian Masyarakat)</li>
                        <li>Wihdatul Ummah dan Ukhuwah Islamiyah (Persatuan Umat dan Ukhuwah Islamiyah)</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if((new \Jenssegers\Agent\Agent())->isMobile())
<div>
    <div class="container-xxl py-5" style="background-color: #008F8F">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div style="border-radius: 100%" class="text-center">
                        @if (!empty($ktaData->photo))
                            <img class="wow fadeInUp" data-wow-delay="0.5s" src="{{ asset($ktaData->photo) }}" alt="" width="80%" style="border-radius: 5%">
                        @else
                            @if ($ktaData->gender != "Male")
                                <img class="wow fadeInUp" data-wow-delay="0.5s" src="https://lh3.googleusercontent.com/d/15Q9hUkS-yvTBCtF4_KZUy9o725MZ9z6n" alt="" width="80%" style="border-radius: 5%">
                            @else
                                <img class="wow fadeInUp" data-wow-delay="0.5s" src="https://lh3.googleusercontent.com/d/1CACDd_5vjzM82KTR08ND_nGbqtePHRsj" alt="" width="80%" style="border-radius: 5%">
                            @endif
                        @endif
                    </div>
                </div>
                <div class="col-lg-8 col-md-6 wow fadeInUp" data-wow-delay="0.1s">
                    <div>
                        <div class="row">
                            <div class="col-8">
                                <h1 class="text-white">{{ $ktaData->fullName }}</h1>
                                <span class="border border-white p-2 text-white small" style="border-radius: 5px;">{{ $ktaData->memberNumber }}</span>
                            </div>
                            <div class="col-4">
                                <img class="wow fadeInUp" data-wow-delay="0.5s" src="https://lh3.googleusercontent.com/d/1LsDxFAt1WU66CNp-2CN3J2qWXXJHlWIY" alt="" width="100%">
                            </div>
                        </div>
                    </div>
                    <div class="my-5">
                        <p class="text-white" style="text-align: justify">
                            {{ $ktaData->background }}
                        </p>
                    </div>
                    <div class="my-5">
                        <h2 class="text-white">Biodata</h2>
                        <div class="row">
                            <div class="col-6">
                                <h5 class="text-white">NIM</h5>
                                <p class="text-white">{{ $ktaData->nim }}</p>
                            </div>
                            <div class="col-6">
                                <h5 class="text-white">Fakultas</h5>
                                <p class="text-white">{{ $ktaData->getFaculty->facultyName }}</p>
                            </div>
                            <div class="col-6">
                                <h5 class="text-white">Program Studi</h5>
                                <p class="text-white">{{ $ktaData->getMajor->majorName }}</p>
                            </div>
                            <div class="col-6">
                                <h5 class="text-white">Forkat</h5>
                                <p class="text-white">{{ $ktaData->getGeneration->generationName }}</p>
                            </div>
                            <div class="col-12">
                                @if (!empty($ktaData->email))
                                <h5 class="text-white">Email</h5>
                                <p class="text-white">{{ $ktaData->email }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl py-5">
        <div class="container">
            <div class="row g-5">
                <div class="col-lg-5 col-md-12 wow fadeInUp" data-wow-delay="0.1s" style="border-radius: 5px">
                    <h4 class="text-center">{{ $ktaData->slogan }}</h4>
                    @if (!empty($ktaData->instagram) || !empty($ktaData->linkedIn))
                    <div class="text-end mt-3">
                        @if (!empty($ktaData->instagram))
                            <a href="{{ $ktaData->instagram }}" target="_blank"><button type="button" class="btn btn-outline-primary m-2" style="border-radius: 5px;"><span class="small">Instagram</span> <i class="fab fa-instagram"></i></button></a>
                        @endif
                        @if (!empty($ktaData->linkedIn))
                            <a href="{{ $ktaData->linkedIn }}" target="_blank"><button type="button" class="btn btn-outline-primary m-2" style="border-radius: 5px;"><span class="small">LinkedIn</span> <i class="fab fa-linkedin"></i></button></a>
                        @endif
                    </div>
                @endif
                </div>
                <div>
                    <div class="d-flex justify-content-center">
                        <img class="my-3" src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" width="60%">
                    </div>
                    <ul class="nav nav-pills mb-3 justify-content-center" id="pills-tab" role="tablist" style="font-size: 14px; border-radius: 20px;">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link mobile-font-2" id="pills-visi-tab" data-bs-toggle="pill" data-bs-target="#pills-visi" type="button" role="tab" aria-controls="pills-visi" aria-selected="false" style="border-radius :5px;">Visi</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active mobile-font-2" id="pills-perkenalan-tab" data-bs-toggle="pill" data-bs-target="#pills-perkenalan" type="button" role="tab" aria-controls="pills-perkenalan" aria-selected="true" style="border-radius :5px;">Perkenalan</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link mobile-font-2" id="pills-misi-tab" data-bs-toggle="pill" data-bs-target="#pills-misi" type="button" role="tab" aria-controls="pills-misi" aria-selected="false" style="border-radius :5px;">Misi</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-perkenalan" role="tabpanel" aria-labelledby="pills-perkenalan-tab">
                            <div class="col-lg-4">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <div>
                                            <p class="mobile-body-font" style="text-align: justify">
                                                LDK Syahid adalah Salah satu Unit Kegiatan Mahasiswa (UKM) bidang keislaman di UIN Jakarta. Kegiatan-kegiatan yang dilakukan oleh LDK Syahid ialah Mentoring Pekanan, Kajian Keislaman, Rihlah, Upgrading Softskill, Menguatkan Ukhuwah Islamiyah, Management SDM, Management Problem Solved, Pembentukan Karakter Kepemimpinan, dan masih banyak lagi. Outputnya adalah Anggota LDK Syahid menjadi generasi emas menyongsong kehidupan masyarakat madani.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-visi" role="tabpanel" aria-labelledby="pills-visi-tab">
                            <div class="col-lg-4">
                                <div class="card shadow">
                                    <div class="card-body">
                                        <p style="text-align: justify" class="mobile-body-font">
                                            “Terciptanya insan-insan dakwah yang memiliki kekokohan spiritualitas, intelektualitas, dan solidaritas dengan etos profesionalisme menuju kampus yang islami dalam rangka mewujudkan khairu ummah.”
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-misi" role="tabpanel" aria-labelledby="pills-misi-tab"><div class="col-lg-4">
                            <div class="card shadow">
                                <div class="card-body">
                                    <ol class="mobile-body-font">
                                        <li>Tarbiyah Madal Hayah (Pendidikan Sepanjang Hidup)</li>
                                        <li>Amal Sholeh (Perbuatan yang Baik)</li>
                                        <li>Amar Ma’ruf Nahi Mungkar (Memerintahkan yang Baik dan Mencegah yang Mungkar)</li>
                                        <li>Khidmatul Ummah (Pengabdian Masyarakat)</li>
                                        <li>Wihdatul Ummah dan Ukhuwah Islamiyah (Persatuan Umat dan Ukhuwah Islamiyah)</li>
                                    </ol>
                                </div>
                            </div>
                        </div></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
