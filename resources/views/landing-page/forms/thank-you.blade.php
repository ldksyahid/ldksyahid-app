@extends('landing-page.template.body')

@section('styles')
@include('landing-page.forms.components._form-styles')
@endsection

@section('content')
<div class="gf-state-page">
    <div class="container">
        <div class="gf-state-card">

            {{-- Form title as header --}}
            <h2 class="gf-state-form-title">{{ $form->title }}</h2>

            {{-- Confirmation message --}}
            <p class="gf-state-body">
                @if($form->confirmationMessage)
                    {{ $form->confirmationMessage }}
                @else
                    Alhamdulillah, jawaban kamu telah berhasil kami terima.
                    Jazakumullahu Khairan atas partisipasi kamu, semoga Allah membalas kebaikan kamu
                    dan memudahkan segala urusan kamu.
                @endif
            </p>

            {{-- Links --}}
            @if($form->isMultipleSubmit)
            <a href="{{ route('forms.show', $form->slug) }}" class="gf-state-link">
                <i class="fas fa-redo me-1"></i> Kirim jawaban lain
            </a>
            @endif
            <a href="{{ url('/') }}" class="gf-state-link">
                <i class="fas fa-home me-1"></i> Kembali ke beranda
            </a>

        </div>
    </div>
</div>
@endsection
