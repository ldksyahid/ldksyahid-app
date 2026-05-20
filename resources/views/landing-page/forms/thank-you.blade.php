@extends('landing-page.template.body')

@section('content')
<div class="auth-section" style="padding-top: 5rem; padding-bottom: 3rem;">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                <div class="auth-card" style="text-align:center;">

                    {{-- Success icon --}}
                    <div style="width:80px;height:80px;background:linear-gradient(135deg,#00a79d,#008b84);
                                border-radius:50%;display:flex;align-items:center;justify-content:center;
                                margin:0 auto 1.25rem;box-shadow:0 8px 24px rgba(0,167,157,.25);">
                        <i class="fas fa-check fa-2x" style="color:#fff;"></i>
                    </div>

                    {{-- Title --}}
                    <h3 style="font-weight:800;color:var(--bs-body-color,#111827);margin-bottom:.5rem;">
                        Form Submitted!
                    </h3>

                    {{-- Subtitle --}}
                    <p style="color:var(--bs-secondary-color,#6b7280);font-size:.95rem;line-height:1.6;margin-bottom:1.5rem;">
                        @if($form->confirmationMessage)
                            {{ $form->confirmationMessage }}
                        @else
                            Thank you for filling out <strong>{{ $form->title }}</strong>.
                            Your response has been received and a confirmation will be sent to your email shortly.
                        @endif
                    </p>

                    {{-- Divider --}}
                    <div style="border-top:1px solid var(--bs-border-color,#e5e7eb);margin:1.25rem 0;"></div>

                    {{-- Back home button --}}
                    <a href="{{ url('/') }}" class="auth-btn" style="display:inline-flex;text-decoration:none;width:auto;padding:.6rem 2rem;">
                        <i class="fas fa-home"></i>
                        <span>Back to Home</span>
                        <div class="auth-btn-shine"></div>
                    </a>

                    {{-- Fill again link (if multiple submit allowed) --}}
                    @if($form->isMultipleSubmit)
                    <p style="margin-top:1rem;font-size:.85rem;">
                        <a href="{{ route('forms.show', $form->slug) }}"
                           style="color:#00a79d;text-decoration:none;font-weight:600;">
                            <i class="fas fa-redo me-1"></i> Submit again
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
