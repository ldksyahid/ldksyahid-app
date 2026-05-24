@extends('landing-page.template.body')

@section('styles')
@include('landing-page.forms.components._form-styles')
@endsection

@section('content')
<div class="gf-state-page">
    <div class="container">
        <div class="gf-state-card">

            @php
                $needsLogin       = isset($needsLogin) && $needsLogin;
                $alreadySubmitted = isset($alreadySubmitted) && $alreadySubmitted;
            @endphp

            {{-- Form title as header --}}
            <h2 class="gf-state-form-title">{{ $form->title }}</h2>

            {{-- State message --}}
            <p class="gf-state-body">
                @if($needsLogin)
                    Untuk dapat mengisi formulir ini, silakan login terlebih dahulu menggunakan akun kamu.
                    Semoga Allah memudahkan urusan kamu.
                @elseif($alreadySubmitted)
                    Alhamdulillah, kamu telah mengisi formulir ini sebelumnya.
                    Jazakumullahu Khairan atas partisipasi kamu, semoga Allah membalas kebaikan kamu.
                @elseif($form->status === 'closed')
                    Alhamdulillah, formulir ini telah ditutup dan tidak lagi menerima tanggapan baru.
                    Jazakumullahu Khairan atas perhatian kamu.
                @elseif($form->status === 'draft')
                    Formulir ini belum dibuka untuk umum oleh pengelola.
                    Mohon bersabar, in sha Allah formulir akan segera dibuka.
                @elseif($form->maxSubmission && $form->totalSubmission >= $form->maxSubmission)
                    Alhamdulillah, formulir ini telah mencapai batas maksimum pendaftar
                    ({{ number_format($form->maxSubmission) }} responden).
                    Jazakumullahu Khairan atas minat dan antusias kamu.
                @elseif($form->endDate && now()->gt($form->endDate))
                    Formulir ini telah melewati batas waktu pengisian
                    ({{ $form->endDate->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') }} WIB).
                    Jazakumullahu Khairan atas perhatian kamu.
                @elseif($form->startDate && now()->lt($form->startDate))
                    Formulir ini belum dibuka. In sha Allah akan tersedia mulai
                    <strong>{{ $form->startDate->timezone('Asia/Jakarta')->locale('id')->translatedFormat('d F Y, H:i') }} WIB</strong>.
                @else
                    Formulir ini saat ini tidak menerima tanggapan.
                    Silakan coba lagi nanti atau hubungi pengelola. Jazakumullahu Khairan.
                @endif
            </p>

            {{-- Action links --}}
            @if($needsLogin)
            <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="gf-state-link">
                <i class="fas fa-sign-in-alt me-1"></i> Login sekarang
            </a>
            <a href="{{ url('/') }}" class="gf-state-link">
                <i class="fas fa-home me-1"></i> Kembali ke beranda
            </a>
            @else
            <a href="{{ url('/') }}" class="gf-state-link">
                <i class="fas fa-home me-1"></i> Kembali ke beranda
            </a>
            @endif

        </div>
    </div>
</div>
@endsection
