@extends('landing-page.template.body')

@section('styles')
@include('landing-page.about.contact-us.components._index-styles')
@endsection

@section('content')

{{-- =============================================
     INFO CARDS DATA
     ============================================= --}}
@php
$cuInfoCards = [
    [
        'icon'  => '🏛️',
        'title' => 'Alamat Lengkap',
        'value' => 'Gedung Student Center Lt. 3, Ruang LDK Syahid, UIN Syarif Hidayatullah Jakarta, Jl. Ir. H. Djuanda No. 95, Ciputat Tim., Tangerang Selatan, Banten 15412',
        'color' => 'primary',
        'link'  => null,
    ],
    [
        'icon'  => '📱',
        'title' => 'WhatsApp',
        'value' => '+62 851-5936-0504',
        'sub'   => 'Admin LDK Syahid UIN Jakarta',
        'color' => 'green',
        'link'  => 'https://wa.me/6285159360504',
    ],
    [
        'icon'  => '✉️',
        'title' => 'Email',
        'value' => 'ldk.ormawa@apps.uinjkt.ac.id',
        'sub'   => 'Admin LDK Syahid UIN Jakarta',
        'color' => 'teal',
        'link'  => 'mailto:ldk.ormawa@apps.uinjkt.ac.id',
    ],
    [
        'icon'    => '🌐',
        'title'   => 'Sosial Media',
        'color'   => 'info',
        'link'    => null,
        'value'   => 'Instagram, YouTube, Twitter, Facebook, LinkedIn',
        'socials' => [
            ['icon' => 'fab fa-instagram',  'label' => '@ldksyahid',         'link' => 'https://www.instagram.com/ldksyahid/'],
            ['icon' => 'fab fa-youtube',    'label' => 'youtube/syahidtv',   'link' => 'https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ'],
            ['icon' => 'fab fa-twitter',    'label' => '@ldksyahid',         'link' => 'https://twitter.com/ldksyahid/'],
            ['icon' => 'fab fa-facebook-f', 'label' => 'facebook/ldksyahid', 'link' => 'https://www.facebook.com/ldksyahid/'],
            ['icon' => 'fab fa-linkedin',   'label' => 'linkedin/ldksyahid', 'link' => 'https://www.linkedin.com/company/ukm-ldk-syahid-uin-syarif-hidayatullah-jakarta/'],
        ],
    ],
];
@endphp

{{-- =============================================
     HERO / JUMBOTRON SECTION
     Identical structure to home jumbotron (empty/hadith state)
     No content overlay on image
     ============================================= --}}
