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
    box-shadow: 0 1px 4px rgba(0,0,0,.06); padding: 1.25rem 1.5rem; margin-bottom: 1.25rem;
}
.mr-table { font-size: .83rem; }
.mr-table th {
    font-size: .73rem; text-transform: uppercase; letter-spacing: .05em;
    color: #9ca3af; font-weight: 600; border-bottom: 2px solid #e5e7eb; white-space: nowrap;
}
.mr-table td { vertical-align: middle; }
.mr-actions { display: flex; gap: .35rem; }
.mr-actions .btn { padding: .3rem .55rem; }
.mr-row-exiting { opacity: 0; transition: opacity .25s ease; }

html.dark-mode .mr-card { background: #1a1d23; border-color: #2d3139; }
html.dark-mode .mr-table th { border-bottom-color: #2d3139; }
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4" style="overflow-x:hidden;">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        <div class="col-12 text-center mb-3">
            <h1 class="page-title">
                <i class="fa fa-list-alt me-2"></i>
                <span>Manage</span>
                <span class="highlighted-text ms-1">Responses</span>
                <small class="d-block mt-2">{{ $form->title }}</small>
            </h1>
        </div>

        <div class="col-12 mb-4">

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
                        <i class="fa fa-inbox me-1"></i>
                        {{ number_format($submissions->total()) }} response{{ $submissions->total() === 1 ? '' : 's' }} total
                    </span>
                </div>

                @if($form->gdriveSpreadsheetUrl)
                <a href="{{ $form->gdriveSpreadsheetUrl }}" target="_blank" class="btn btn-sm btn-custom-primary">
                    <i class="fas fa-table me-1"></i> Open in Google Sheets
                </a>
                @endif
            </div>

            <div class="mr-card">
                @if($submissions->isEmpty())
                <p class="text-muted text-center py-4 mb-0" style="font-size:.9rem;">
                    <i class="fa fa-inbox fa-2x d-block mb-2"></i>
                    No responses yet.
                </p>
                @else
                <div class="table-responsive">
                    <table class="table table-hover mr-table mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Submitted At</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $i => $sub)
                            <tr id="response-row-{{ $sub->formSubmissionID }}">
                                <td>{{ $submissions->firstItem() + $i }}</td>
                                <td>{{ $sub->respondentName ?: '—' }}</td>
                                <td>{{ $sub->respondentEmail ?: '—' }}</td>
                                <td>{{ $sub->submittedAt?->timezone('Asia/Jakarta')->format('d M Y H:i') }} WIB</td>
                                <td>
                                    @if($sub->flagValid)
                                        <span class="badge bg-success">Valid</span>
                                    @else
                                        <span class="badge bg-danger">Invalid</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="mr-actions justify-content-end">
                                        <a href="{{ route('admin.forms.responses.show', [$form->formID, $sub->formSubmissionID]) }}"
                                           class="btn btn-sm btn-custom-primary" title="View / Edit">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <button type="button" class="btn btn-sm btn-custom-primary" title="Delete this response"
                                                onclick="deleteResponse(this, {{ $sub->formSubmissionID }}, '{{ addslashes($sub->respondentName ?: $sub->respondentEmail ?: ('#' . $sub->formSubmissionID)) }}')">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @endif
            </div>

            @if($submissions->hasPages())
            <div class="d-flex justify-content-center mb-4">
                {{ $submissions->links() }}
            </div>
            @endif

            <div class="row mb-5">
                <div class="col-12 d-flex justify-content-between flex-wrap gap-2">
                    <a href="{{ route('admin.forms.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                    <button type="button" class="btn btn-danger" id="btnDeleteAll" onclick="deleteAllResponses(this)">
                        <i class="fa fa-trash-alt me-1"></i> Delete All Responses
                    </button>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
const FORM_ID    = {{ $form->formID }};
const CSRF_TOKEN = document.querySelector('meta[name="csrf-token"]').content;

function deleteResponse(btn, submissionID, label) {
    Swal.fire({
        title: 'Delete this response?',
        html: 'This will permanently delete <strong>' + label + '</strong>\'s submission, its uploaded files, and remove its row from the Google Sheet. This cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete',
        confirmButtonColor: '#dc3545',
    }).then(function (result) {
        if (!result.isConfirmed) return;

        const originalHtml = btn.innerHTML;
        const row           = document.getElementById('response-row-' + submissionID);
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        row?.querySelectorAll('.mr-actions .btn').forEach(b => b.disabled = true);

        fetch(`/admin/forms/${FORM_ID}/responses/${submissionID}`, {
            method : 'DELETE',
            headers: {
                'X-CSRF-TOKEN'     : CSRF_TOKEN,
                'X-Requested-With' : 'XMLHttpRequest',
                'Accept'           : 'application/json',
            },
        })
        .then(res => res.json().then(data => ({ status: res.status, data })))
        .then(({ status, data }) => {
            if (status === 200 && data.success) {
                if (row) {
                    row.classList.add('mr-row-exiting');
                    setTimeout(() => row.remove(), 250);
                }
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: data.message || 'Response deleted.', showConfirmButton: false, timer: 2500, timerProgressBar: true });
            } else {
                btn.disabled  = false;
                btn.innerHTML = originalHtml;
                row?.querySelectorAll('.mr-actions .btn').forEach(b => b.disabled = false);
                Swal.fire('Error', data.message || 'Failed to delete response.', 'error');
            }
        })
        .catch(() => {
            btn.disabled  = false;
            btn.innerHTML = originalHtml;
            row?.querySelectorAll('.mr-actions .btn').forEach(b => b.disabled = false);
            Swal.fire('Error', 'Network error while deleting response.', 'error');
        });
    });
}

function deleteAllResponses(btn) {
    Swal.fire({
        title: 'Delete ALL responses?',
        text: 'This will permanently delete every submission and uploaded file for this form. Google Sheets data will also be cleared. This cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, Delete All',
        confirmButtonColor: '#dc3545',
    }).then(function (result) {
        if (!result.isConfirmed) return;

        const originalHtml = btn.innerHTML;
        btn.disabled  = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Deleting...';

        fetch(`/admin/forms/${FORM_ID}/responses`, {
            method : 'DELETE',
            headers: {
                'X-CSRF-TOKEN'     : CSRF_TOKEN,
                'X-Requested-With' : 'XMLHttpRequest',
                'Accept'           : 'application/json',
            },
        })
        .then(res => res.json().then(data => ({ status: res.status, data })))
        .then(({ status, data }) => {
            if (status === 200 && data.success) {
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: data.message || 'All responses deleted.', showConfirmButton: false, timer: 2500, timerProgressBar: true });
                setTimeout(() => window.location.reload(), 800);
            } else {
                btn.disabled  = false;
                btn.innerHTML = originalHtml;
                Swal.fire('Error', data.message || 'Failed to delete responses.', 'error');
            }
        })
        .catch(() => {
            btn.disabled  = false;
            btn.innerHTML = originalHtml;
            Swal.fire('Error', 'Network error while deleting responses.', 'error');
        });
    });
}
</script>
@endsection
