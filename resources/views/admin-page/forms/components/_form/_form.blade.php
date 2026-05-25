@php
    $operation = $operation ?? 'create';
    $form      = $form ?? null;
@endphp

<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                @if($operation === 'create')
                    <i class="fa fa-plus-circle me-2"></i>
                    <span>Create New</span>
                    <span class="highlighted-text ms-1">Form</span>
                @elseif($operation === 'edit')
                    <i class="fa fa-edit me-2"></i>
                    <span>Edit</span>
                    <span class="highlighted-text ms-1">Form</span>
                    <small class="d-block mt-2">{{ $form->title }}</small>
                @else
                    <i class="fas fa-eye me-2"></i>
                    <span>View</span>
                    <span class="highlighted-text ms-1">Form</span>
                    <small class="d-block mt-2">{{ $form->title }}</small>
                @endif
            </h1>
        </div>

        {{-- Validation Errors (create / edit only) --}}
        @if($operation !== 'view' && $errors->any())
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

        {{-- ===================== VIEW MODE ===================== --}}
        @if($operation === 'view')
        @php
            $isOwner   = auth()->check() && auth()->user()->email === $form->createdBy;
            $canManage = $isOwner || ($isSuperadmin ?? false);
        @endphp
        <div class="col-md-12 mb-4">

            {{-- Stats Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-4">
                            <div class="stat-box">
                                <div class="stat-num">{{ number_format($form->totalSubmission) }}</div>
                                <div class="stat-lbl">Total Submissions</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <div class="stat-num">{{ $form->activeFields->count() }}</div>
                                <div class="stat-lbl">Fields</div>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="stat-box">
                                <div class="stat-num">v{{ $form->version }}</div>
                                <div class="stat-lbl">Version</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Main Detail Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <div class="row">

                        {{-- Left: Basic Info --}}
                        <div class="col-md-8">
                            <h5 class="section-title mb-3 d-flex align-items-center justify-content-between">
                                <span><i class="fas fa-info-circle me-2"></i>Basic Information</span>
                                <span class="badge status-badge-lg
                                    @if($form->status === 'published') bg-success
                                    @elseif($form->status === 'draft') bg-secondary
                                    @elseif($form->status === 'closed') bg-warning text-dark
                                    @else bg-dark @endif">
                                    {{ ucfirst($form->status) }}
                                </span>
                            </h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Form Title</label>
                                <div class="form-control-plaintext">{{ $form->title }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Description</label>
                                <div class="form-control-plaintext">{{ $form->description ?: '—' }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Confirmation Message</label>
                                <div class="form-control-plaintext">{{ $form->confirmationMessage ?: '—' }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Redirect URL <span class="text-muted small">(Optional)</span></label>
                                <div class="form-control-plaintext">
                                    @if($form->redirectUrl)
                                        <a href="{{ $form->redirectUrl }}" target="_blank">{{ $form->redirectUrl }}</a>
                                    @else
                                        —
                                    @endif
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Public URL</label>
                                <div class="d-flex align-items-center gap-2">
                                    <code id="formPublicUrl">{{ url('/form/' . $form->slug) }}</code>
                                    <button class="copy-url-btn" onclick="copyFormUrl()" title="Copy URL">
                                        <i class="fa fa-copy"></i> Copy
                                    </button>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Created By</label>
                                    <div class="form-control-plaintext">{{ $form->createdBy }}</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label fw-bold">Created Date</label>
                                    <div class="form-control-plaintext">
                                        {{ $form->createdDate?->timezone('Asia/Jakarta')->format('d F Y, H:i') }} WIB
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Right: Rules + GDrive + Collaborators --}}
                        <div class="col-md-4">
                            <h5 class="section-title mb-3"><i class="fas fa-cog me-2"></i>Submission Rules</h5>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Max. Submissions</label>
                                <div class="form-control-plaintext">{{ $form->maxSubmission ? number_format($form->maxSubmission) : 'Unlimited' }}</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Start Date</label>
                                <div class="form-control-plaintext">{{ $form->startDate ? $form->startDate->format('d M Y H:i') . ' WIB' : '—' }}</div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">End Date</label>
                                <div class="form-control-plaintext">{{ $form->endDate ? $form->endDate->format('d M Y H:i') . ' WIB' : '—' }}</div>
                            </div>

                            <h5 class="section-title mb-3"><i class="fab fa-google-drive me-2"></i>Google Drive</h5>

                            @php
                                $currentUser      = auth()->user();
                                $canAccessGdrive  = ($isSuperadmin ?? false)
                                    || ($currentUser && in_array($currentUser->email, $form->collaboratorEmails ?? []));
                            @endphp

                            @if($canAccessGdrive)
                            @if($form->gdriveSpreadsheetUrl)
                            <a href="{{ $form->gdriveSpreadsheetUrl }}" target="_blank" class="gdrive-link">
                                <i class="fas fa-table gdrive-icon text-success"></i>
                                <span class="gdrive-text">
                                    <strong>Responses Spreadsheet</strong>
                                    <small>All form submissions are automatically written here as rows.</small>
                                </span>
                                <i class="fas fa-external-link-alt gdrive-ext"></i>
                            </a>
                            @endif
                            @if($form->gdriveAttachmentsFolderUrl)
                            <a href="{{ $form->gdriveAttachmentsFolderUrl }}" target="_blank" class="gdrive-link">
                                <i class="fas fa-folder gdrive-icon text-warning"></i>
                                <span class="gdrive-text">
                                    <strong>Attachments Folder</strong>
                                    <small>Uploaded files (images, documents) from respondents are stored here.</small>
                                </span>
                                <i class="fas fa-external-link-alt gdrive-ext"></i>
                            </a>
                            @endif
                            @else
                            @if($form->gdriveSpreadsheetUrl || $form->gdriveAttachmentsFolderUrl)
                            <p class="mb-0 mt-1" style="font-size:.75rem; color:#6b7280;">
                                <i class="fa fa-lock fa-xs me-1 text-warning"></i>
                                Google Drive access is restricted to the form creator and superadmin only.
                            </p>
                            @endif
                            @endif

                            @if(!$form->gdriveSpreadsheetUrl && !$form->gdriveAttachmentsFolderUrl)
                            <p class="text-muted mb-3" style="font-size:.8rem;">
                                <i class="fa fa-info-circle me-1"></i> Google Drive not yet configured.
                            </p>
                            @endif

                            @if($form->collaboratorEmails && count($form->collaboratorEmails))
                            <h5 class="section-title mb-3 mt-3"><i class="fa fa-users me-2"></i>Collaborators</h5>
                            @foreach($form->collaboratorEmails as $collab)
                            <div class="form-control-plaintext py-1">
                                <i class="fa fa-user fa-sm text-success me-2"></i>{{ $collab }}
                            </div>
                            @endforeach
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            {{-- Fields Card --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-body">
                    <h5 class="section-title mb-3"><i class="fa fa-list me-2"></i>Form Fields</h5>
                    @forelse($form->activeFields as $field)
                    <span class="field-pill {{ $field->isSystemField ? 'system' : '' }}">
                        <i class="fa
                            @switch($field->fieldType)
                                @case('email') fa-envelope @break
                                @case('file') @case('image') fa-file-upload @break
                                @case('dropdown') fa-chevron-circle-down @break
                                @case('radio') fa-dot-circle @break
                                @case('checkbox') fa-check-square @break
                                @case('date') @case('datetime') fa-calendar @break
                                @case('number') fa-hashtag @break
                                @case('section_break') fa-minus @break
                                @default fa-font
                            @endswitch
                            fa-sm"></i>
                        {{ $field->label }}
                        @if($field->isRequired) <span style="color:#ef4444;">*</span> @endif
                        @if($field->isSystemField) <i class="fa fa-lock fa-xs" title="System field"></i> @endif
                    </span>
                    @empty
                    <p class="text-muted mb-0" style="font-size:.875rem;">
                        No fields yet.
                        @if($canManage)
                            <a href="{{ route('admin.forms.builder', $form->formID) }}">Open Form Builder</a> to add fields.
                        @endif
                    </p>
                    @endforelse
                </div>
            </div>

            {{-- Actions --}}
            <div class="row mb-5">
                <div class="col-md-12 d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.forms.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left me-1"></i> Back
                    </a>
                    @if($canManage)
                    <a href="{{ route('admin.forms.edit', $form->formID) }}" class="btn btn-custom-primary">
                        <i class="fa fa-edit me-1"></i> Edit
                    </a>
                    @endif
                </div>
            </div>

        </div>
        {{-- ===================== END VIEW MODE ===================== --}}

        {{-- ===================== CREATE / EDIT MODE ===================== --}}
        @else

        @if($operation === 'create')
        <form action="{{ route('admin.forms.store') }}" method="POST" id="createFormForm" class="col-12">
        @csrf
        @else
        <form action="{{ route('admin.forms.update', $form->formID) }}" method="POST" id="editFormForm" class="col-12">
        @csrf @method('PUT')
        @endif

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
                                       value="{{ old('title', $form?->title) }}" required maxlength="255"
                                       @if($operation === 'create') placeholder="e.g. New Member Registration Form" @endif>
                                @error('title') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                @if($operation === 'create')
                                <div class="form-text">This title will also be used as the Google Drive folder name.</div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                          id="description" name="description" rows="3"
                                          @if($operation === 'create') placeholder="Describe the purpose of this form or any filling instructions..." @endif
                                          maxlength="2000">{{ old('description', $form?->description) }}</textarea>
                                @error('description') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-3">
                                <label for="confirmationMessage" class="form-label">Confirmation Message</label>
                                <textarea class="form-control" id="confirmationMessage" name="confirmationMessage"
                                          rows="2" maxlength="1000">{{ old('confirmationMessage', $form?->confirmationMessage ?? 'Thank you! Your response has been received. A confirmation has been sent to your email.') }}</textarea>
                                <div class="form-text">Shown to the respondent after a successful submission (when no redirect URL is set).</div>
                            </div>

                            <div class="mb-0">
                                <label for="redirectUrl" class="form-label">Redirect URL <span class="text-muted small">(Optional)</span></label>
                                <input type="url" class="form-control @error('redirectUrl') is-invalid @enderror"
                                       id="redirectUrl" name="redirectUrl"
                                       value="{{ old('redirectUrl', $form?->redirectUrl) }}" maxlength="500"
                                       placeholder="https://...">
                                @error('redirectUrl') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                <div class="form-text">If set, respondents are redirected here after submitting instead of seeing the confirmation message.</div>
                            </div>
                        </div>

                        {{-- Right: Rules + GDrive / Collaborators --}}
                        <div class="col-md-4">
                            <h5 class="section-title"><i class="fas fa-cog me-2"></i>Submission Rules</h5>

                            <div class="mb-3">
                                <label for="maxSubmission" class="form-label">Max. Submissions</label>
                                <input type="number" class="form-control" id="maxSubmission" name="maxSubmission"
                                       value="{{ old('maxSubmission', $form?->maxSubmission) }}" min="1"
                                       placeholder="Leave blank = unlimited">
                            </div>

                            <div class="mb-3">
                                <label class="form-label d-block">Multiple Submissions</label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch"
                                           id="isMultipleSubmit" name="isMultipleSubmit" value="1"
                                           {{ old('isMultipleSubmit', $form?->isMultipleSubmit ?? false) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="isMultipleSubmit">
                                        Allow respondents to submit more than once
                                    </label>
                                </div>
                                <div class="form-text">Off = only one submission allowed per email address (requires an email field).</div>
                            </div>

                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="text" class="form-control flatpickr-datetime" id="startDate" name="startDate"
                                       value="{{ old('startDate', $form?->startDate?->format('Y-m-d H:i')) }}"
                                       placeholder="dd/mm/yyyy HH:MM" autocomplete="off">
                                @if($operation === 'create')
                                <div class="form-text">Leave blank = active immediately upon publishing.</div>
                                @endif
                            </div>

                            <div class="mb-4">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="text" class="form-control flatpickr-datetime" id="endDate" name="endDate"
                                       value="{{ old('endDate', $form?->endDate?->format('Y-m-d H:i')) }}"
                                       placeholder="dd/mm/yyyy HH:MM" autocomplete="off">
                                @if($operation === 'create')
                                <div class="form-text">Leave blank = no time limit.</div>
                                @endif
                            </div>

                            @if($operation === 'create')
                            <h5 class="section-title"><i class="fab fa-google-drive me-2"></i>Google Drive</h5>
                            <div class="alert alert-info gdrive-info-alert py-2 px-3 mb-3" style="font-size:.8rem;border-radius:8px;">
                                <i class="fa fa-info-circle me-1"></i>
                                The Google Drive folder used to store the spreadsheet and attachment files will be created automatically using the service account
                                — add your email as a collaborator below to gain access.
                            </div>
                            @else
                            <h5 class="section-title"><i class="fab fa-google-drive me-2"></i>Collaborators</h5>
                            @endif

                            <div class="mb-0">
                                <label for="collaboratorEmails" class="form-label">Collaborator Emails</label>
                                <textarea class="form-control" id="collaboratorEmails" name="collaboratorEmails"
                                          rows="{{ $operation === 'create' ? 3 : 4 }}"
                                          placeholder="email1@gmail.com, email2@gmail.com"
                                          style="font-size:.85rem;">{{ old('collaboratorEmails', $form ? implode(', ', $form->collaboratorEmails ?? []) : '') }}</textarea>
                                @if($operation === 'create')
                                <div class="form-text">Separate with commas. They receive Editor access to the GDrive folder.</div>
                                @else
                                <div class="form-text">Added emails receive GDrive Editor access. Removed emails have their access revoked.</div>
                                @endif
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            {{-- Actions --}}
            <div class="row mb-4">
                <div class="col-12 d-flex justify-content-end gap-2">
                    @if($operation === 'create')
                    <a href="{{ route('admin.forms.index') }}" class="btn btn-danger">
                        <i class="fa fa-times me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-custom-primary" id="btnCreate">
                        <i class="fa fa-plus-circle me-1"></i> Create Form & Setup GDrive
                    </button>
                    @else
                    <a href="{{ route('admin.forms.index') }}" class="btn btn-danger">
                        <i class="fa fa-times me-1"></i> Cancel
                    </a>
                    <button type="submit" class="btn btn-custom-primary" id="btnSave">
                        <i class="fa fa-save me-1"></i> Save Changes
                    </button>
                    @endif
                </div>
            </div>

        </form>
        @endif
        {{-- ===================== END CREATE / EDIT MODE ===================== --}}

    </div>
</div>
