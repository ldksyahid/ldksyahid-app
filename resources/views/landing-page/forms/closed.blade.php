@extends('landing-page.template.body')

@section('styles')
@include('landing-page.forms.components._form-styles')
@endsection

@section('content')
<div class="gf-state-page">
    <div class="container">
        <div class="gf-state-card" style="border-top-color:#6b7280;">

            {{-- Icon --}}
            <div class="gf-state-icon-wrap closed">
                <i class="fas fa-lock"></i>
            </div>

            {{-- Title --}}
            <h3 class="gf-state-title">Formulir Tidak Tersedia</h3>

            {{-- Reason message --}}
            <p class="gf-state-body">
                @if($form->status === 'closed')
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

            <a href="{{ url('/') }}" class="gf-home-btn"
               style="background:#6b7280;box-shadow:0 2px 10px rgba(107,114,128,.3);">
                <i class="fas fa-home"></i>
                <span>Kembali ke Beranda</span>
            </a>

        </div>
    </div>
</div>
@endsection
