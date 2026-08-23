@extends('landing-page.template.body')
{{-- Path: resources/views/landing-page/service/persuratan/index.blade.php --}}

@section('styles')
@include('landing-page.service.persuratan.components._index-styles')
@endsection

@section('content')

<section class="prs-page-section" id="prs-main-section">
    <div class="container">

        {{-- ── Section Header ──────────────────────────────────── --}}
        <div class="text-center mb-4 wow fadeInUp" data-wow-delay="0.08s">
            <div class="prs-section-badge">
                <span>📜</span>
                <span>Layanan</span>
                <span class="prs-badge-pulse"></span>
            </div>
            <h1 class="prs-section-title mt-3">Layanan Pengajuan Surat</h1>
            <p class="prs-section-sub">
                Layanan pengajuan dan penerbitan surat resmi LDK Syahid UIN Syarif Hidayatullah Jakarta secara mandiri, terstandarisasi, dan terverifikasi digital.
            </p>
        </div>

        {{-- ── Two-column Layout ───────────────────────────────── --}}
        <div class="prs-content-wrap">

            {{-- ── Left Info Column ─────────────────────────────── --}}
            <div class="prs-info-col wow fadeInLeft" data-wow-delay="0.12s">

                {{-- Cara Pengajuan Card --}}
                <div class="prs-info-card">
                    <p class="prs-info-title">
                        <i class="fas fa-list-ol"></i>
                        Alur Pengajuan
                    </p>
                    <ul class="prs-info-list">
                        <li>Pilih template dari <strong>18 jenis surat resmi</strong> yang tersedia</li>
                        <li>Lengkapi data kegiatan pada formulir otomatis</li>
                        <li>Notifikasi dikirim langsung ke <strong>Kestari (Pusat)</strong> atau <strong>Sekjen (LDKSF)</strong></li>
                        <li>Admin memeriksa draft dokumen sebelum memberikan persetujuan</li>
                        <li>Unduh PDF resmi ber-QR Code setelah surat disetujui</li>
                    </ul>
                </div>

                {{-- Ketentuan Card --}}
                <div class="prs-info-card">
                    <p class="prs-info-title">
                        <i class="fas fa-exclamation-circle"></i>
                        Ketentuan &amp; Masa Berlaku
                    </p>
                    <ul class="prs-info-list">
                        <li>Khusus Pengurus Pusat &amp; LDK Syahid Fakultas (LDKSF)</li>
                        <li>Nomor WhatsApp pemohon harus aktif untuk menerima notifikasi</li>
                        <li>Pengajuan belum diproses dalam <strong>7 hari</strong> akan otomatis kadaluarsa</li>
                        <li>Surat kadaluarsa dapat diajukan ulang hanya dengan 1-klik</li>
                    </ul>
                </div>

                {{-- Contact Card --}}
                <div class="prs-contact-card">
                    <p class="prs-contact-title">Konfirmasi &amp; Konsultasi</p>

                    {{-- Kestari (Pusat) --}}
                    <div class="prs-contact-person">
                        <div class="prs-contact-avatar kestari">
                            <i class="fas fa-user-tie"></i>
                        </div>
                        <div>
                            <p class="prs-contact-role">Biro Kesekretariatan (Pusat)</p>
                            <p class="prs-contact-name">{{ $namaKestari ?: 'Kestari LDK Syahid' }}</p>
                            <p class="prs-contact-num">{{ $waKestari }}</p>
                        </div>
                    </div>
                    <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $waKestari) }}&text=Assalamu%27alaikum%20Kestari%20LDK%20Syahid,%20saya%20ingin%20konsultasi%20mengenai%20pengajuan%20surat."
                       target="_blank" rel="noopener" class="prs-contact-wa-btn mb-3">
                        <i class="fab fa-whatsapp"></i>
                        <span>Hubungi Kestari (Pusat)</span>
                    </a>

                    <hr class="prs-contact-divider">

                    {{-- Sekjen (LDKSF) --}}
                    <div class="prs-contact-person">
                        <div class="prs-contact-avatar sekjen">
                            <i class="fas fa-award"></i>
                        </div>
                        <div>
                            <p class="prs-contact-role">Sekretaris Jenderal (LDKSF)</p>
                            <p class="prs-contact-name">{{ $namaSekjen ?: 'Sekjen LDK Syahid' }}</p>
                            <p class="prs-contact-num">{{ $waSekjen }}</p>
                        </div>
                    </div>
                    <a href="https://api.whatsapp.com/send?phone={{ preg_replace('/[^0-9]/', '', $waSekjen) }}&text=Assalamu%27alaikum%20Sekjen%20LDK%20Syahid,%20saya%20ingin%20konsultasi%20mengenai%20pengajuan%20surat%20LDKSF."
                       target="_blank" rel="noopener" class="prs-contact-wa-btn prs-sekjen-btn">
                        <i class="fab fa-whatsapp"></i>
                        <span>Hubungi Sekjen (LDKSF)</span>
                    </a>
                </div>

                {{-- Side Nav Links Card --}}
                <div class="prs-side-nav-card">
                    <a href="{{ route('service.persuratan.riwayat') }}" class="prs-side-nav-link">
                        <div class="prs-side-nav-icon history">
                            <i class="fas fa-history"></i>
                        </div>
                        <div>
                            <div class="prs-side-nav-title">Riwayat Pengajuan</div>
                            <div class="prs-side-nav-sub">Cek status &amp; unduh surat</div>
                        </div>
                        <i class="fas fa-chevron-right ms-auto prs-side-nav-arrow"></i>
                    </a>

                    <a href="{{ route('persuratan.verifikasi') }}" class="prs-side-nav-link">
                        <div class="prs-side-nav-icon verify">
                            <i class="fas fa-qrcode"></i>
                        </div>
                        <div>
                            <div class="prs-side-nav-title">Verifikasi Dokumen</div>
                            <div class="prs-side-nav-sub">Cek keaslian surat resmi</div>
                        </div>
                        <i class="fas fa-chevron-right ms-auto prs-side-nav-arrow"></i>
                    </a>
                </div>

            </div>{{-- /prs-info-col --}}


            {{-- ── Right Form Column ────────────────────────────── --}}
            <div class="prs-form-col wow fadeInRight" data-wow-delay="0.15s">

                {{-- Re-Apply Alert --}}
                @if ($reapplyLog)
                    <div class="prs-reapply-box mb-3">
                        <div class="prs-reapply-icon">
                            <i class="fas fa-redo-alt"></i>
                        </div>
                        <div class="prs-reapply-content">
                            <div class="prs-reapply-title">Mode Ajukan Ulang Aktif</div>
                            <div class="prs-reapply-text">
                                Formulir telah diisi otomatis dari pengajuan sebelumnya (<strong>{{ $reapplyLog->label }}</strong> &bull; <code>{{ $reapplyLog->kode_verifikasi }}</code>).
                                Silakan sesuaikan data tanggal atau keperluan sebelum mengirimkan ulang.
                            </div>
                        </div>
                    </div>
                @endif

                {{-- Flash Messages --}}
                @if (session('success'))
                    <div class="prs-alert-success mb-3">
                        <i class="fas fa-check-circle fs-5 flex-shrink-0"></i>
                        <div>
                            <strong>Pengajuan Berhasil Dikirim!</strong>
                            <div>{{ session('success') }}</div>
                        </div>
                    </div>
                @endif

                @if ($errors->any())
                    <div class="prs-alert-danger mb-3">
                        <i class="fas fa-exclamation-circle fs-5 flex-shrink-0"></i>
                        <div>
                            <strong>Terdapat kesalahan pada isian formulir:</strong>
                            <ul class="mb-0 mt-1 ps-3">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                {{-- Step Process Flow --}}
                <div class="prs-steps-wrapper mb-3">
                    <div class="prs-step-item">
                        <div class="prs-step-num">1</div>
                        <div>
                            <div class="prs-step-label">Pilih Surat</div>
                            <div class="prs-step-sub">18 Template Resmi</div>
                        </div>
                    </div>
                    <div class="prs-step-item">
                        <div class="prs-step-num">2</div>
                        <div>
                            <div class="prs-step-label">Isi Formulir</div>
                            <div class="prs-step-sub">Data Kegiatan</div>
                        </div>
                    </div>
                    <div class="prs-step-item">
                        <div class="prs-step-num">3</div>
                        <div>
                            <div class="prs-step-label">Verifikasi</div>
                            <div class="prs-step-sub">Pusat / LDKSF</div>
                        </div>
                    </div>
                    <div class="prs-step-item">
                        <div class="prs-step-num">4</div>
                        <div>
                            <div class="prs-step-label">Unduh PDF</div>
                            <div class="prs-step-sub">TTE &amp; QR Code</div>
                        </div>
                    </div>
                </div>

                {{-- Main Form Card --}}
                <div class="prs-form-card">
                    <form action="{{ route('service.persuratan.submit') }}" method="POST" id="form-persuratan">
                        @csrf

                        <div class="prs-form-card-header">
                            <div class="prs-form-card-icon">
                                <i class="fas fa-file-signature"></i>
                            </div>
                            <div>
                                <h2 class="prs-form-card-title">Formulir Permohonan Surat</h2>
                                <p class="prs-form-card-subtitle">Pilih jenis surat, lengkapi data kegiatan, lalu kirim pengajuan.</p>
                            </div>
                        </div>

                        <div class="prs-form-card-body">

                            {{-- Trigger Card for Letter Selection --}}
                            @php
                                $selectedKey = old('jenis_surat', $reapplyLog?->jenis_surat);
                                $selectedSurat = $selectedKey && isset($suratTypes[$selectedKey]) ? $suratTypes[$selectedKey] : null;
                            @endphp

                            <input type="hidden" name="jenis_surat" id="jenis_surat" value="{{ $selectedKey }}" required>

                            <div class="prs-form-group">
                                <label class="prs-form-label">
                                    <i class="fas fa-folder-open"></i> Jenis Surat yang Dibutuhkan
                                </label>

                                <div class="prs-picker-card {{ $selectedSurat ? 'has-value' : '' }}" id="prsPickerTrigger" role="button" tabindex="0" data-bs-toggle="modal" data-bs-target="#modalChooseLetter">
                                    <div class="prs-picker-icon-wrap" id="prsPickerIcon">
                                        <i class="fas {{ $selectedSurat['icon'] ?? 'fa-file-alt' }}"></i>
                                    </div>
                                    <div class="prs-picker-content">
                                        <div class="prs-picker-title" id="prsPickerTitle">
                                            {{ $selectedSurat['label'] ?? 'Pilih Jenis Surat Resmi...' }}
                                        </div>
                                        <div class="prs-picker-desc" id="prsPickerDesc">
                                            {{ $selectedSurat['description'] ?? 'Klik di sini untuk membuka katalog 18 jenis surat resmi LDK Syahid' }}
                                        </div>
                                    </div>
                                    <div class="prs-picker-action">
                                        <span class="prs-picker-btn">
                                            <span>{{ $selectedSurat ? 'Ganti Surat' : 'Pilih Surat' }}</span>
                                            <i class="fas fa-th-large ms-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            {{-- Dynamic Form Fields Container --}}
                            <div id="dynamic-fields">
                                {{-- Rendered dynamically via JavaScript --}}
                            </div>

                            {{-- Submit Button --}}
                            <div id="btn-submit-wrapper" style="display: none;">
                                <button type="submit" class="prs-btn-submit" id="btn-submit">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    <span>Kirim Pengajuan Surat</span>
                                </button>
                                <p class="prs-submit-hint">
                                    <i class="fas fa-shield-alt me-1 text-primary"></i> Data Anda akan diverifikasi oleh Kesekretariatan LDK Syahid sebelum surat resmi diterbitkan.
                                </p>
                            </div>

                        </div>
                    </form>
                </div>{{-- /prs-form-card --}}

                {{-- FAQ Accordion Card --}}
                <div class="prs-faq-card mt-4">
                    <div class="prs-faq-card-header">
                        <div class="prs-faq-header-icon">
                            <i class="fas fa-question-circle"></i>
                        </div>
                        <div>
                            <h3 class="prs-faq-card-title">Pertanyaan yang Sering Diajukan (FAQ)</h3>
                            <p class="prs-faq-card-subtitle">Panduan cepat seputar pengajuan dan penerbitan surat resmi organisasi.</p>
                        </div>
                    </div>
                    <div class="prs-faq-card-body">
                        <div class="prs-faq-item">
                            <button type="button" class="prs-faq-question">
                                <span>Berapa lama proses verifikasi dan penerbitan nomor surat?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="prs-faq-answer">
                                <div class="prs-faq-answer-inner">
                                    Proses verifikasi oleh Biro Kesekretariatan (Pusat) atau Sekjen (LDKSF) biasanya memakan waktu <strong>1x24 jam</strong> pada hari kerja. Pastikan data yang dimasukkan sudah benar dan lengkap.
                                </div>
                            </div>
                        </div>

                        <div class="prs-faq-item">
                            <button type="button" class="prs-faq-question">
                                <span>Bagaimana alur verifikasi antara Pengurus Pusat dan LDKSF?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="prs-faq-answer">
                                <div class="prs-faq-answer-inner">
                                    Sistem secara otomatis mengarahkan permohonan dari <strong>Pengurus Pusat ke Kestari</strong>, sedangkan permohonan dari <strong>LDK Syahid Fakultas ke Sekjen</strong> melalui integrasi WhatsApp interaktif.
                                </div>
                            </div>
                        </div>

                        <div class="prs-faq-item">
                            <button type="button" class="prs-faq-question">
                                <span>Bagaimana jika surat tidak kunjung diverifikasi dalam 7 hari?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="prs-faq-answer">
                                <div class="prs-faq-answer-inner">
                                    Sistem akan otomatis menandai surat sebagai <strong>Kadaluarsa</strong>. Anda dapat mengklik tombol <strong>Ajukan Ulang</strong> di menu Riwayat Surat tanpa harus mengetik ulang seluruh data dari awal.
                                </div>
                            </div>
                        </div>

                        <div class="prs-faq-item">
                            <button type="button" class="prs-faq-question">
                                <span>Apakah surat yang diunduh sudah memiliki keabsahan resmi?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="prs-faq-answer">
                                <div class="prs-faq-answer-inner">
                                    Ya. Setiap dokumen PDF yang diterbitkan dilengkapi dengan <strong>Nomor Surat Resmi</strong>, <strong>Tanda Tangan Digital Sekretaris Jenderal</strong>, dan <strong>QR Code Verifikasi</strong> yang terdaftar secara sah di sistem LDK Syahid UIN Jakarta.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>{{-- /prs-faq-card --}}

            </div>{{-- /prs-form-col --}}

        </div>{{-- /prs-content-wrap --}}

    </div>{{-- /container --}}
</section>

{{-- Modals --}}
@include('landing-page.service.persuratan.components._modal-choose-letter')
@include('landing-page.service.persuratan.components._modal-choose-dept')

@endsection

@section('scripts')
@include('landing-page.service.persuratan.components._index-scripts')
@endsection