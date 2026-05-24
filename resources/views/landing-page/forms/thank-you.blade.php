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
                    Alhamdulillah, jawaban Anda telah berhasil kami terima.
                    Jazakumullahu Khairan atas partisipasi Anda, semoga Allah membalas kebaikan Anda
                    dan memudahkan segala urusan Anda.
                @endif
            </p>

            {{-- Links --}}
            @if($form->isMultipleSubmit)
            <a href="{{ route('forms.show', $form->slug) }}" class="gf-state-link">
                Kirim jawaban lain
            </a>
            @endif
            <a href="{{ url('/') }}" class="gf-state-link">Kembali ke beranda</a>

        </div>
    </div>
</div>
@endsection
