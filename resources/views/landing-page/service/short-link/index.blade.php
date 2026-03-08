@extends('landing-page.template.body')


{{-- ══════════════════════════════════════════════════
     STYLES
     ══════════════════════════════════════════════════ --}}
@section('styles')
@include('landing-page.service.short-link.components._index-styles')
@endsection


{{-- ══════════════════════════════════════════════════
     CONTENT
     ══════════════════════════════════════════════════ --}}
@section('content')

<section class="sl-page-section" id="sl-main-section">
    <div class="container">

        {{-- ── Section Header ──────────────────────────────────── --}}
        <div class="text-center mb-4 wow fadeInUp" data-wow-delay="0.08s">
            <div class="sl-section-badge">
                <span>🔗</span>
                <span>Layanan</span>
                <span class="sl-badge-pulse"></span>
            </div>
            <h1 class="sl-section-title mt-3">Perpendek URL</h1>
            <p class="sl-section-sub">
                Layanan pemendek tautan khusus anggota UKM LDK Syahid UIN Jakarta.
                Buat tautan yang lebih rapi dan mudah diingat.
            </p>
        </div>


        {{-- ── Two-column Content ──────────────────────────────── --}}
        <div class="sl-content-wrap">

            {{-- ── Info Column (left) ──────────────────────────── --}}
            <div class="sl-info-col wow fadeInLeft" data-wow-delay="0.12s">

                {{-- How-to card --}}
                <div class="sl-info-card">
                    <p class="sl-info-title">
                        <i class="fas fa-list-ol"></i>
                        Cara Penggunaan
                    </p>
                    <ul class="sl-info-list">
                        <li>Isi formulir di samping dengan data yang benar dan lengkap</li>
                        <li>Masukkan link asli yang ingin dipendekkan</li>
                        <li>Tentukan custom link dengan format <code>https://ldksyah.id/kata-kunci</code></li>
                        <li>Klik <strong>Kirim Permintaan</strong> lalu tunggu konfirmasi</li>
                        <li>Hubungi kontak di bawah untuk pelayanan lebih cepat</li>
                    </ul>
                </div>

                {{-- Rules card --}}
                <div class="sl-info-card">
                    <p class="sl-info-title">
                        <i class="fas fa-exclamation-circle"></i>
                        Ketentuan
                    </p>
                    <ul class="sl-info-list">
                        <li>Hanya untuk anggota UKM LDK Syahid UIN Jakarta</li>
                        <li>Nomor WhatsApp harus diawali <code>+62</code></li>
                        <li>Custom link harus diawali <code>https://ldksyah.id/</code></li>
                        <li>Gunakan tanda pisah <code>-</code> jika satu kata lebih dari 10 huruf</li>
                        <li>Link akan diganti acak jika pilihan tidak tersedia</li>
                    </ul>
                </div>

                {{-- Contact card --}}
                <div class="sl-contact-card">
                    <p class="sl-contact-title">Konfirmasi via WhatsApp</p>
                    <div class="sl-contact-person">
                        <div class="sl-contact-avatar">
                            <i class="fas fa-user"></i>
                        </div>
                        <div>
                            <p class="sl-contact-name">Radya Kusuma</p>
                            <p class="sl-contact-num">+62 857-1769-8990</p>
                        </div>
                    </div>
                    <a href="https://api.whatsapp.com/send?phone=+6285717698990&text=*%5BFOLLOW%20UP%20LAYANAN%20PERPENDEK%20URL%5D*%0A%0A_Assalammu%27alaikum_%0A%0AIzin%20untuk%20*Memfollow%20up%20Layanan%20Perpendek%20URL*%20dan%20saya%20telah%20mengisi%20formulir%20tersebut%0A%0A_Terimakasih%20Sebelumnya_%0A_Wassalammua%27laikum_%0A%0A%23KitaAdalahSaudara%0A%23LDKSyahid%0A%23UINJakarta"
                       target="_blank" rel="noopener"
                       class="sl-contact-wa-btn">
                        <i class="fab fa-whatsapp"></i>
                        <span>Konfirmasi via WhatsApp</span>
                    </a>
                    <p class="sl-contact-note">
                        Kami akan menghubungimu melalui WhatsApp yang telah didaftarkan
                        setelah <em>Shortlink</em> berhasil dibuat.
                    </p>
                </div>

            </div>{{-- /sl-info-col --}}


            {{-- ── Form Column (right) ─────────────────────────── --}}
            <div class="sl-form-col wow fadeInRight" data-wow-delay="0.15s">
                <div class="sl-form-card">

                    <p class="sl-form-title">
                        <span class="sl-form-icon"><i class="fas fa-paper-plane"></i></span>
                        Formulir Permintaan
                    </p>

                    {{-- ── The actual form ──────────────────────── --}}
                    <form id="sl-form" novalidate>
                        @csrf
                        <div class="sl-form-rows">

                            {{-- Name --}}
                            <div class="sl-field form-floating">
                                <input type="text" class="form-control" id="sl-name"
                                       placeholder="Nama Lengkap" name="name"
                                       autocomplete="name" required />
                                <label for="sl-name">Nama Lengkap</label>
                                <span class="sl-field-error" id="sl-err-name"></span>
                            </div>

                            {{-- Email + WhatsApp --}}
                            <div class="sl-form-row-2">
                                <div class="sl-field form-floating">
                                    <input type="email" class="form-control" id="sl-email"
                                           placeholder="Alamat Email" name="email"
                                           autocomplete="email" required />
                                    <label for="sl-email">Alamat Email</label>
                                    <span class="sl-field-error" id="sl-err-email"></span>
                                </div>
                                <div class="sl-field form-floating">
                                    <input type="text" class="form-control" id="sl-whatsapp"
                                           placeholder="WhatsApp Aktif" name="whatsapp"
                                           value="+62" required />
                                    <label for="sl-whatsapp">WhatsApp Aktif</label>
                                    <span class="sl-field-hint">Awali dengan +62</span>
                                    <span class="sl-field-error" id="sl-err-whatsapp"></span>
                                </div>
                            </div>

                            {{-- Default Link --}}
                            <div class="sl-field form-floating">
                                <input type="text" class="form-control" id="sl-defaultLink"
                                       placeholder="Link Asli (Original URL)"
                                       name="defaultLink" required />
                                <label for="sl-defaultLink">Link Asli (Original URL)</label>
                                <span class="sl-field-error" id="sl-err-defaultLink"></span>
                            </div>

                            {{-- Custom Link --}}
                            <div class="sl-field form-floating">
                                <input type="text" class="form-control" id="sl-customLink"
                                       placeholder="Custom Link yang Diinginkan"
                                       name="customLink"
                                       value="https://ldksyah.id/" required />
                                <label for="sl-customLink">Custom Link yang Diinginkan</label>
                                <span class="sl-field-hint">Contoh: https://ldksyah.id/nama-program</span>
                                <span class="sl-field-error" id="sl-err-customLink"></span>
                            </div>

                            {{-- Note --}}
                            <div class="sl-field form-floating">
                                <textarea class="form-control" id="sl-note"
                                          placeholder="Catatan / Keterangan"
                                          name="note" style="height:110px" required></textarea>
                                <label for="sl-note">Catatan / Keterangan</label>
                                <span class="sl-field-error" id="sl-err-note"></span>
                            </div>

                            {{-- Submit --}}
                            <button type="submit" class="sl-submit-btn" id="sl-submit">
                                <span class="sl-spinner"></span>
                                <span class="sl-btn-text">
                                    <i class="fas fa-paper-plane me-1"></i>
                                    Kirim Permintaan
                                </span>
                            </button>

                        </div>{{-- /sl-form-rows --}}
                    </form>

                    {{-- ── Success state (shown after submission) ── --}}
                    <div class="sl-form-success" id="sl-form-success">
                        <div class="sl-success-icon">
                            <i class="fas fa-check"></i>
                        </div>
                        <h5 class="sl-success-title">Permintaan Berhasil Dikirim!</h5>
                        <p class="sl-success-sub">
                            Terima kasih! Permintaan perpendek URL kamu telah kami terima.
                            Jangan lupa konfirmasi via WhatsApp untuk pelayanan lebih cepat.
                        </p>
                        <button class="sl-send-again-btn" id="sl-send-again">
                            <i class="fas fa-redo me-1"></i> Kirim Permintaan Lagi
                        </button>
                    </div>

                </div>{{-- /sl-form-card --}}
            </div>{{-- /sl-form-col --}}

        </div>{{-- /sl-content-wrap --}}

    </div>{{-- /container --}}
</section>

@endsection


{{-- ══════════════════════════════════════════════════
     SCRIPTS
     ══════════════════════════════════════════════════ --}}
@section('scripts')
@include('landing-page.service.short-link.components._index-scripts')
@endsection
