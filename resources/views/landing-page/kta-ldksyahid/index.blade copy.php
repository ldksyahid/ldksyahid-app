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
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <h1 class="text-white mb-2">{{ $ktaData->fullName }}</h1>
                                <span class="member-badge">{{ $ktaData->memberNumber }}</span>
                            </div>
                            <div class="ldk-logo">
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
<style>
.member-profile {
    font-family: 'Poppins', sans-serif;
}

/* Hero Section */
.hero-section {
    position: relative;
    overflow: hidden;
}

.hero-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: url('https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1') no-repeat;
    background-size: cover;
    opacity: 0.05;
    z-index: 0;
}

.profile-photo-container {
    position: relative;
    display: inline-block;
}

.profile-photo {
    width: 250px;
    height: 300px;
    object-fit: cover;
    border-radius: 15px;
    border: 5px solid white;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    transition: transform 0.3s ease;
}

.profile-photo:hover {
    transform: scale(1.03);
}

.profile-badge {
    position: absolute;
    bottom: -15px;
    right: -15px;
    background: black;
    border: 2px solid white; /* Added white border */
    border-radius: 50%;
    padding: 5px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.profile-badge img {
    width: 60px;
    height: 60px;
    border-radius: 50%;
}

.profile-header h1 {
    font-weight: 700;
    font-size: 2.5rem;
    text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
}

.member-badge {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    padding: 5px 15px;
    border-radius: 20px;
    font-size: 0.9rem;
    font-weight: 500;
    backdrop-filter: blur(5px);
    border: 1px solid rgba(255, 255, 255, 0.3);
}

.ldk-logo img {
    width: 80px;
    opacity: 0.9;
}

.profile-bio {
    font-size: 1.1rem;
    line-height: 1.7;
}

/* Cards */
.card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    margin-bottom: 20px;
    overflow: hidden;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
}

.card-header {
    background: linear-gradient(135deg, #006D6D 0%, #004A4A 100%) !important;
    color: white;
    border-bottom: none;
    padding: 15px 25px;
}

.card-header h3 {
    font-size: 1.3rem;
    margin: 0;
    font-weight: 600;
    color: white; /* Added to ensure white text */
}

.card-body {
    padding: 25px;
}

/* Info Items */
.info-item {
    padding: 12px 0;
    border-bottom: 1px solid rgba(0, 0, 0, 0.05);
}

.info-item:last-child {
    border-bottom: none;
}

.info-item strong {
    color: #008F8F;
}

/* Slogan Card */
.slogan-card .card-body {
    background-color: #f8f9fa;
}

.slogan-card blockquote {
    font-style: italic;
    color: #555;
    font-size: 1.1rem;
    position: relative;
}

.slogan-card blockquote::before {
    content: '"';
    font-size: 3rem;
    color: rgba(0, 143, 143, 0.1);
    position: absolute;
    left: -15px;
    top: -15px;
}

/* Social Card */
.social-links {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}

.btn-instagram {
    background: linear-gradient(45deg, #405DE6, #5851DB, #833AB4, #C13584, #E1306C, #FD1D1D);
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 15px;
    transition: transform 0.3s ease;
}

.btn-linkedin {
    background: #0077B5;
    color: white;
    border: none;
    border-radius: 8px;
    padding: 8px 15px;
    transition: transform 0.3s ease;
}

.btn-instagram:hover, .btn-linkedin:hover {
    transform: translateY(-3px);
    color: white;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

/* Organization Info */
.org-info-section {
    background-color: #f9f9f9;
}

.section-title {
    color: #006D6D; /* Changed from white to #008F8F */
    font-weight: 700;
    position: relative;
    display: inline-block;
}

.divider {
    height: 3px;
    width: 80px;
    background: #006D6D; /* Changed gradient to solid #008F8F */
    margin: 10px auto;
    border-radius: 3px;
}

.org-card {
    background: white;
    border-radius: 15px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    overflow: hidden;
    height: 100%;
}

.org-card-header {
    background: linear-gradient(135deg, #006D6D 0%, #004A4A 100%) !important;
    color: white;
    padding: 20px;
    display: flex;
    align-items: center;
}

.org-card-header i {
    font-size: 1.5rem;
    margin-right: 15px;
    color: white; /* Added to ensure white icons */
}

.org-card-header h3 {
    margin: 0;
    font-size: 1.3rem;
    font-weight: 600;
    color: white; /* Added to ensure white text */
}

.org-card-body {
    padding: 20px;
}

.vision-card .org-card-body {
    background-color: rgba(0, 143, 143, 0.05);
}

.mission-card .org-card-body {
    background-color: rgba(0, 109, 109, 0.05);
}

.org-card-body ol {
    padding-left: 20px;
}

.org-card-body li {
    margin-bottom: 8px;
}

.org-description {
    background: white;
    padding: 30px;
    border-radius: 15px;
    box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
    line-height: 1.8;
    color: #555;
}

/* Responsive */
@media (max-width: 992px) {
    .profile-header h1 {
        font-size: 2rem;
    }

    .profile-photo {
        width: 200px;
        height: 250px;
    }
}

@media (max-width: 768px) {
    .hero-section {
        text-align: center;
    }

    .profile-header {
        text-align: center;
    }

    .ldk-logo {
        display: none;
    }

    .profile-badge {
        right: 50%;
        transform: translateX(50%);
    }
}
</style>
@endsection

@section('scripts')
<script>
// Add any necessary JavaScript here
$(document).ready(function() {
    // Animation trigger
    $('.card').hover(
        function() {
            $(this).find('.card-header').css('background', 'linear-gradient(135deg, #006D6D 0%, #008F8F 100%)');
        },
        function() {
            $(this).find('.card-header').css('background', 'linear-gradient(135deg, #008F8F 0%, #006D6D 100%)');
        }
    );
});
</script>
@endsection