<section class="hero-fun wow fadeIn" data-wow-delay="0.1s">
    <div class="hero-carousel-wrapper">
        <div class="hero-carousel-card">

            {{-- Image Only — No Overlay --}}
            <div class="hero-slide">
                <img class="hero-image"
                     src="https://lh3.googleusercontent.com/d/1Xt3HVJLvYBrcxcg-HyNK2pKOQ7WUIQBj"
                     alt="Hubungi Kami" />
            </div>

            {{-- Desktop Hadith Content (Below Image) — identical to jumbotron empty state --}}
            <div class="hero-desktop-content d-none d-lg-block">

                {{-- Background Animation & Icons --}}
                <div class="hadith-background-animation">
                    <div class="floating-icon icon-1">📖</div>
                    <div class="floating-icon icon-2">🕌</div>
                    <div class="floating-icon icon-3">✨</div>
                    <div class="floating-icon icon-4">🌙</div>
                    <div class="floating-icon icon-5">⭐</div>
                    <div class="floating-icon icon-6">☪️</div>
                    <div class="floating-icon icon-7">📚</div>
                    <div class="floating-icon icon-8">🤲</div>
                    <div class="floating-shape shape-1"></div>
                    <div class="floating-shape shape-2"></div>
                </div>

                {{-- Countdown Timer - Bottom Right --}}
                <div class="desktop-countdown">
                    <span>Hadits berikutnya dalam</span>
                    <span class="desktop-countdown-number" id="cu-countdown-desktop">60</span>
                    <span>detik</span>
                </div>

                {{-- White Curved Divider --}}
                <div class="hero-divider-desktop"></div>

                <div class="container position-relative" style="z-index: 20;">
                    <div class="row justify-content-center">
                        <div class="col-lg-10 col-xl-8">
                            <div class="hero-desktop-card">
                                <div class="hero-desktop-badge">
                                    <span class="badge-icon">📖</span>
                                    <span class="hadith-fade-text" id="cu-source-desktop">Hadits dalam 1 Menit</span>
                                </div>

                                <div class="hadith-desktop-wrapper" id="cu-wrapper-desktop">
                                    <p class="hero-desktop-arab hadith-fade-text" id="cu-arab-desktop"></p>
                                    <p class="hero-desktop-text hadith-fade-text" id="cu-text-desktop">
                                        <span class="loading-text">Sedang Menyiapkan Hadits</span>
                                        <span class="loading-dots">
                                            <span class="dot">.</span>
                                            <span class="dot">.</span>
                                            <span class="dot">.</span>
                                        </span>
                                    </p>
                                    <span class="hero-desktop-number hadith-fade-text" id="cu-num-desktop"></span>
                                </div>

                                <button class="desktop-toggle-btn" id="cu-toggle-desktop">
                                    <span class="toggle-text">Selengkapnya</span>
                                    <i class="fas fa-chevron-down"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /hero-desktop-content --}}

            {{-- Mobile Content (Below Image) --}}
            <div class="hero-mobile-content d-lg-none" id="cu-hadith-mobile-content">

                {{-- Background Animation for Mobile --}}
                <div class="hadith-background-animation mobile">
                    <div class="floating-icon icon-1">📖</div>
                    <div class="floating-icon icon-3">✨</div>
                    <div class="floating-icon icon-5">🕌</div>
                    <div class="floating-shape shape-1"></div>
                    <div class="floating-shape shape-2"></div>
                </div>

                {{-- White Curved Divider Mobile --}}
                <div class="hero-divider-mobile"></div>

                {{-- Hadith Badge --}}
                <div class="hero-mobile-badge cu-hadith-badge-m">
                    <span class="badge-icon">📖</span>
                    <span class="hadith-fade-text" id="cu-source-mobile">Hadits dalam 1 Menit</span>
                </div>

                {{-- Hadith Content --}}
                <div class="hadith-mobile-wrapper" id="cu-wrapper-mobile">
                    <p class="hero-mobile-arab hadith-fade-text" id="cu-arab-mobile"></p>
                    <p class="hero-mobile-desc hadith-fade-text" id="cu-text-mobile">
                        <span class="loading-text">Sedang Menyiapkan Hadits</span>
                        <span class="loading-dots">
                            <span class="dot">.</span>
                            <span class="dot">.</span>
                            <span class="dot">.</span>
                        </span>
                    </p>
                    <span class="hadith-number hadith-fade-text" id="cu-num-mobile"></span>
                </div>

                <div class="mobile-action-area">
                    <button class="hadith-toggle" id="cu-toggle-mobile">
                        <span class="hadith-toggle-text">Selengkapnya</span>
                        <i class="fas fa-chevron-down"></i>
                    </button>
                    <div class="mobile-countdown">
                        <span>Hadits berikutnya dalam</span>
                        <span class="mobile-countdown-number" id="cu-countdown-mobile">60</span>
                        <span>detik</span>
                    </div>
                </div>

            </div>{{-- /hero-mobile-content --}}

        </div>{{-- /hero-carousel-card --}}
    </div>{{-- /hero-carousel-wrapper --}}
</section>


{{-- =============================================
     INFO CARDS SECTION
     ============================================= --}}
