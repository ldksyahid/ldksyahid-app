@extends('landing-page.template.body')

@section('styles')
@include('landing-page.service.persuratan.components._index-styles')
@endsection

@section('content')

<section class="prs-section">
    <div class="container">
        <div class="prs-layout">

            {{-- ===== LEFT: DECORATIVE / INFO COLUMN ===== --}}
            <div class="prs-col-info wow fadeInLeft" data-wow-delay="0.1s">

                <p class="prs-deco-label">
                    <i class="fas fa-feather-alt"></i> Layanan Resmi Kestari
                </p>
                <h1 class="prs-deco-title">Layanan Persuratan</h1>
                <div class="prs-deco-bar"></div>

                {{-- Quote Box --}}
                <div class="prs-deco-quote">
                    <p class="prs-quran-arabic">يَا أَيُّهَا الَّذِينَ آمَنُوا إِذَا تَدَايَنتُم بِدَيْنٍ إِلَىٰ أَجَلٍ مُّسَمًّى فَاكْتُبُوهُ</p>
                    <p>"Wahai orang-orang yang beriman! Apabila kamu melakukan muamalah tidak secara tunai untuk waktu yang ditentukan, hendaklah kamu menuliskannya..."</p>
                    <span>● QS. Al-Baqarah 2: 282</span>
                </div>

                {{-- Cara Pengajuan --}}
                <div class="prs-how-card">
                    <p class="prs-how-title">
                        <i class="fas fa-info-circle"></i> Alur &amp; Cara Pengajuan
                    </p>
                    <ul class="prs-how-list">
                        <li><span class="prs-how-bullet"></span>Pilih jenis surat yang sesuai dengan kebutuhan</li>
                        <li><span class="prs-how-bullet"></span>Isi formulir data kegiatan secara lengkap dan benar</li>
                        <li><span class="prs-how-bullet"></span>Kirim pengajuan untuk diverifikasi oleh admin Kestari</li>
                        <li><span class="prs-how-bullet"></span>Admin menerbitkan nomor surat resmi &amp; tanda tangan</li>
                        <li><span class="prs-how-bullet"></span>Unduh dokumen PDF ber-QR Code di menu Riwayat Surat</li>
                    </ul>
                </div>

                {{-- Ketentuan & SLA --}}
                <div class="prs-method-card">
                    <p class="prs-method-title">
                        <i class="fas fa-clock"></i> Standar Layanan (SLA)
                    </p>
                    <p class="prs-method-body">
                        Waktu proses penerbitan surat maksimal <strong>1x24 jam kerja</strong> sejak pengajuan dikirim.
                        Setiap dokumen dilengkapi dengan <strong>QR Code verifikasi digital</strong> untuk menjamin keaslian dan validitas surat resmi LDK Syahid.
                    </p>
                </div>

                {{-- Narahubung Kestari --}}
                <div class="prs-contact-card">
                    <p class="prs-contact-title">
                        <i class="fab fa-whatsapp"></i> Narahubung Kestari
                    </p>
                    <div class="prs-contact-grid">
                        <a href="https://wa.me/{{ $waSekjen }}" target="_blank" rel="noopener" class="prs-contact-item">
                            <div class="prs-contact-avatar">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="prs-contact-info">
                                <p class="prs-contact-name">{{ $namaSekjen }}</p>
                                <p class="prs-contact-role">Sekretaris Jenderal LDK Syahid</p>
                            </div>
                            <i class="fas fa-chevron-right prs-contact-arrow"></i>
                        </a>
                        <a href="https://wa.me/{{ $waKestari }}" target="_blank" rel="noopener" class="prs-contact-item">
                            <div class="prs-contact-avatar">
                                <i class="fab fa-whatsapp"></i>
                            </div>
                            <div class="prs-contact-info">
                                <p class="prs-contact-name">{{ $namaKestari }}</p>
                                <p class="prs-contact-role">Sub Koor Administrasi Kestari</p>
                            </div>
                            <i class="fas fa-chevron-right prs-contact-arrow"></i>
                        </a>
                    </div>
                </div>

                {{-- FAQ Accordion --}}
                <div class="prs-faq-card">
                    <p class="prs-faq-title">
                        <i class="fas fa-question-circle"></i> Pertanyaan Umum (FAQ)
                    </p>
                    <div class="prs-faq-list" id="prsFaqList">
                        <div class="prs-faq-item">
                            <button type="button" class="prs-faq-question">
                                <span>Berapa lama proses verifikasi surat?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="prs-faq-answer">
                                <div class="prs-faq-answer-inner">
                                    Maksimal 1x24 jam pada hari kerja sejak pengajuan dikirim. Anda dapat memantau status secara langsung di menu Riwayat Surat.
                                </div>
                            </div>
                        </div>
                        <div class="prs-faq-item">
                            <button type="button" class="prs-faq-question">
                                <span>Bagaimana cara memverifikasi keaslian surat?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="prs-faq-answer">
                                <div class="prs-faq-answer-inner">
                                    Setiap dokumen resmi memiliki kode QR di bagian footer surat dan tanda tangan Ketua Umum. Pindai kode QR menggunakan kamera ponsel untuk membuka halaman verifikasi sistem resmi LDK Syahid.
                                </div>
                            </div>
                        </div>
                        <div class="prs-faq-item">
                            <button type="button" class="prs-faq-question">
                                <span>Apakah bisa mengajukan surat di hari libur?</span>
                                <i class="fas fa-chevron-down"></i>
                            </button>
                            <div class="prs-faq-answer">
                                <div class="prs-faq-answer-inner">
                                    Pengajuan surat dapat dikirim kapan saja 24/7 melalui sistem. Verifikasi oleh admin akan diproses pada jam operasional hari kerja berikutnya atau dapat menghubungi narahubung jika bersifat mendesak.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>{{-- /prs-col-info --}}


            {{-- ===== RIGHT: FORM & RECENT HISTORY COLUMN ===== --}}
            <div class="prs-col-form wow fadeInRight" data-wow-delay="0.2s">

                {{-- ── Main Form Card ── --}}
                <div class="prs-form-card">

                    <div class="prs-form-header">
                        <div class="prs-form-icon-wrap">
                            <i class="fas fa-file-signature"></i>
                        </div>
                        <div>
                            <h2 class="prs-form-header-title">Form Pengajuan Surat</h2>
                            <p class="prs-form-header-sub">Silakan lengkapi data permohonan surat di bawah ini</p>
                        </div>
                    </div>

                    {{-- Session Alerts --}}
                    @if (session('success'))
                        <div class="prs-alert prs-alert-success">
                            <i class="fas fa-check-circle"></i>
                            <div><strong>Berhasil!</strong> {{ session('success') }}</div>
                        </div>
                    @endif

                    @if (isset($errors) && $errors->any())
                        <div class="prs-alert prs-alert-danger">
                            <i class="fas fa-exclamation-circle"></i>
                            <div>
                                <strong>Mohon periksa kembali formulir:</strong>
                                <ul class="mb-0 ps-3 mt-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('service.persuratan.submit') }}" method="POST" id="form-persuratan">
                        @csrf

                        {{-- Jenis Surat Selector --}}
                        <div class="prs-form-group">
                            <label class="prs-form-label" for="jenis_surat">
                                <i class="fas fa-list-ul"></i> Jenis Surat Resmi
                            </label>
                            <div class="prs-input-group">
                                <i class="fas fa-file-alt prs-input-prefix-icon"></i>
                                <select name="jenis_surat" id="jenis_surat"
                                    class="prs-form-select @error('jenis_surat') is-invalid @enderror">
                                    <option value="" disabled selected>-- Pilih jenis surat yang dibutuhkan --</option>
                                    @foreach ($suratTypes as $key => $surat)
                                        <option value="{{ $key }}" {{ old('jenis_surat') === $key ? 'selected' : '' }}>
                                            {{ $surat['label'] }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('jenis_surat')
                                <div class="prs-error-text">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Dynamic Description Box --}}
                        <div class="prs-desc-box" id="prsDescBox" style="display:none;"></div>

                        {{-- Dynamic Fields Container --}}
                        <div id="dynamic-fields"></div>

                        {{-- Submit Button --}}
                        <div class="mt-4" id="btn-submit-wrapper" style="display:none!important">
                            <button type="submit" class="prs-btn-submit" id="btn-submit">
                                <i class="fas fa-paper-plane"></i>
                                <span>Kirim Pengajuan Surat</span>
                            </button>
                        </div>
                    </form>

                </div>{{-- /prs-form-card --}}


                {{-- ── Recent History Card (Authenticated Only) ── --}}
                @auth
                <div class="prs-history-card">
                    <div class="prs-history-head">
                        <div class="prs-history-icon-wrap">
                            <i class="fas fa-history"></i>
                        </div>
                        <div>
                            <h3 class="prs-history-head-title">Riwayat Pengajuan</h3>
                            <p class="prs-history-head-sub">5 pengajuan surat terbaru Anda</p>
                        </div>
                        <a href="{{ route('service.persuratan.riwayat') }}" class="prs-link-all">
                            <span>Lihat Semua</span>
                            <i class="fas fa-arrow-right"></i>
                        </a>
                    </div>

                    @if ($riwayat->isEmpty())
                        <div class="prs-empty-box">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada riwayat pengajuan surat.</p>
                        </div>
                    @else
                        <div class="prs-history-list">
                            @foreach ($riwayat as $log)
                                <div class="prs-history-item">
                                    <div class="prs-history-status-dot {{ $log->status }}"></div>
                                    <div class="prs-history-content">
                                        <div class="prs-history-title">{{ $log->label }}</div>
                                        <div class="prs-history-meta">
                                            {{ $log->created_at->locale('id')->translatedFormat('d M Y, H:i') }} WIB
                                            @if ($log->nomor_surat !== '-')
                                                &bull; <strong>{{ $log->nomor_surat }}</strong>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="prs-history-action">
                                        <span class="prs-badge prs-badge-{{ $log->statusBadgeClass() }}">
                                            {{ $log->statusLabel() }}
                                        </span>
                                        @if ($log->isApproved())
                                            <a href="{{ route('service.persuratan.download', $log) }}"
                                               class="prs-btn-download" title="Unduh Dokumen PDF">
                                                <i class="fas fa-download"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                @endauth

            </div>{{-- /prs-col-form --}}

        </div>{{-- /prs-layout --}}
    </div>
</section>

@endsection

@section('scripts')
@include('landing-page.service.persuratan.components._index-scripts')
@endsection