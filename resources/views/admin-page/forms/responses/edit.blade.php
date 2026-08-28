@extends('admin-page.template.body')

@section('styles')
@include('admin-page.forms.components._form._form-styles')
<style>
.mr-header {
    display: flex; align-items: center; justify-content: space-between;
    flex-wrap: wrap; gap: .75rem; margin-bottom: 1.5rem;
}
.mr-card {
    background: #fff; border-radius: 12px; border: 1px solid #e5e7eb;
    box-shadow: 0 1px 4px rgba(0,0,0,.06); padding: 1.5rem; margin-bottom: 1.25rem;
}
.mr-meta { font-size: .82rem; color: #6b7280; }
html.dark-mode .mr-card { background: #1a1d23; border-color: #2d3139; }
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4" style="overflow-x:hidden;">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        <div class="col-12 text-center mb-3">
            <h1 class="page-title">
                <i class="fa fa-edit me-2"></i>
                <span>Edit</span>
                <span class="highlighted-text ms-1">Response</span>
                <small class="d-block mt-2">{{ $form->title }}</small>
            </h1>
        </div>

        <div class="col-12 col-lg-9 mb-4">

            {{-- Header bar --}}
            <div class="mr-header">
                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="badge
                        @if($form->status === 'published') badge-status-published
                        @elseif($form->status === 'draft')  badge-status-draft
                        @elseif($form->status === 'closed') badge-status-closed
                        @else badge-status-archived @endif">
                        {{ ucfirst($form->status) }}
                    </span>
                    <span class="text-muted" style="font-size:.83rem;">
                        <i class="fa fa-hashtag me-1"></i>
                        Response #{{ $submission->formSubmissionID }}
                    </span>
                </div>
            </div>

            @if($sheetMissing)
            <div class="alert alert-warning">
                <i class="fa fa-exclamation-triangle me-1"></i>
                Baris response ini tidak ditemukan di Google Sheets (mungkin sudah dihapus manual di sana).
                Jawaban di bawah mungkin tidak lengkap atau tidak akurat.
            </div>
            @endif

            <div class="mr-card mb-3">
                <div class="row g-2 mr-meta">
                    <div class="col-md-4"><strong>Submission ID:</strong> #{{ $submission->formSubmissionID }}</div>
                    <div class="col-md-4"><strong>Submitted:</strong> {{ $submission->submittedAt?->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</div>
                    <div class="col-md-4"><strong>Status:</strong> {{ $submission->flagValid ? 'Valid' : 'Invalid' }}</div>
                </div>
            </div>

            <form id="editResponseForm" enctype="multipart/form-data">
                <div class="mr-card">
                    @foreach($activeFields as $field)
                        @include('admin-page.forms.responses._field-input', ['field' => $field, 'answers' => $answers, 'files' => $files])
                    @endforeach
                </div>

                <div class="d-flex justify-content-between flex-wrap gap-2 mb-5">
                    <a href="{{ route('admin.forms.responses.index', $form->formID) }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                    <button type="submit" class="btn btn-custom-primary" id="btnSaveResponse">
                        <i class="fa fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
(function () {
    const form   = document.getElementById('editResponseForm');
    const btn    = document.getElementById('btnSaveResponse');
    const url    = '{{ route("admin.forms.responses.update", [$form->formID, $submission->formSubmissionID]) }}';
    const csrf   = document.querySelector('meta[name="csrf-token"]').content;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Saving...';

        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.remove());

        const formData = new FormData(form);
        // PHP never parses multipart/form-data bodies on anything but a real
        // POST request (that's a PHP SAPI limitation, not a Laravel one) — so
        // a genuine wire-level PUT here would silently arrive with NO fields
        // parsed at all, failing every "required" check. Send a real POST
        // with _method=PUT instead; Laravel's method-spoofing routes it to
        // the PUT handler while PHP still parses the body correctly.
        formData.append('_method', 'PUT');

        fetch(url, {
            method : 'POST',
            headers: {
                'X-CSRF-TOKEN'     : csrf,
                'X-Requested-With' : 'XMLHttpRequest',
                'Accept'           : 'application/json',
            },
            body: formData,
        })
        .then(res => res.json().then(data => ({ status: res.status, data })))
        .then(({ status, data }) => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-save me-1"></i> Save Changes';

            if (status === 200 && data.success) {
                Swal.fire({ icon: 'success', title: 'Saved', text: data.message, timer: 1500, showConfirmButton: false })
                    .then(() => { window.location.href = '{{ route("admin.forms.responses.index", $form->formID) }}'; });
            } else if (status === 422 && data.errors) {
                Object.keys(data.errors).forEach(function (key) {
                    const input = form.querySelector(`[name="${key}"]`) || form.querySelector(`[name="${key}[]"]`);
                    if (!input) return;
                    input.classList.add('is-invalid');
                    const msg = document.createElement('div');
                    msg.className = 'invalid-feedback d-block';
                    msg.textContent = data.errors[key][0];
                    input.closest('.mb-3')?.appendChild(msg);
                });
                Swal.fire('Validation Error', data.message || 'Please check the highlighted fields.', 'error');
            } else {
                Swal.fire('Error', data.message || 'Failed to save response.', 'error');
            }
        })
        .catch(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa fa-save me-1"></i> Save Changes';
            Swal.fire('Error', 'Network error while saving response.', 'error');
        });
    });
})();
</script>
@endsection
