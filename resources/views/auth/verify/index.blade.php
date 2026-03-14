@extends('landing-page.template.body')

@section('content')

<div class="ve-wrap">
    {{-- Background blobs --}}
    <div class="ve-blob ve-blob-1"></div>
    <div class="ve-blob ve-blob-2"></div>
    <div class="ve-blob ve-blob-3"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="ve-card wow fadeInUp" data-wow-delay="0.1s">

                    {{-- Badge --}}
                    <div class="ve-badge">
                        <span>✉️</span>
                        <span>Verifikasi Email</span>
                        <span class="ve-badge-pulse"></span>
                    </div>

                    {{-- Animated icon --}}
                    <div class="ve-icon-wrap">
                        <div class="ve-icon-orbit">
                            <span class="ve-orbit-dot" style="--d:0s">✨</span>
                            <span class="ve-orbit-dot" style="--d:1.2s">⭐</span>
                            <span class="ve-orbit-dot" style="--d:2.4s">💫</span>
                        </div>
                        <div class="ve-icon-inner">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div class="ve-icon-ring ve-ring-1"></div>
                        <div class="ve-icon-ring ve-ring-2"></div>
                    </div>

                    {{-- Headline --}}
                    <h3 class="ve-title">Satu Langkah Lagi! 🚀</h3>
                    <p class="ve-subtitle">Kami telah mengirimkan link verifikasi ke</p>

                    {{-- Email chip --}}
                    <div class="ve-email-chip">
                        <i class="fas fa-at"></i>
                        <span>{{ Auth::user()->email }}</span>
                    </div>

                    <p class="ve-hint">Buka email kamu dan klik link verifikasi untuk mengaktifkan akun.</p>

                    {{-- Steps --}}
                    <div class="ve-steps">
                        <div class="ve-step">
                            <div class="ve-step-icon">📬</div>
                            <span>Buka Email</span>
                        </div>
                        <div class="ve-step-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="ve-step">
                            <div class="ve-step-icon">🔗</div>
                            <span>Klik Link</span>
                        </div>
                        <div class="ve-step-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="ve-step">
                            <div class="ve-step-icon">🎉</div>
                            <span>Akun Aktif!</span>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="ve-divider"></div>

                    {{-- Resend --}}
                    <p class="ve-resend-label">Tidak menerima email?</p>
                    <form method="POST" action="{{ route('verification.resend') }}" class="ve-resend-form">
                        @csrf
                        <button type="submit" class="ve-resend-btn">
                            <span class="ve-btn-icon"><i class="fas fa-paper-plane"></i></span>
                            <span>Kirim Ulang Email</span>
                            <div class="ve-btn-shine"></div>
                        </button>
                    </form>

                    {{-- Success alert --}}
                    @if (session('resent'))
                    <div class="ve-success-alert">
                        <span class="ve-success-icon">🎊</span>
                        <div>
                            <strong>Terkirim!</strong> Email verifikasi baru telah dikirim. Segera periksa inbox kamu ya!
                        </div>
                    </div>
                    @endif

                    {{-- Note --}}
                    <div class="ve-note">
                        <i class="fas fa-circle-info"></i>
                        Jika belum menerima email setelah kirim ulang, coba lagi besok karena ada batas pengiriman dari server.
                    </div>

                    {{-- Floating tags --}}
                    <div class="ve-float-tag ve-ftag-1">📧 Cek Inbox</div>
                    <div class="ve-float-tag ve-ftag-2">🔒 Aman & Terenkripsi</div>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
@include('auth.verify.components._index-styles')
@endsection

@section('scripts')
@include('auth.verify.components._index-scripts')
@endsection