<section class="cu-info-section py-5">
    <div class="container">

        <div class="text-center mb-5 wow fadeInUp" data-wow-delay="0.1s">
            <div class="cu-section-badge">
                <span>📍</span>
                <span>Temukan Kami</span>
                <span class="cu-badge-pulse"></span>
            </div>
            <h2 class="cu-section-title mt-3">Informasi Kontak</h2>
            <p class="cu-section-sub">Hubungi kami melalui berbagai saluran yang tersedia</p>
        </div>

        {{-- Desktop Grid --}}
        <div class="cu-info-grid cu-desktop-only wow fadeInUp" data-wow-delay="0.2s">
            @foreach($cuInfoCards as $i => $card)
            <div class="cu-info-card cu-card--{{ $card['color'] }}" data-card-index="{{ $i }}">
                <div class="cu-card-num">{{ sprintf('%02d', $i + 1) }}</div>
                <div class="cu-card-icon">{{ $card['icon'] }}</div>
                <h5 class="cu-card-title">{{ $card['title'] }}</h5>
                @if(isset($card['socials']))
                    <div class="cu-socials">
                        @foreach($card['socials'] as $s)
                        <a href="{{ $s['link'] }}" target="_blank" class="cu-social-link">
                            <i class="{{ $s['icon'] }}"></i>
                            <span>{{ $s['label'] }}</span>
                        </a>
                        @endforeach
                    </div>
                @else
                    @if($card['link'])
                        <a href="{{ $card['link'] }}" target="_blank" class="cu-card-value">{{ $card['value'] }}</a>
                    @else
                        <p class="cu-card-value">{{ $card['value'] }}</p>
                    @endif
                    @isset($card['sub'])<span class="cu-card-sub">{{ $card['sub'] }}</span>@endisset
                @endif
            </div>
            @endforeach
        </div>

        {{-- Mobile Carousel --}}
        <div class="cu-mobile-only wow fadeInUp" data-wow-delay="0.2s">
            <div class="owl-carousel cu-owl" id="cu-info-owl">
                @foreach($cuInfoCards as $i => $card)
                <div class="cu-info-card cu-card--{{ $card['color'] }} cu-mobile-card"
                     data-card-index="{{ $i }}"
                     data-card-title="{{ $card['title'] }}"
                     data-card-icon="{{ $card['icon'] }}"
                     data-card-color="{{ $card['color'] }}">
                    <div class="cu-card-num">{{ sprintf('%02d', $i + 1) }}</div>
                    <div class="cu-card-icon">{{ $card['icon'] }}</div>
                    <h5 class="cu-card-title">{{ $card['title'] }}</h5>
                    @if(isset($card['socials']))
                        <div class="cu-socials">
                            @foreach($card['socials'] as $s)
                            <a href="{{ $s['link'] }}" target="_blank" class="cu-social-link">
                                <i class="{{ $s['icon'] }}"></i>
                                <span>{{ $s['label'] }}</span>
                            </a>
                            @endforeach
                        </div>
                    @else
                        @if($card['link'])
                            <a href="{{ $card['link'] }}" target="_blank" class="cu-card-value">{{ $card['value'] }}</a>
                        @else
                            <p class="cu-card-value">{{ $card['value'] }}</p>
                        @endif
                        @isset($card['sub'])<span class="cu-card-sub">{{ $card['sub'] }}</span>@endisset
                    @endif
                    <div class="cu-tap-hint">
                        <span>Ketuk untuk detail</span>
                        <i class="fas fa-hand-pointer"></i>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="cu-owl-dots" id="cu-owl-dots"></div>
        </div>

    </div>
</section>


{{-- =============================================
     MAP + FORM SECTION
     ============================================= --}}
