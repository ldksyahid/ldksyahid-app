@extends('landing-page.template.body')

@section('content')
<div class="member-profile">
    <!-- Hero Section -->
    <div class="hero-section" style="background: linear-gradient(135deg, #008F8F 0%, #006D6D 100%);">
        <div class="container py-5">
            <div class="row align-items-center">
                <!-- Profile Photo -->
                <div class="col-lg-4 text-center text-lg-start mb-4 mb-lg-0">
                    <div class="profile-photo-container">
                        @if (!empty($ktaData->gdrive_id))
                            <img class="profile-photo wow fadeInUp" data-wow-delay="0.3s" src="https://lh3.googleusercontent.com/d/{{ $ktaData->gdrive_id }}" alt="{{ $ktaData->fullName }}">
                        @else
                            @if ($ktaData->gender != "Male")
                                <img class="profile-photo wow fadeInUp" data-wow-delay="0.3s" src="https://lh3.googleusercontent.com/d/15Q9hUkS-yvTBCtF4_KZUy9o725MZ9z6n" alt="Default Female">
                            @else
                                <img class="profile-photo wow fadeInUp" data-wow-delay="0.3s" src="https://lh3.googleusercontent.com/d/1CACDd_5vjzM82KTR08ND_nGbqtePHRsj" alt="Default Male">
                            @endif
                        @endif
                        <div class="profile-badge" style="background: black; border: 2px solid white;">
                            <img src="https://lh3.googleusercontent.com/d/1LsDxFAt1WU66CNp-2CN3J2qWXXJHlWIY" alt="LDK Syahid Badge">
                        </div>
                    </div>
                </div>

                <!-- Profile Header -->
                <div class="col-lg-8">
                    <div class="profile-header">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-center text-md-start">
                            <div>
                                <h1 class="text-white mb-2">{{ $ktaData->fullName }}</h1>
                                <span class="member-badge">{{ $ktaData->memberNumber }}</span>
                            </div>
                            <div class="ldk-logo mt-3 mt-md-0">
                                <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" alt="LDK Syahid Logo">
                            </div>
                        </div>

                        <div class="profile-bio mt-4">
                            <p class="text-white">{{ $ktaData->background }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="container py-5">
        <div class="row">
            <!-- Left Column - Personal Info -->
            <div class="col-lg-6 mb-5 mb-lg-0">
                <div class="card profile-card">
                    <div class="card-header">
                        <h3 class="text-white"><i class="fas fa-user-circle me-2"></i>Biodata Anggota</h3>
                    </div>
                    <div class="card-body">
                        <div class="info-item row">
                            <div class="col-md-4">
                                <strong>NIM</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $ktaData->nim }}
                            </div>
                        </div>

                        <div class="info-item row">
                            <div class="col-md-4">
                                <strong>Fakultas</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $ktaData->getFaculty->facultyName }}
                            </div>
                        </div>

                        <div class="info-item row">
                            <div class="col-md-4">
                                <strong>Program Studi</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $ktaData->getMajor->majorName }}
                            </div>
                        </div>

                        <div class="info-item row">
                            <div class="col-md-4">
                                <strong>Angkatan</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $ktaData->getGeneration->generationName }}
                            </div>
                        </div>

                        @if (!empty($ktaData->email))
                        <div class="info-item row">
                            <div class="col-md-4">
                                <strong>Email</strong>
                            </div>
                            <div class="col-md-8">
                                {{ $ktaData->email }}
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Right Column - Slogan & Social Media -->
            <div class="col-lg-6">
                <!-- Slogan Card -->
                <div class="card slogan-card mb-4">
                    <div class="card-header">
                        <h3 class="text-white"><i class="fas fa-quote-left me-2"></i>Slogan</h3>
                    </div>
                    <div class="card-body">
                        <blockquote class="blockquote mb-0">
                            <p>"{{ $ktaData->slogan }}"</p>
                        </blockquote>
                    </div>
                </div>

                <!-- Social Media Card -->
                @if (!empty($ktaData->instagram) || !empty($ktaData->linkedIn))
                <div class="card social-card">
                    <div class="card-header">
                        <h3 class="text-white"><i class="fas fa-share-alt me-2"></i>Temui Saya</h3>
                    </div>
                    <div class="card-body">
                        <div class="social-links">
                            @if (!empty($ktaData->instagram))
                            <a href="{{ $ktaData->instagram }}" target="_blank" class="btn btn-instagram">
                                <i class="fab fa-instagram me-2"></i> Instagram
                            </a>
                            @endif

                            @if (!empty($ktaData->linkedIn))
                            <a href="{{ $ktaData->linkedIn }}" target="_blank" class="btn btn-linkedin">
                                <i class="fab fa-linkedin-in me-2"></i> LinkedIn
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Organization Info -->
    <div class="org-info-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="section-title">Tentang LDK Syahid</h2>
                <div class="divider"></div>
            </div>

            <div class="row">
                <div class="col-lg-6 mb-4 mb-lg-0">
                    <div class="org-card vision-card">
                        <div class="org-card-header">
                            <i class="fas fa-eye text-white"></i>
                            <h3 class="text-white">Visi</h3>
                        </div>
                        <div class="org-card-body">
                            <p>"Terciptanya insan-insan dakwah yang memiliki kekokohan spiritualitas, intelektualitas, dan solidaritas dengan etos profesionalisme menuju kampus yang islami dalam rangka mewujudkan khairu ummah."</p>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="org-card mission-card">
                        <div class="org-card-header">
                            <i class="fas fa-bullseye text-white"></i>
                            <h3 class="text-white">Misi</h3>
                        </div>
                        <div class="org-card-body">
                            <ol>
                                <li>Tarbiyah Madal Hayah (Pendidikan Sepanjang Hidup)</li>
                                <li>Amal Sholeh (Perbuatan yang Baik)</li>
                                <li>Amar Ma'ruf Nahi Mungkar (Memerintahkan yang Baik dan Mencegah yang Mungkar)</li>
                                <li>Khidmatul Ummah (Pengabdian Masyarakat)</li>
                                <li>Wihdatul Ummah dan Ukhuwah Islamiyah (Persatuan Umat dan Ukhuwah Islamiyah)</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>

            <div class="org-description mt-5">
                <p>LDK Syahid adalah Salah satu Unit Kegiatan Mahasiswa (UKM) bidang keislaman di UIN Jakarta. Kegiatan-kegiatan yang dilakukan oleh LDK Syahid ialah Mentoring Pekanan, Kajian Keislaman, Rihlah, Upgrading Softskill, Menguatkan Ukhuwah Islamiyah, Management SDM, Management Problem Solved, Pembentukan Karakter Kepemimpinan, dan masih banyak lagi. Outputnya adalah Anggota LDK Syahid menjadi generasi emas menyongsong kehidupan masyarakat madani.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
    @include('landing-page.kta-ldksyahid.components._index-styles')
@endsection

@section('scripts')
    @include('landing-page.kta-ldksyahid.components._index-scripts')
@endsection
