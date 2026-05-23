@extends('landing-page.template.body')

@section('styles')
@include('landing-page.forms.components._form-styles')
@endsection

@section('content')
<div class="gf-state-page">
    <div class="container">
        <div class="gf-state-card">

            {{-- Success icon --}}
            <div class="gf-state-icon-wrap success">
                <i class="fas fa-check"></i>
            </div>

            {{-- Title --}}
            <h3 class="gf-state-title">Alhamdulillah, Formulir Berhasil Dikirim!</h3>

            {{-- Body message --}}
            <p class="gf-state-body">
                @if($form->confirmationMessage)
                    {{ $form->confirmationMessage }}
                @else
                    Jazakumullahu Khairan atas partisipasi Anda dalam mengisi formulir
                    <strong>{{ $form->title }}</strong>.
                    Respons Anda telah kami terima dan email konfirmasi akan segera dikirimkan.
                @endif
            </p>

            <div class="gf-divider"></div>

            {{-- Back to home --}}
            <a href="{{ url('/') }}" class="gf-home-btn">
                <i class="fas fa-home"></i>
                <span>Kembali ke Beranda</span>
            </a>

            {{-- Fill again --}}
            @if($form->isMultipleSubmit)
            <div style="margin-top:.85rem;">
                <a href="{{ route('forms.show', $form->slug) }}" class="gf-again-link">
                    <i class="fas fa-redo"></i> Isi formulir kembali
                </a>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection
