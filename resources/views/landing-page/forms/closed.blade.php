@extends('landing-page.template.body')

@section('content')
<div class="auth-section" style="padding-top: 5rem; padding-bottom: 3rem;">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-8 col-lg-6 col-xl-5">

                <div class="auth-card" style="text-align:center;">

                    {{-- Icon --}}
                    <div style="width:80px;height:80px;background:linear-gradient(135deg,#6b7280,#9ca3af);
                                border-radius:50%;display:flex;align-items:center;justify-content:center;
                                margin:0 auto 1.25rem;box-shadow:0 8px 24px rgba(107,114,128,.2);">
                        <i class="fas fa-lock fa-2x" style="color:#fff;"></i>
                    </div>

                    {{-- Title --}}
                    <h3 style="font-weight:800;color:var(--bs-body-color,#111827);margin-bottom:.5rem;">
                        Form Not Available
                    </h3>

                    {{-- Reason --}}
                    <p style="color:var(--bs-secondary-color,#6b7280);font-size:.95rem;line-height:1.6;margin-bottom:1.5rem;">
                        @if($form->status === 'closed')
                            The form <strong>{{ $form->title }}</strong> has been closed
                            and is no longer accepting submissions.
                        @elseif($form->status === 'draft')
                            This form has not been published yet.
                        @elseif($form->maxSubmission && $form->totalSubmission >= $form->maxSubmission)
                            The form <strong>{{ $form->title }}</strong> has reached its
                            maximum submission limit ({{ number_format($form->maxSubmission) }}).
                        @elseif($form->endDate && now()->gt($form->endDate))
                            The form <strong>{{ $form->title }}</strong> has passed its
                            closing time
                            ({{ $form->endDate->timezone('Asia/Jakarta')->format('d F Y, H:i') }}).
                        @elseif($form->startDate && now()->lt($form->startDate))
                            The form <strong>{{ $form->title }}</strong> is not open yet.
                            Opens: {{ $form->startDate->timezone('Asia/Jakarta')->format('d F Y, H:i') }}.
                        @else
                            This form is not currently accepting submissions.
                        @endif
                    </p>

                    <a href="{{ url('/') }}" class="auth-btn" style="display:inline-flex;text-decoration:none;width:auto;padding:.6rem 2rem;">
                        <i class="fas fa-home"></i>
                        <span>Back to Home</span>
                        <div class="auth-btn-shine"></div>
                    </a>

                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
@include('auth.login.components._index-styles')
@endsection
