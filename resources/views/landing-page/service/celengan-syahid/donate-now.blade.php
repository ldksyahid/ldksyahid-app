@extends('landing-page.template.body')

@php
    $coverSrc = $data->gdrive_id
                    ? 'https://lh3.googleusercontent.com/d/' . $data->gdrive_id
                    : 'https://lh3.googleusercontent.com/d/13hUNUJ_oQhmBGMRx37dj380dOhlsKm7O';
    $logoSrc  = $data->gdrive_id_1
                    ? 'https://lh3.googleusercontent.com/d/' . $data->gdrive_id_1
                    : 'https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1';
    $orgName  = ($data->nama_pj && $data->link_pj) ? $data->nama_pj : 'UKM LDK Syahid';
    $orgLink  = ($data->nama_pj && $data->link_pj) ? $data->link_pj : 'https://www.ldksyah.id/';
@endphp


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.service.celengan-syahid.components._donate-now._donate-now-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="dn-page py-5 mt-5">
    <div class="container" style="max-width: 720px;">

        {{-- ── Back Link ────────────────────────────────────────── --}}
        <a href="{{ route('service.celengansyahid.detail', $data->link) }}" class="dn-back-link wow fadeIn" data-wow-delay="0.05s">
            <i class="fas fa-arrow-left"></i>
            <span>Kembali ke Detail Campaign</span>
        </a>

        {{-- ── Campaign Context Header ─────────────────────────── --}}
        <div class="dn-context-wrap wow fadeInUp" data-wow-delay="0.1s">
            <div class="row g-0">
                <div class="col-4 col-md-3 dn-context-img-col">
                    <div class="dn-context-img-wrap">
                        <img src="{{ $coverSrc }}" alt="{{ $data->judul }}" class="dn-context-img">
                    </div>
                </div>
                <div class="col-8 col-md-9">
                    <div class="dn-context-info">
                        <span class="dn-context-label">
                            <i class="fas fa-heart me-1"></i> Donasi untuk
                        </span>
                        <h2 class="dn-context-title">{{ $data->judul }}</h2>
                        <div class="dn-context-org">
                            <img src="{{ $logoSrc }}" alt="{{ $orgName }}" class="dn-context-org-logo">
                            <a href="{{ $orgLink }}" target="_blank" class="dn-context-org-name">{{ $orgName }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ══════════════════════════════════════════════════
             FORM
             ══════════════════════════════════════════════════ --}}
        <form role="form"
              action="{{ url('/celengansyahid/donation/store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="dn-form"
              novalidate>
            @csrf
            @method('POST')
            <input type="hidden" name="postdonation"  value="{{ $data->id }}">
            <input type="hidden" name="linkcampaign"  value="{{ $data->link }}">
            <input type="hidden" name="totalDonasi"   id="dn-total-input" value="Rp0">

            {{-- ── Section 1: Nominal ─────────────────────────── --}}
            <div class="dn-section wow fadeInUp" data-wow-delay="0.12s">
                <h3 class="dn-section-title">
                    <i class="fas fa-wallet"></i> Nominal Donasi
                </h3>

                {{-- Amount input --}}
                <div class="dn-field">
                    <label class="dn-label" for="dn-amount-input">Masukkan Nominal</label>
                    <div class="dn-amount-input-wrap">
                        <span class="dn-amount-prefix">Rp</span>
                        <input type="text"
                               class="dn-amount-input"
                               id="dn-amount-input"
                               name="jumlah_donasi"
                               placeholder="0"
                               autocomplete="off"
                               required>
                    </div>
                    <div class="dn-invalid-msg">Nominal donasi wajib diisi (minimal Rp1.000)</div>
                </div>

                {{-- Preset buttons --}}
                <label class="dn-label">Atau pilih nominal</label>
                <div class="dn-presets">
                    <button type="button" class="dn-preset-btn" data-value="10000">Rp10.000</button>
                    <button type="button" class="dn-preset-btn" data-value="20000">Rp20.000</button>
                    <button type="button" class="dn-preset-btn" data-value="50000">Rp50.000</button>
                    <button type="button" class="dn-preset-btn" data-value="100000">Rp100.000</button>
                    <button type="button" class="dn-preset-btn" data-value="200000">Rp200.000</button>
                    <button type="button" class="dn-preset-btn" data-value="500000">Rp500.000</button>
                </div>
            </div>

            {{-- ── Section 2: Profil Donatur ──────────────────── --}}
            <div class="dn-section wow fadeInUp" data-wow-delay="0.15s">
                <h3 class="dn-section-title">
                    <i class="fas fa-user-circle"></i> Profil Donatur
                </h3>

                <div class="row g-3">
                    {{-- Nama --}}
                    <div class="col-12 dn-field mb-0">
                        <label class="dn-label" for="dn-nama-donatur">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text"
                               class="dn-input"
                               id="dn-nama-donatur"
                               name="nama_donatur"
                               placeholder="Nama Donatur"
                               required
                               autocomplete="name">
                        <div class="dn-invalid-msg">Nama wajib diisi</div>
                    </div>

                    {{-- Email --}}
                    <div class="col-12 col-sm-6 dn-field mb-0">
                        <label class="dn-label" for="dn-email">Email <span class="text-danger">*</span></label>
                        <input type="email"
                               class="dn-input"
                               id="dn-email"
                               name="email_donatur"
                               placeholder="email@contoh.com"
                               required
                               autocomplete="email">
                        <div class="dn-invalid-msg">Email valid wajib diisi</div>
                    </div>

                    {{-- No. Telepon --}}
                    <div class="col-12 col-sm-6 dn-field mb-0">
                        <label class="dn-label" for="dn-telpon">No. Telepon <span class="text-danger">*</span></label>
                        <input type="text"
                               class="dn-input dn-num-only"
                               id="dn-telpon"
                               name="no_telp_donatur"
                               placeholder="08xxxxxxxxxx"
                               required
                               maxlength="15"
                               autocomplete="tel"
                               inputmode="numeric">
                        <div class="dn-invalid-msg">No. telepon wajib diisi</div>
                    </div>

                    {{-- Usia --}}
                    <div class="col-12 col-sm-4 dn-field mb-0">
                        <label class="dn-label" for="dn-usia">Usia <span class="text-danger">*</span></label>
                        <input type="text"
                               class="dn-input dn-num-only"
                               id="dn-usia"
                               name="usia_donatur"
                               placeholder="Contoh: 21"
                               required
                               maxlength="2"
                               inputmode="numeric">
                        <div class="dn-invalid-msg">Usia wajib diisi</div>
                    </div>

                    {{-- Domisili --}}
                    <div class="col-12 col-sm-4 dn-field mb-0">
                        <label class="dn-label" for="dn-domisili">Domisili <span class="text-danger">*</span></label>
                        <div class="dn-select-wrap">
                            <select class="dn-select"
                                    id="dn-domisili"
                                    name="domisili_donatur"
                                    required>
                                <option value="">Pilih Kota</option>
                                @foreach($cities as $id => $name)
                                    <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dn-invalid-msg">Domisili wajib dipilih</div>
                    </div>

                    {{-- Pekerjaan --}}
                    <div class="col-12 col-sm-4 dn-field mb-0">
                        <label class="dn-label" for="dn-pekerjaan">Pekerjaan <span class="text-danger">*</span></label>
                        <div class="dn-select-wrap">
                            <select class="dn-select"
                                    id="dn-pekerjaan"
                                    name="pekerjaan_donatur"
                                    required>
                                <option value="">Pilih Pekerjaan</option>
                                @foreach($jobs as $id => $name)
                                    <option value="{{ $name }}">{{ $name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="dn-invalid-msg">Pekerjaan wajib dipilih</div>
                    </div>
                </div>

                {{-- Anonymous toggle --}}
                <label class="dn-anon-row" for="dn-anon-check">
                    <input type="checkbox" class="dn-anon-check" id="dn-anon-check">
                    <span class="dn-anon-label">Tampilkan sebagai donatur anonim</span>
                </label>
            </div>

            {{-- ── Section 3: Pesan / Do'a ────────────────────── --}}
            <div class="dn-section wow fadeInUp" data-wow-delay="0.17s">
                <h3 class="dn-section-title">
                    <i class="fas fa-comment-dots"></i> Dukungan atau Do'amu
                    <span class="ms-auto fw-normal text-muted" style="font-size:.75rem;">Opsional</span>
                </h3>
                <textarea class="dn-textarea"
                          id="dn-pesan"
                          name="pesan_donatur"
                          placeholder="Tuliskan pesan atau doa baikmu di sini…"
                          rows="4"></textarea>
            </div>

            {{-- ── reCAPTCHA ──────────────────────────────────── --}}
            <div class="wow fadeInUp" data-wow-delay="0.18s">
                {!! htmlFormSnippet() !!}
            </div>

            {{-- ── Total + Submit ─────────────────────────────── --}}
            <div class="wow fadeInUp" data-wow-delay="0.2s" style="margin-top: 1.25rem;">
                <div class="dn-total-row">
                    <span class="dn-total-label"><i class="fas fa-receipt me-1"></i> Total Donasi</span>
                    <span class="dn-total-value" id="dn-total-value">Rp0</span>
                </div>
                <button type="submit" class="dn-submit-btn">
                    <i class="fas fa-lock"></i> Lanjutkan Pembayaran
                </button>
            </div>

        </form>

    </div>
</section>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.service.celengan-syahid.components._donate-now._donate-now-scripts')
@endsection
