@extends('landing-page.template.body')

@section('styles')
@include('landing-page.profile.components._index-styles')
@endsection

@section('content')
<section class="prf-section mt-5" id="photo">

    {{-- ===== HERO ===== --}}
    <div class="prf-hero">

        {{-- Photo Column --}}
        <div class="prf-photo-wrap wow fadeIn" data-wow-delay="0.1s">
            <div class="prf-photo-frame">
                @if (Auth::User()->profile->profilepicture == null)
                    <img src="{{ Avatar::create(Auth::user()->name)->setFontFamily('Comic Sans MS')->setShape('square')->setDimension(500)->setFontSize(250)->toBase64() }}"
                         alt="{{ Auth::user()->name }}">
                @else
                    <img src="https://lh3.googleusercontent.com/d/{{ Auth::User()->profile->gdrive_id }}"
                         alt="{{ Auth::user()->name }}">
                @endif
                {{-- Member Pill inside frame --}}
                <span class="prf-member-pill">{{ Auth::User()->profile->nomoranggota }}</span>
            </div>

            {{-- Sifat Badge --}}
            <span class="prf-sifat-badge">Si Paling {{ Auth::User()->profile->sifat }}</span>

            {{-- Delete Photo (only when photo exists) --}}
            @if (Auth::User()->profile->profilepicture != null)
            <div class="prf-delete-photo-form">
                <form action="/profile/{{ Auth::User()->id }}/destroy" method="post" id="prf-form-delete-photo">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="prf-delete-photo-btn">
                        <i class="fas fa-trash-alt"></i> Hapus Foto Profil
                    </button>
                </form>
            </div>
            @endif
        </div>

        {{-- Bio Column --}}
        <div class="prf-bio-wrap wow fadeInUp" data-wow-delay="0.2s">
            <div class="prf-bio-header">
                <div class="prf-bio-name-group">
                    <h1 class="prf-name">{{ Auth::User()->profile->namapanggilan }}</h1>
                    <p class="prf-fullname">{{ Auth::user()->name }}</p>
                </div>
                <img class="prf-bio-logo"
                     src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1"
                     alt="LDK Syahid">
            </div>

            <div class="prf-bio-divider"></div>

            <p class="prf-tentang">{{ Auth::User()->profile->tentangdiri }}</p>
        </div>
    </div>

    {{-- ===== INFO CARDS ===== --}}
    <div class="prf-info-section">

        {{-- Academic Card --}}
        <div class="prf-info-card wow fadeInUp" data-wow-delay="0.3s">
            <p class="prf-card-title"><i class="fas fa-graduation-cap me-2"></i>Informasi Akademik</p>
            <div class="prf-info-grid">

                <div class="prf-info-item">
                    <span class="prf-bullet"></span>
                    <div>
                        <p class="prf-item-label">Universitas</p>
                        <p class="prf-item-value">{{ Auth::User()->profile->universitas }}</p>
                    </div>
                </div>

                <div class="prf-info-item">
                    <span class="prf-bullet"></span>
                    <div>
                        <p class="prf-item-label">NIM</p>
                        <p class="prf-item-value">{{ Auth::User()->profile->nim }}</p>
                    </div>
                </div>

                <div class="prf-info-item">
                    <span class="prf-bullet"></span>
                    <div>
                        <p class="prf-item-label">Fakultas</p>
                        <p class="prf-item-value">{{ Auth::User()->profile->fakultas }}</p>
                    </div>
                </div>

                <div class="prf-info-item">
                    <span class="prf-bullet"></span>
                    <div>
                        <p class="prf-item-label">Program Studi</p>
                        <p class="prf-item-value">{{ Auth::User()->profile->programstudi }}</p>
                    </div>
                </div>

                <div class="prf-info-item">
                    <span class="prf-bullet"></span>
                    <div>
                        <p class="prf-item-label">Forum Angkatan</p>
                        <p class="prf-item-value">{{ Auth::User()->profile->forkat }}</p>
                    </div>
                </div>

                <div class="prf-info-item">
                    <span class="prf-bullet"></span>
                    <div>
                        <p class="prf-item-label">Email</p>
                        <p class="prf-item-value">{{ Auth::user()->email }}</p>
                    </div>
                </div>

            </div>
        </div>

        {{-- Social & Motto Card --}}
        <div class="prf-info-card wow fadeInUp" data-wow-delay="0.4s">
            <p class="prf-card-title"><i class="fas fa-user-circle me-2"></i>Sosial & Motto</p>
            <div class="prf-info-grid">

                <div class="prf-info-item">
                    <span class="prf-bullet"></span>
                    <div>
                        <p class="prf-item-label">Instagram</p>
                        <p class="prf-item-value">{{ Auth::User()->profile->akuninstagram }}</p>
                    </div>
                </div>

                <div class="prf-info-item">
                    <span class="prf-bullet"></span>
                    <div>
                        <p class="prf-item-label">LinkedIn</p>
                        <p class="prf-item-value">{{ Auth::User()->profile->akunlinkedin }}</p>
                    </div>
                </div>

                <div class="prf-info-item prf-info-item--full">
                    <span class="prf-bullet"></span>
                    <div>
                        <p class="prf-item-label">Motto Hidup</p>
                        <p class="prf-item-value">{{ Auth::User()->profile->mottohidup }}</p>
                    </div>
                </div>

            </div>
        </div>

    </div>

    {{-- ===== ACTION BUTTONS ===== --}}
    <div class="prf-actions-wrap wow fadeInUp" data-wow-delay="0.5s">
        <div class="prf-actions">
            <a href="/" class="prf-btn prf-btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
            <a href="/profile/{{ Auth::user()->id }}/edit" class="prf-btn prf-btn-edit">
                <i class="fas fa-edit"></i> Ubah Profil
            </a>
        </div>
    </div>

</section>
@endsection

@section('scripts')
@include('landing-page.profile.components._index-scripts')
@endsection
