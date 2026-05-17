@extends('landing-page.template.body')

@section('content')
<div class="auth-section" style="padding-top: 5rem; padding-bottom: 3rem;">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                <div class="auth-card" style="text-align:center;">

                    {{-- Success icon --}}
                    <div style="width:80px;height:80px;background:linear-gradient(135deg,#1a6b3a,#2ea65a);
                                border-radius:50%;display:flex;align-items:center;justify-content:center;
                                margin:0 auto 1.25rem;box-shadow:0 8px 24px rgba(26,107,58,.25);">
                        <i class="fas fa-check fa-2x" style="color:#fff;"></i>
                    </div>

                    {{-- Title --}}
                    <h3 style="font-weight:800;color:#111827;margin-bottom:.5rem;">
                        Formulir Terkirim! ✅
                    </h3>

                    {{-- Subtitle --}}
                    <p style="color:#6b7280;font-size:.95rem;line-height:1.6;margin-bottom:1.5rem;">
                        @if($form->confirmationMessage)
                            {{ $form->confirmationMessage }}
                        @else
                            Terima kasih telah mengisi <strong>{{ $form->title }}</strong>.
                            Jawaban kamu telah diterima dan konfirmasi akan segera dikirim ke email kamu.
                        @endif
                    </p>

                    {{-- Divider --}}
                    <div style="border-top:1px solid #e5e7eb;margin:1.25rem 0;"></div>

                    {{-- Islamic closing --}}
                    <p style="font-size:.875rem;color:#9ca3af;font-style:italic;margin-bottom:1.25rem;">
                        "Sesungguhnya Allah tidak menyia-nyiakan amal orang yang berbuat kebaikan."
                        <br><span style="font-size:.8rem;">– QS. At-Taubah 9:120</span>
                    </p>

                    {{-- Back home button --}}
                    <a href="{{ url('/') }}" class="auth-btn" style="display:inline-flex;text-decoration:none;width:auto;padding:.6rem 2rem;">
                        <i class="fas fa-home"></i>
                        <span>Kembali ke Beranda</span>
                        <div class="auth-btn-shine"></div>
                    </a>

                    {{-- Fill again link (if multiple submit allowed) --}}
                    @if($form->isMultipleSubmit)
                    <p style="margin-top:1rem;font-size:.85rem;">
                        <a href="{{ route('forms.show', $form->slug) }}"
                           style="color:#1a6b3a;text-decoration:none;font-weight:600;">
                            <i class="fas fa-redo me-1"></i> Isi formulir lagi
                        </a>
                    </p>
                    @endif

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
@include('auth.login.components._index-styles')
@endsection
