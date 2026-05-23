@extends('landing-page.template.body')

@section('styles')
@include('landing-page.forms.components._form-styles')
@endsection

@section('content')
@php $formStartTs = time(); @endphp

<div class="gf-page">
    <div class="gf-wrap">

        {{-- ── Header Card ──────────────────────────────────────────── --}}
        <div class="gf-header-card">
            <h1 class="gf-form-title">{{ $form->title }}</h1>
            @if($form->description)
            <p class="gf-form-desc">{{ $form->description }}</p>
            @endif
        </div>

        {{-- ── Form ─────────────────────────────────────────────────── --}}
        <form action="{{ route('forms.submit', $form->slug) }}" method="POST"
              enctype="multipart/form-data" id="publicFormSubmit" novalidate>
            @csrf

            {{-- Anti-spam honeypot (hidden, never filled by humans) --}}
            <div style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden;"
                 aria-hidden="true" tabindex="-1">
                <input type="text" name="_hp_website" tabindex="-1" autocomplete="off" value="">
            </div>
            <input type="hidden" name="_form_ts" value="{{ $formStartTs }}">

            {{-- Render each field — each field renders its own card --}}
            @foreach($fields as $field)
                @include('landing-page.forms.components._field-renderer', ['field' => $field])
            @endforeach

            {{-- ── Submit area ──────────────────────────────────────── --}}
            <div class="gf-submit-area">
                <button type="submit" class="gf-submit-btn" id="gfSubmitBtn">
                    <i class="fas fa-paper-plane"></i>
                    <span>Kirimkan Formulir</span>
                </button>
                <p class="gf-privacy-note">
                    <i class="fas fa-lock me-1"></i>
                    Data Anda aman dan terlindungi.
                </p>
            </div>

        </form>

        {{-- ── Meta footer ──────────────────────────────────────────── --}}
        <div class="gf-meta-footer">
            @if($form->endDate)
            <span><i class="fas fa-calendar-times me-1"></i>Ditutup: {{ $form->endDate->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB</span>
            @endif
            @if($form->maxSubmission)
            <span class="ms-2"><i class="fas fa-users me-1"></i>Sisa kuota: {{ max(0, $form->maxSubmission - $form->totalSubmission) }} responden</span>
            @endif
        </div>

    </div>
</div>

@endsection

@section('scripts')
@include('landing-page.forms.components._form-scripts')
@endsection
