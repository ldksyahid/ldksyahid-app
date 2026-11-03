<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title id="html-title">{{ $judulWebsite }}</title>
  <link rel="icon" href="{{ $logoWebsite }}">

  {{-- Open Graph Meta Tags --}}
  <meta property="og:title" content="{{ $judulWebsite }}">
  <meta property="og:description" content="Portal FORDATA LDK Syahid UIN Syarif Hidayatullah Jakarta">
  <meta property="og:image" content="{{ $gambarHeaderPusat }}">
  <meta property="og:url" content="{{ $linkFordata }}">
  <meta property="og:type" content="website">

  {{-- Fonts & Icons --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Montserrat:wght@500;600;700&display=swap">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  {{-- Styles Component --}}
  @include('landing-page.fordata.components._index-styles')
</head>

<body>
  <div class="portal-wrapper">
    <div class="portal-container">
      {{-- Banner Header --}}
      <div class="banner-container">
        <img id="headerimg"
             src="{{ $gambarHeaderPusat }}"
             alt="Header Banner FORDATA"
             class="header-banner">
      </div>

      {{-- Card Utama --}}
      <div class="portal-card">
        <div class="badge-period">
          <i class="fa-solid fa-sparkles"></i> Periode {{ $sekarangFordata }}
        </div>

        <h1 id="judul-portal" class="portal-title">{{ $judulWebsite }}</h1>
        <p class="portal-subtitle">Silahkan masukkan NIM dan Tanggal Lahir untuk memverifikasi data dan mengisi FORDATA</p>

        {{-- Loading Indicator --}}
        <div id="loading" style="display: none;">
          <div class="spinner-modern"></div>
          <p style="font-weight: 600; color: #4b5563; font-size: 0.9rem;">Menghubungkan ke database...</p>
          <small style="color: #9ca3af;">Mohon tunggu sebentar yaa</small>
        </div>

        {{-- Form Login Awal --}}
        <div id="awalan">
          <div id="alert-awalan" class="result-box warning" style="display: none;">
            <i class="fa-solid fa-circle-exclamation me-1"></i>
            <span id="kata2"></span>
          </div>

          <form id="myform" onsubmit="return false;">
            {{-- Field NIM --}}
            <div class="form-group">
              <label class="form-label" for="nim">
                <i class="fa-solid fa-id-card"></i> Nomor Induk Mahasiswa (NIM)
              </label>
              <div class="nim-group">
                <div class="input-wrapper">
                  <input id="nim" name="nim" class="form-control-modern" type="number"
                         placeholder="Contoh: 11210820000001" required autocomplete="username" />
                  <i class="fa-solid fa-graduation-cap input-icon-left"></i>
                </div>
                <button type="button" id="cek" class="btn-cek">
                  <i class="fa-solid fa-magnifying-glass"></i> Cek
                </button>
              </div>

              {{-- Quick feedback inline bila NIM valid --}}
              <div id="nim-badge" class="nim-quick-badge">
                <i class="fa-solid fa-circle-check" style="color: #10b981; margin-right: 4px;"></i>
                <span id="nim-badge-text"></span>
              </div>
            </div>

            {{-- Field Tanggal Lahir --}}
            <div class="form-group">
              <label class="form-label" for="ultah">
                <i class="fa-solid fa-calendar-days"></i> Tanggal Lahir
              </label>
              <div class="input-wrapper">
                <input id="ultah" name="ultah" class="form-control-modern" type="date"
                       min="1990-01-01" max="2026-12-31" required />
                <i class="fa-solid fa-cake-candles input-icon-left"></i>
              </div>
              <small class="form-hint">Sesuai tanggal lahir saat pendaftaran Ekspresi / FORDATA sebelumnya</small>
            </div>

            {{-- Tombol Masuk --}}
            <button id="login" type="submit" class="btn-primary-action">
              <span>Masuk & Lanjutkan</span>
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </form>
        </div>

        {{-- State: Siap Mengisi (Bismillah) --}}
        <div id="bismillah" style="display: none; animation: fadeIn 0.4s ease;">
          <div class="result-box success">
            <i class="fa-solid fa-circle-check" style="font-size: 1.25rem; display: block; margin-bottom: 6px;"></i>
            <b id="dari-awal-ga" style="font-size: 0.95rem;"></b>
          </div>

          <div style="margin: 22px 0 16px;">
            <a href="javascript:void(0)" id="gform" class="btn-primary-action btn-success-action">
              <i class="fa-solid fa-pen-to-square"></i>
              <span>Isi FORDATA Sekarang</span>
            </a>
          </div>

          <div id="sebar_p" style="margin-top: 18px; padding-top: 16px; border-top: 1px dashed #e5e7eb;">
            <p style="font-size: 0.82rem; color: #6b7280; margin-bottom: 10px;">
              Tolong ingatkan teman-teman seperjuanganmu untuk mengisi ini juga yaa, syukron 🙏
            </p>
            <a id="sebar"
               href="https://api.whatsapp.com/send?text={{ rawurlencode($teksShareFordata) }}"
               target="_blank"
               rel="noopener noreferrer"
               class="btn-primary-action btn-wa-share" style="height: 42px; font-size: 0.85rem;">
              <i class="fa-brands fa-whatsapp" style="font-size: 1.1rem;"></i>
              <span>Ingatkan Temanmu via WhatsApp</span>
            </a>
          </div>
        </div>

        {{-- State: Sudah Submit (Closed) --}}
        <div id="closed" style="display: none; animation: fadeIn 0.4s ease;">
          <div class="result-box info">
            <i class="fa-solid fa-clipboard-check" style="font-size: 1.5rem; display: block; margin-bottom: 8px;"></i>
            <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 4px;">Alhamdulillah!</h3>
            <p style="font-size: 0.88rem;">Kamu sudah submit FORDATA {{ $sekarangFordata }} sebelumnya. Jazakumullah khair yaa.</p>
          </div>

          <p style="font-size: 0.85rem; color: #6b7280; margin: 18px 0 12px;">
            Jangan lupa tetap terhubung dan follow media sosial <strong id="nama-lembaga-closed">LDK Syahid</strong> yaa!
          </p>

          <a id="linktree-btn" href="https://linktr.ee/ldksyahidjkt" target="_blank" rel="noopener noreferrer"
             class="btn-primary-action">
            <i class="fa-solid fa-arrow-up-right-from-square"></i>
            <span>Buka Media Sosial Kami</span>
          </a>
        </div>
      </div>

      {{-- Footer --}}
      <div class="portal-footer">
        <div>
          <i class="fa-solid fa-heart" style="color: #f59e0b; margin-right: 4px;"></i>
          Dibuat dengan mengharap Ridho Allah
        </div>
        <div id="kel" style="display: none;">
          <button id="keluar" type="button" class="btn-logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            <span>Ganti Akun / Keluar</span>
          </button>
        </div>
      </div>
    </div>
  </div>

  {{-- Modal Popup Info Cek NIM --}}
  <div id="myModal" class="modal-backdrop">
    <div class="modal-card">
      <button type="button" class="modal-close-btn" id="modal-close">
        <i class="fa-solid fa-xmark"></i>
      </button>

      <div class="modal-icon-header">
        <i class="fa-solid fa-id-card-clip"></i>
      </div>

      <h3 style="font-size: 1.15rem; font-weight: 800; color: #111827; margin-bottom: 6px;">Informasi Mahasiswa</h3>
      <div id="nnnim" style="font-size: 0.92rem; color: #4b5563; line-height: 1.6; margin: 14px 0 20px;"></div>

      <button type="button" id="modal-ok-btn" class="btn-primary-action" style="height: 44px; font-size: 0.9rem;">
        <span>Lanjutkan</span>
      </button>
    </div>
  </div>

  {{-- Scripts Component --}}
  @include('landing-page.fordata.components._index-scripts')
</body>

</html>
