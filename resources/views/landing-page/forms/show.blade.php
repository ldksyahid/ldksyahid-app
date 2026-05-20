@extends('landing-page.template.body')

@section('content')

{{-- Honeypot timestamp injection --}}
@php $formStartTs = time(); @endphp

<div class="auth-section" style="padding-top: 5rem; padding-bottom: 3rem;">
    <div class="container" style="position:relative;z-index:1;">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-7 col-xl-6">

                {{-- Form card (uses auth theme) --}}
                <div class="auth-card">

                    {{-- Header --}}
                    <div class="auth-card-header">
                        <div class="auth-card-icon">
                            <i class="fas fa-clipboard-list"></i>
                        </div>
                        <div class="auth-card-title">{{ $form->title }}</div>
                        @if($form->description)
                        <div class="auth-card-subtitle">{{ $form->description }}</div>
                        @endif
                    </div>

                    {{-- Validation errors --}}
                    @if($errors->any())
                    <div class="alert alert-danger py-2 px-3 mb-3" style="border-radius:10px;font-size:.875rem;">
                        <ul class="mb-0 ps-3">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    {{-- Form --}}
                    <form action="{{ route('forms.submit', $form->slug) }}" method="POST" enctype="multipart/form-data"
                          id="publicFormSubmit" novalidate>
                        @csrf

                        {{-- Anti-spam: honeypot (visually hidden, never filled by humans) --}}
                        <div style="position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden;"
                             aria-hidden="true" tabindex="-1">
                            <input type="text" name="_hp_website" tabindex="-1" autocomplete="off" value="">
                        </div>

                        {{-- Anti-spam: form load timestamp --}}
                        <input type="hidden" name="_form_ts" value="{{ $formStartTs }}">

                        {{-- Render each field --}}
                        @foreach($fields as $field)
                            @include('landing-page.forms.components._field-renderer', ['field' => $field])
                        @endforeach

                        {{-- Submit button --}}
                        <button type="submit" class="auth-btn mt-2" id="btnSubmitForm">
                            <i class="fas fa-paper-plane"></i>
                            <span>Submit Form</span>
                            <div class="auth-btn-shine"></div>
                        </button>

                        {{-- Privacy note --}}
                        <p style="font-size:.75rem;color:var(--bs-secondary-color,#6b7280);text-align:center;margin-top:.85rem;margin-bottom:0;">
                            <i class="fas fa-shield-alt me-1"></i>
                            Your data is safe. A confirmation email will be sent after successful submission.
                        </p>

                    </form>

                </div>

                {{-- Form metadata footer --}}
                <div style="text-align:center;margin-top:1rem;font-size:.75rem;color:#9ca3af;">
                    @if($form->endDate)
                    <span><i class="fas fa-calendar-times me-1"></i>Closes: {{ $form->endDate->timezone('Asia/Jakarta')->format('d F Y, H:i') }}</span>
                    @endif
                    @if($form->maxSubmission)
                    <span class="ms-2"><i class="fas fa-users me-1"></i>Remaining quota: {{ max(0, $form->maxSubmission - $form->totalSubmission) }}</span>
                    @endif
                </div>

            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
@include('auth.login.components._index-styles')
<style>
/* ===== FORM FIELD OVERRIDES ===== */
.form-field-wrap { margin-bottom: 1.1rem; }
.form-field-label {
    display: block;
    font-size: .85rem;
    font-weight: 600;
    color: var(--bs-body-color, #374151);
    margin-bottom: .4rem;
}
.form-field-required { color: #ef4444; margin-left: .2rem; }
.form-field-help {
    font-size: .75rem;
    color: var(--bs-secondary-color, #6b7280);
    margin-top: .25rem;
}
.form-field-wrap .form-control,
.form-field-wrap .form-select {
    border-radius: 10px;
    border: 1.5px solid var(--bs-border-color, #d1d5db);
    transition: border-color .2s, box-shadow .2s;
}
.form-field-wrap .form-control:focus,
.form-field-wrap .form-select:focus {
    border-color: #00a79d;
    box-shadow: 0 0 0 3px rgba(0,167,157,.12);
}
.section-break-title {
    font-weight: 700;
    font-size: 1rem;
    color: var(--bs-body-color, #111827);
    border-bottom: 2px solid var(--bs-border-color, #e5e7eb);
    padding-bottom: .5rem;
    margin: 1.5rem 0 1rem;
}
.section-break-desc {
    font-size: .85rem;
    color: var(--bs-secondary-color, #6b7280);
    margin-top: -.5rem;
    margin-bottom: 1rem;
}
.file-upload-area {
    border: 2px dashed var(--bs-border-color, #d1d5db);
    border-radius: 10px;
    padding: 1.5rem;
    text-align: center;
    cursor: pointer;
    transition: all .2s;
}
.file-upload-area:hover { border-color: #00a79d; background: rgba(0,167,157,.03); }
.file-upload-area input[type="file"] { display: none; }
.file-upload-name { font-size: .8rem; color: #6b7280; margin-top: .5rem; }
</style>
@endsection

@section('scripts')
<script>
// Prevent double submit
document.getElementById('publicFormSubmit').addEventListener('submit', function(e) {
    const btn = document.getElementById('btnSubmitForm');
    btn.disabled = true;
    btn.querySelector('span').textContent = 'Submitting...';

    // Re-enable after 10s in case of network issue
    setTimeout(() => { btn.disabled = false; btn.querySelector('span').textContent = 'Submit Form'; }, 10000);
});

// File upload preview label
document.querySelectorAll('.file-upload-area').forEach(function(area) {
    const input = area.querySelector('input[type="file"]');
    const label = area.querySelector('.file-upload-name');

    area.addEventListener('click', () => input.click());
    area.addEventListener('dragover', e => { e.preventDefault(); area.style.borderColor = '#00a79d'; });
    area.addEventListener('dragleave', () => area.style.borderColor = '');
    area.addEventListener('drop', function(e) {
        e.preventDefault();
        if (e.dataTransfer.files.length > 0) {
            input.files = e.dataTransfer.files;
            label.textContent = e.dataTransfer.files[0].name;
        }
        area.style.borderColor = '';
    });

    if (input) {
        input.addEventListener('change', function() {
            label.textContent = this.files[0] ? this.files[0].name : 'No file selected';
        });
    }
});
</script>
@endsection
