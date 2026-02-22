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
        'value'   => 'Instagram, YouTube, Twitter, Facebook',
        'socials' => [
            ['icon' => 'fab fa-instagram',  'label' => '@ldksyahid',         'link' => 'https://www.instagram.com/ldksyahid/'],
            ['icon' => 'fab fa-youtube',    'label' => 'youtube/syahidtv',   'link' => 'https://www.youtube.com/channel/UCJ-SyxQN5sG4CzO0waSYpBQ'],
            ['icon' => 'fab fa-twitter',    'label' => '@ldksyahid',         'link' => 'https://twitter.com/ldksyahid/'],
            ['icon' => 'fab fa-facebook-f', 'label' => 'facebook/ldksyahid', 'link' => 'https://www.facebook.com/ldksyahid/'],
        ],
    ],
];
@endphp

{{-- =============================================
     HERO / JUMBOTRON SECTION
     ============================================= --}}
<section class="cu-hero wow fadeIn" data-wow-delay="0.1s">

    {{-- Hero Card Wrapper --}}
    <div class="cu-hero-wrap">
        <div class="cu-hero-img-box">
            <img class="cu-hero-img"
                 src="https://lh3.googleusercontent.com/d/1Xt3HVJLvYBrcxcg-HyNK2pKOQ7WUIQBj"
                 alt="Hubungi Kami" />
            <div class="cu-hero-overlay"></div>
        </div>

        {{-- Desktop Content Overlay --}}
        <div class="cu-hero-content d-none d-lg-flex">
            <div class="container h-100">
                <div class="row h-100 align-items-center">
                    <div class="col-lg-7">
                        <div class="cu-hero-box">
                            <div class="cu-hero-badge animate__animated animate__fadeInDown">
                                <span>💬</span>
                                <span>Hubungi Kami</span>
                            </div>
                            <h1 class="cu-hero-title animate__animated animate__fadeInUp">
                                Ada Pertanyaan?<br>Yuk Hubungi Kami!
                            </h1>
                            <a href="#cu-form-section"
                               class="cu-hero-btn animate__animated animate__fadeInUp animate__delay-1s">
                                <span>Kirim Pesan</span>
                                <i class="fas fa-paper-plane"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Desktop Hadith Section --}}
    <div class="cu-hadith-wrap d-none d-lg-block">
        <div class="cu-hadith-divider"></div>
        <div class="container position-relative" style="z-index: 10;">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-8">
                    <div class="cu-hadith-card">
                        <div class="cu-hadith-badge">
                            <span>📖</span>
                            <span class="cu-fade-text" id="cu-src-desktop">Hadits dalam 1 Menit</span>
                        </div>
                        <div class="cu-hadith-body" id="cu-body-desktop">
                            <p class="cu-hadith-arab cu-fade-text" id="cu-arab-desktop"></p>
                            <p class="cu-hadith-text cu-fade-text" id="cu-text-desktop">
                                <span class="cu-load-txt">Sedang Menyiapkan Hadits</span>
                                <span class="cu-load-dots">
                                    <span class="cu-dot">.</span>
                                    <span class="cu-dot">.</span>
                                    <span class="cu-dot">.</span>
                                </span>
                            </p>
                            <span class="cu-hadith-num cu-fade-text" id="cu-num-desktop"></span>
                        </div>
                        <div class="cu-hadith-footer">
                            <button class="cu-toggle" id="cu-toggle-desktop">
                                <span class="cu-toggle-txt">Selengkapnya</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="cu-countdown">
                                <span>Hadits berikutnya dalam</span>
                                <span class="cu-countdown-num" id="cu-cdown-desktop">60</span>
                                <span>detik</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Mobile Hero Content --}}
    <div class="cu-mobile-hero d-lg-none">
        <div class="cu-mobile-badge">
            <span>💬</span>
            <span>Hubungi Kami</span>
        </div>
        <h2 class="cu-mobile-title">Ada Pertanyaan?<br>Yuk Hubungi Kami!</h2>
        <a href="#cu-form-section" class="cu-mobile-btn">
            <span>Kirim Pesan</span>
            <i class="fas fa-paper-plane"></i>
        </a>
    </div>

    {{-- Mobile Hadith Section --}}
    <div class="cu-hadith-wrap-mobile d-lg-none">
        <div class="cu-hadith-divider-mobile"></div>
        <div class="cu-hadith-card-mobile">
            <div class="cu-hadith-badge-mobile">
                <span>📖</span>
                <span class="cu-fade-text" id="cu-src-mobile">Hadits dalam 1 Menit</span>
            </div>
            <div class="cu-hadith-body-mobile" id="cu-body-mobile">
                <p class="cu-hadith-arab cu-fade-text" id="cu-arab-mobile"></p>
                <p class="cu-hadith-text-mobile cu-fade-text" id="cu-text-mobile">
                    <span class="cu-load-txt">Sedang Menyiapkan Hadits</span>
                    <span class="cu-load-dots">
                        <span class="cu-dot">.</span>
                        <span class="cu-dot">.</span>
                        <span class="cu-dot">.</span>
                    </span>
                </p>
                <span class="cu-hadith-num cu-fade-text" id="cu-num-mobile"></span>
            </div>
            <div class="cu-hadith-footer-mobile">
                <button class="cu-toggle-mobile" id="cu-toggle-mobile">
                    <span class="cu-toggle-txt-m">Selengkapnya</span>
                    <i class="fas fa-chevron-down"></i>
                </button>
                <div class="cu-countdown-mobile">
                    <span>Berikutnya</span>
                    <span class="cu-countdown-num" id="cu-cdown-mobile">60</span>
                    <span>dtk</span>
                </div>
            </div>
        </div>
    </div>

</section>


{{-- =============================================
     INFO CARDS SECTION
     ============================================= --}}
<section class="cu-info-section py-5">
    <div class="container">

        {{-- Section Header --}}
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

            {{-- Map Column --}}
            <div class="col-lg-6 wow fadeInLeft" data-wow-delay="0.1s">
                <div class="cu-section-header mb-4">
                    <div class="cu-section-badge">
                        <span>🗺️</span>
                        <span>Lokasi Kami</span>
                    </div>
                    <h3 class="cu-section-title mt-3">Temukan Kami di Sini</h3>
                    <p class="cu-section-sub">Gedung Student Center Lt. 3, UIN Syarif Hidayatullah Jakarta</p>
                </div>
                <div class="cu-map-wrap">
                    <iframe
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.6773009952885!2d106.75319361449397!3d-6.306059963469107!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69efd9636c9d6b%3A0x71fbe6e9045945ff!2sLDK%20Syahid%20UIN%20Syarif%20Hidayatullah%20Jakarta!5e0!3m2!1sen!2sid!4v1664598000447!5m2!1sen!2sid"
                        frameborder="0" style="border:0;" allowfullscreen=""
                        aria-hidden="false" tabindex="0"
                        title="Lokasi LDK Syahid">
                    </iframe>
                </div>
            </div>

            {{-- Form Column --}}
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
    <div class="cu-bs-handle" id="cu-bs-handle"></div>
    <button class="cu-bs-close" id="cu-bs-close" aria-label="Tutup">
        <i class="fas fa-times"></i>
    </button>
    <div class="cu-bs-content" id="cu-bs-content">
        {{-- Filled dynamically by JS --}}
    </div>
</div>

{{-- Toast Container --}}
<div class="cu-toast-container" id="cu-toast-container" aria-live="polite" aria-atomic="true"></div>

@endsection

@section('scripts')
@include('landing-page.about.contact-us.components._index-scripts')
@endsection
