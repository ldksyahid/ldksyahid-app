@extends('admin-page.template.body')

@section('styles')
<style>
    .page-title {
        font-size: 1.65rem;
        font-weight: 600;
        text-align: center;
        color: #00a79d;
        margin: .75rem 0 1.5rem;
        position: relative;
        display: inline-block;
    }
    .page-title .highlighted-text {
        color: #008b84;
        font-weight: 700;
    }
    .page-title small {
        font-size: .75rem;
        color: #6c757d;
        font-weight: 400;
    }
    .page-title::after {
        content: '';
        display: block;
        height: 4px;
        width: 120px;
        margin: .35rem auto 0;
        border-radius: 3px;
        background: linear-gradient(90deg, #00a79d 0%, #008b84 100%);
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #00a79d;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e0f7f5;
        margin-bottom: 1.25rem;
    }
    .btn-custom-primary {
        color: #fff;
        background-color: #00a79d;
        border: 1px solid #00a79d;
        transition: all 0.3s ease;
    }
    .btn-custom-primary:hover {
        background-color: #008b84;
        border-color: #008b84;
        color: #fff;
    }
    .btn-custom-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .form-control:focus, .form-select:focus {
        border-color: #00a79d;
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .form-text { font-size: 0.8rem; color: #6c757d; }
    .invalid-feedback { font-size: 0.85rem; }

    @media (max-width: 768px) {
        .page-title { font-size: 1.35rem; }
        .card-body { padding: 1rem; }
        .section-title { font-size: 1rem; }
        .d-flex.justify-content-end.gap-2 { flex-direction: column; }
        .d-flex.justify-content-end.gap-2 .btn { width: 100%; }
    }
</style>
@endsection

@section('content')
<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fa fa-edit me-2"></i>
                <span>Edit</span>
                <span class="highlighted-text ms-1">Form</span>
                <small class="d-block mt-2">{{ $form->title }}</small>
            </h1>
        </div>

        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="col-12 mb-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Please fix the following errors:</strong>
                    <ul class="mb-0 mt-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        @endif

        <form action="{{ route('admin.forms.update', $form->formID) }}" method="POST" id="editFormForm" class="col-12">
            @csrf @method('PUT')

            {{-- Main Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- Left: Basic Info --}}
                        <div class="col-md-8">
                            <h5 class="section-title"><i class="fas fa-info-circle me-2"></i>Basic Information</h5>

                            <div class="mb-3">
                                <label for="title" class="form-label">
                                    Form Title <span class="text-danger">*</span>
                                </label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="title" name="title"
                                       value="{{ old('title', $form->title) }}" required maxlength="255">
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="3"
                                          maxlength="2000">{{ old('description', $form->description) }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="confirmationMessage" class="form-label">Confirmation Message</label>
                                <textarea class="form-control" id="confirmationMessage" name="confirmationMessage"
                                          rows="2" maxlength="1000">{{ old('confirmationMessage', $form->confirmationMessage) }}</textarea>
                                <div class="form-text">Shown to the respondent after a successful submission (when no redirect URL is set).</div>
                            </div>

                            <div class="mb-0">
                                <label for="redirectUrl" class="form-label">Redirect URL <span class="text-muted small">(Optional)</span></label>
                                <input type="url" class="form-control @error('redirectUrl') is-invalid @enderror"
                                       id="redirectUrl" name="redirectUrl"
                                       value="{{ old('redirectUrl', $form->redirectUrl) }}" maxlength="500"
                                       placeholder="https://...">
                                @error('redirectUrl') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        {{-- Right: Rules + Collaborators --}}
                        <div class="col-md-4">
                            <h5 class="section-title"><i class="fas fa-cog me-2"></i>Submission Rules</h5>

                            <div class="mb-3">
                                <label for="maxSubmission" class="form-label">Max. Submissions</label>
                                <input type="number" class="form-control" id="maxSubmission" name="maxSubmission"
                                       value="{{ old('maxSubmission', $form->maxSubmission) }}" min="1"
                                       placeholder="Leave blank = unlimited">
                            </div>

                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="text" class="form-control flatpickr-datetime" id="startDate" name="startDate"
                                       value="{{ old('startDate', $form->startDate?->format('Y-m-d H:i')) }}"
                                       placeholder="dd/mm/yyyy HH:MM" autocomplete="off">
                            </div>

                            <div class="mb-4">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="text" class="form-control flatpickr-datetime" id="endDate" name="endDate"
                                       value="{{ old('endDate', $form->endDate?->format('Y-m-d H:i')) }}"
                                       placeholder="dd/mm/yyyy HH:MM" autocomplete="off">
                            </div>

                            <h5 class="section-title"><i class="fab fa-google-drive me-2"></i>Collaborators</h5>

                            <div class="mb-0">
                                <label for="collaboratorEmails" class="form-label">Collaborator Emails</label>
                                <textarea class="form-control" id="collaboratorEmails" name="collaboratorEmails"
                                          rows="4" placeholder="email1@gmail.com, email2@gmail.com"
                                          style="font-size:.85rem;">{{ old('collaboratorEmails', implode(', ', $form->collaboratorEmails ?? [])) }}</textarea>
                                <div class="form-text">Added emails receive GDrive Editor access. Removed emails have their access revoked.</div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.forms.show', $form->formID) }}" class="btn btn-danger">
                        <i class="fa fa-times me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-custom-primary" id="btnSave">
                        <i class="fa fa-save me-1"></i> Save Changes
                    </button>
                </div>
            </div>

        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.getElementById('editFormForm').addEventListener('submit', function() {
    const btn = document.getElementById('btnSave');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
});
</script>
@endsection