<section class="cu-map-form py-5" id="cu-form-section">
    <div class="container">
        <div class="row g-5 align-items-start">

            {{-- Map --}}
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                {{-- Section header --}}
                <div class="mb-3">
                    <div class="cu-section-badge">
                        <span>🗺️</span>
                        <span>Lokasi Kami</span>
                    </div>
                    <h3 class="cu-section-title mt-3 mb-1">Temukan Kami di Sini</h3>
                    <p class="cu-section-sub">LDK Syahid, Gedung Student Center Lt. 3</p>
                </div>

                {{-- Location info chips --}}
                <div class="cu-loc-row">
                    <div class="cu-loc-chip">
                        <span class="cu-loc-ico">🏛️</span>
                        <div>
                            <span class="cu-loc-label">Gedung</span>
                            <span class="cu-loc-val">Student Center Lt. 3</span>
                        </div>
                    </div>
                    <div class="cu-loc-chip">
                        <span class="cu-loc-ico">📍</span>
                        <div>
                            <span class="cu-loc-label">Kota</span>
                            <span class="cu-loc-val">Ciputat, Tangerang Selatan</span>
                        </div>
                    </div>
                </div>

                {{-- Map iframe --}}
                <div class="cu-map-wrap">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6773009952885!2d106.75319361449397!3d-6.306059963469107!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69efd9636c9d6b%3A0x71fbe6e9045945ff!2sLDK%20Syahid%20UIN%20Syarif%20Hidayatullah%20Jakarta!5e0!3m2!1sen!2sid!4v1664598000447!5m2!1sen!2sid"
                        frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false" tabindex="0" title="Lokasi LDK Syahid">
                    </iframe>
                    <a href="https://www.google.com/maps/place/LDK+Syahid+UIN+Syarif+Hidayatullah+Jakarta/@-6.306059963469107,106.75319361449397,17z"
                       target="_blank" rel="noopener" class="cu-map-open-btn">
                        <i class="fas fa-location-arrow"></i>
                        <span>Buka di Google Maps</span>
                    </a>
                </div>
            </div>

            {{-- Form --}}
            <div class="col-lg-6 wow fadeInRight" data-wow-delay="0.2s">
                <div class="cu-section-header mb-4">
                    <div class="cu-section-badge">
                        <span>✉️</span>
                        <span>Kirim Pesan</span>
                        <span class="cu-badge-pulse"></span>
                    </div>
                    <h3 class="cu-section-title mt-3">Jika Kamu Memiliki Pertanyaan</h3>
                    <p class="cu-section-sub">Kami akan segera membalas pesanmu, InsyaAllah.</p>
                </div>
                <div class="cu-form-card">
                    <form role="form"
                          action="/about/contact/message/store"
                          method="post"
                          enctype="multipart/form-data"
                          id="cu-contact-form"
                          novalidate>
                        @csrf
                        @method('POST')

                        <div class="cu-form-row">
                            <div class="cu-form-group">
                                <label class="cu-form-label" for="cu-name">
                                    <span>👤</span> Nama Kamu <span class="cu-req">*</span>
                                </label>
                                <input type="text" class="cu-form-input"
                                       id="cu-name" name="name"
                                       placeholder="Masukkan namamu"
                                       required minlength="3" maxlength="100" />
                                <span class="cu-form-error">Nama wajib diisi (min. 3 karakter)</span>
                            </div>
                            <div class="cu-form-group">
                                <label class="cu-form-label" for="cu-email">
                                    <span>📧</span> Email Kamu <span class="cu-req">*</span>
                                </label>
                                <input type="email" class="cu-form-input"
                                       id="cu-email" name="email"
                                       placeholder="Masukkan emailmu"
                                       required />
                                <span class="cu-form-error">Email wajib diisi dengan format yang benar</span>
                            </div>
                        </div>

                        <div class="cu-form-group">
                            <label class="cu-form-label" for="cu-subject">
                                <span>📌</span> Subjek <span class="cu-req">*</span>
                            </label>
                            <input type="text" class="cu-form-input"
                                   id="cu-subject" name="subject"
                                   placeholder="Tentang apa pesanmu?"
                                   required minlength="5" maxlength="200" />
                            <span class="cu-form-error">Subjek wajib diisi (min. 5 karakter)</span>
                        </div>

                        <div class="cu-form-group">
                            <label class="cu-form-label" for="cu-message">
                                <span>💭</span> Pesan <span class="cu-req">*</span>
                            </label>
                            <textarea class="cu-form-textarea"
                                      id="cu-message" name="message"
                                      rows="4"
                                      placeholder="Tulis pesanmu di sini..."
                                      required minlength="10" maxlength="1000"></textarea>
                            <span class="cu-form-error">Pesan wajib diisi (min. 10 karakter)</span>
                        </div>

                        <button class="cu-form-submit" type="submit">
                            <span class="cu-btn-emoji">🚀</span>
                            <span class="cu-btn-txt">Kirim Pesan</span>
                            <i class="fas fa-paper-plane cu-btn-ico"></i>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</section>


{{-- =============================================
     MOBILE BOTTOM SHEET
     ============================================= --}}
<div class="cu-bs-backdrop" id="cu-bs-backdrop"></div>
<div class="cu-bottom-sheet" id="cu-bottom-sheet" role="dialog" aria-modal="true" aria-label="Detail kontak">
    <div class="cu-bs-handle"></div>
    <button class="cu-bs-close" id="cu-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="cu-bs-content" id="cu-bs-content"></div>
</div>

@endsection

@section('scripts')
@include('landing-page.about.contact-us.components._index-scripts')
@endsection
