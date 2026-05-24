@extends('landing-page.template.body')

@section('styles')
@include('landing-page.forms.components._form-styles')
@endsection

@section('content')
<div class="gf-state-page">
    <div class="container">
        <div class="gf-state-card">

            @php
                $needsLogin      = isset($needsLogin) && $needsLogin;
                $alreadySubmitted = isset($alreadySubmitted) && $alreadySubmitted;
            @endphp

            {{-- Icon --}}
            @if($needsLogin)
            <div class="gf-state-icon-wrap" style="background:rgba(99,102,241,.1);color:#6366f1;">
                <i class="fas fa-user-lock"></i>
            </div>
            @elseif($alreadySubmitted)
            <div class="gf-state-icon-wrap success">
                <i class="fas fa-check-circle"></i>
            </div>
            @else
            <div class="gf-state-icon-wrap closed">
                <i class="fas fa-lock"></i>
            </div>
            @endif

            {{-- Title --}}
            <h3 class="gf-state-title">
                @if($needsLogin)
                    Login Diperlukan
                @elseif($alreadySubmitted)
                    Anda Sudah Mengisi Formulir Ini
                @else
                    Formulir Tidak Tersedia
                @endif
            </h3>

            {{-- Body message --}}
            <p class="gf-state-body">
                @if($needsLogin)
                    Untuk mengisi formulir <strong>{{ $form->title }}</strong>,
                    Anda harus login terlebih dahulu menggunakan akun Anda.
                @elseif($alreadySubmitted)
                    Formulir <strong>{{ $form->title }}</strong> hanya dapat diisi satu kali.
                    Anda telah mengisi formulir ini sebelumnya.
                    Jazakumullahu Khairan atas partisipasi Anda.
                @elseif($form->status === 'closed')
                    Formulir <strong>{{ $form->title }}</strong> telah ditutup
                    dan tidak lagi menerima tanggapan baru.
                @elseif($form->status === 'draft')
                    Formulir ini belum dipublikasikan oleh pengelola.
                    Mohon tunggu hingga formulir dibuka secara resmi.
                @elseif($form->maxSubmission && $form->totalSubmission >= $form->maxSubmission)
                    Formulir <strong>{{ $form->title }}</strong> telah mencapai
                    batas maksimum pendaftar ({{ number_format($form->maxSubmission) }} responden).
                    Jazakumullahu Khairan atas minat dan antusias Anda.
                @elseif($form->endDate && now()->gt($form->endDate))
                    Formulir <strong>{{ $form->title }}</strong> telah melewati
                    batas waktu pengisian
                    ({{ $form->endDate->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB).
                @elseif($form->startDate && now()->lt($form->startDate))
                    Formulir <strong>{{ $form->title }}</strong> belum dibuka.
                    Formulir akan tersedia mulai:
                    <strong>{{ $form->startDate->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</strong>.
                @else
                    Formulir ini saat ini tidak menerima tanggapan.
                    Silakan coba lagi nanti atau hubungi pengelola.
                @endif
            </p>

            <div class="gf-divider"></div>

            @if($needsLogin)
            <a href="{{ route('login') }}" class="gf-home-btn"
               style="background:#6366f1;box-shadow:0 2px 10px rgba(99,102,241,.3);">
                <i class="fas fa-sign-in-alt"></i>
                <span>Login Sekarang</span>
            </a>
            <div style="margin-top:.85rem;">
                <a href="{{ url('/') }}" class="gf-again-link">
                    <i class="fas fa-home"></i> Kembali ke Beranda
                </a>
            </div>
            @else
            <a href="{{ url('/') }}" class="gf-home-btn"
               style="background:#6b7280;box-shadow:0 2px 10px rgba(107,114,128,.3);">
                <i class="fas fa-home"></i>
                <span>Kembali ke Beranda</span>
            </a>
            @endif

        </div>
    </div>
</div>
@endsection
