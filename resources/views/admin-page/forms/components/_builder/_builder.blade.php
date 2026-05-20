<div class="container-fluid pt-4 px-4">
    <div class="row p-2 bg-light rounded justify-content-center mx-0">

        {{-- Page Title --}}
        <div class="col-12 text-center">
            <h1 class="page-title">
                <i class="fa fa-hammer me-2"></i>
                <span>Form</span>
                <span class="highlighted-text ms-1">Builder</span>
                <small class="d-block mt-2">{{ $form->title }}</small>
            </h1>
        </div>

        {{-- Breadcrumb + Actions --}}
        <div class="col-12 d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <p class="text-muted mb-0" style="font-size:.875rem;">
                <a href="{{ route('admin.forms.show', $form->formID) }}">{{ Str::limit($form->title, 40) }}</a>
                &nbsp;·&nbsp; v{{ $form->version }}
                &nbsp;·&nbsp;
                <span class="badge @if($form->status==='published') bg-success @elseif($form->status==='draft') bg-secondary @else bg-warning text-dark @endif">
                    {{ ucfirst($form->status) }}
                </span>
            </p>
            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ url('/form/' . $form->slug) }}" target="_blank" class="btn btn-outline-info btn-sm">
                    <i class="fa fa-eye me-1"></i> Preview Form
                </a>
                <a href="{{ route('admin.forms.show', $form->formID) }}" class="btn btn-outline-secondary btn-sm">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

        {{-- Alert zone --}}
        <div class="col-12 mb-2" id="builderAlertWrap" style="display:none;">
            <div id="builderAlert"></div>
        </div>

        {{-- Builder Grid --}}
        <div class="col-12">
            <div class="builder-wrap">

                {{-- ===== LEFT: Field Type Palette ===== --}}
                <div>
                    <div class="panel-card">
                        <div class="panel-header"><i class="fa fa-plus-square text-primary"></i> Add Field</div>
                        <div class="panel-body" style="max-height: calc(100vh - 220px); overflow-y: auto;">
                            @php
                                $groups = collect($fieldTypes)->groupBy('group');
                            @endphp

                            @foreach($groups as $groupName => $types)
                            <div class="field-type-group">
                                <div class="field-type-group-label">{{ $groupName }}</div>
                                @foreach($types as $type)
                                <button type="button" class="field-type-btn"
                                        data-type="{{ $type['type'] }}"
                                        data-label="{{ $type['label'] }}"
                                        onclick="openAddFieldModal('{{ $type['type'] }}', '{{ $type['label'] }}')">
                                    <i class="fa {{ $type['icon'] }}"></i>
                                    {{ $type['label'] }}
                                </button>
                                @endforeach
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- ===== MIDDLE: Drop Zone ===== --}}
                <div>
                    <div class="panel-card">
                        <div class="panel-header">
                            <i class="fa fa-list text-info"></i>
                            <span>Active Fields</span>
                            <span class="ms-auto badge bg-light text-dark border" id="fieldCount">{{ $form->activeFields->count() }} fields</span>
                        </div>
                        <div class="panel-body">

                            @if($form->activeFields->isEmpty())
                            <div class="drop-zone-empty" id="emptyZone">
                                <i class="fa fa-mouse-pointer fa-2x mb-2 d-block"></i>
                                Click a field type on the left to add questions.
                            </div>
                            @endif

                            <div id="fieldDropZone" class="drop-zone">
                                @foreach($form->activeFields as $field)
                                @include('admin-page.forms.components._field-card', ['field' => $field])
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>

                {{-- ===== RIGHT: Settings panel ===== --}}
                <div class="builder-sidebar-right">

                    {{-- Google Drive --}}
                    <div class="panel-card mb-3">
                        <div class="panel-header"><i class="fab fa-google-drive text-success"></i> Google Drive</div>
                        @if($form->gdriveSpreadsheetUrl || $form->gdriveAttachmentsFolderUrl)
                            @if($form->gdriveSpreadsheetUrl)
                            <a href="{{ $form->gdriveSpreadsheetUrl }}" target="_blank" class="gdrive-link-row">
                                <i class="fas fa-table" style="color:#34d399;"></i>
                                <span class="glr-text">
                                    <strong>Responses Spreadsheet</strong>
                                    <small>All submissions are written here as rows.</small>
                                </span>
                                <i class="fas fa-external-link-alt glr-ext"></i>
                            </a>
                            @endif
                            @if($form->gdriveAttachmentsFolderUrl)
                            <a href="{{ $form->gdriveAttachmentsFolderUrl }}" target="_blank" class="gdrive-link-row">
                                <i class="fas fa-folder" style="color:#fbbf24;"></i>
                                <span class="glr-text">
                                    <strong>Attachments Folder</strong>
                                    <small>Uploaded files from respondents are stored here.</small>
                                </span>
                                <i class="fas fa-external-link-alt glr-ext"></i>
                            </a>
                            @endif
                        @else
                        <div class="panel-body">
                            <p class="text-muted mb-0" style="font-size:.8rem;">
                                <i class="fa fa-info-circle me-1"></i>
                                Google Drive not yet configured.
                            </p>
                        </div>
                        @endif
                    </div>

                    {{-- Tips --}}
                    <div class="panel-card">
                        <div class="panel-header"><i class="fa fa-info-circle text-muted"></i> Tips</div>
                        <div class="panel-body" style="font-size:.8rem; color:#6b7280; line-height:1.6;">
                            <p class="mb-2"><i class="fa fa-lock fa-xs me-1 text-warning"></i> <strong>Email field</strong> cannot be removed — it is required on every form.</p>
                            <p class="mb-2"><i class="fa fa-arrows-alt fa-xs me-1"></i> Drag and drop to reorder fields.</p>
                            <p class="mb-0"><i class="fa fa-save fa-xs me-1"></i> Changes are saved automatically to the database.</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

{{-- ===== ADD FIELD MODAL ===== --}}
<div class="modal fade add-field-modal" id="addFieldModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="fa fa-plus-square me-2 text-primary"></i>
                    Add Field: <span id="modalFieldTypeLabel"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modalFieldType">
                <input type="hidden" id="modalFormID" value="{{ $form->formID }}">

                <div class="row g-3">
                    <div class="col-12">
                        <label class="field-modal-label">Label / Question <span style="color:#ef4444">*</span></label>
                        <input type="text" class="form-control" id="modalLabel" placeholder="e.g. Full Name" maxlength="500">
                    </div>
                    <div class="col-md-6">
                        <label class="field-modal-label">Placeholder</label>
                        <input type="text" class="form-control" id="modalPlaceholder" placeholder="e.g. Enter your name" maxlength="255">
                    </div>
                    <div class="col-md-6">
                        <label class="field-modal-label">Help Text</label>
                        <input type="text" class="form-control" id="modalHelpText" placeholder="Optional — hint shown below the field" maxlength="500">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="modalIsRequired">
                            <label class="form-check-label" for="modalIsRequired">Required</label>
                        </div>
                    </div>

                    {{-- Options section (shown only for choice fields) --}}
                    <div class="col-12" id="optionsSection" style="display:none;">
                        <label class="field-modal-label">Options <span style="color:#ef4444">*</span></label>
                        <div id="optionsList">
                            <div class="options-list">
                                <div class="option-row">
                                    <input type="text" class="form-control form-control-sm option-input" placeholder="Option 1" />
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeOption(this)">×</button>
                                </div>
                                <div class="option-row">
                                    <input type="text" class="form-control form-control-sm option-input" placeholder="Option 2" />
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeOption(this)">×</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="addOption()">
                            <i class="fa fa-plus me-1"></i> Add Option
                        </button>
                    </div>

                    {{-- File validation --}}
                    <div class="col-12" id="fileSection" style="display:none;">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="field-modal-label">Max Size (KB)</label>
                                <input type="number" class="form-control form-control-sm" id="modalMaxSizeKB" placeholder="5120" min="1">
                            </div>
                            <div class="col-md-6">
                                <label class="field-modal-label">Accepted File Types</label>
                                <input type="text" class="form-control form-control-sm" id="modalAcceptedTypes" placeholder="pdf,doc,docx">
                                <div style="font-size:.75rem;color:#9ca3af;margin-top:.2rem;">Comma-separated, without dots.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-custom-primary" id="btnAddField" onclick="submitAddField()"
                        style="background:#00a79d;border-color:#00a79d;color:#fff;">
                    <i class="fa fa-plus me-1"></i> Add Field
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ===== EDIT FIELD MODAL ===== --}}
<div class="modal fade" id="editFieldModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa fa-edit me-2 text-warning"></i>Edit Field</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="editFieldID">
                <div class="row g-3">
                    <div class="col-12">
                        <label class="field-modal-label">Label <span style="color:#ef4444">*</span></label>
                        <input type="text" class="form-control" id="editLabel" maxlength="500">
                    </div>
                    <div class="col-md-6">
                        <label class="field-modal-label">Placeholder</label>
                        <input type="text" class="form-control" id="editPlaceholder" maxlength="255">
                    </div>
                    <div class="col-md-6">
                        <label class="field-modal-label">Help Text</label>
                        <input type="text" class="form-control" id="editHelpText" maxlength="500">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="editIsRequired">
                            <label class="form-check-label" for="editIsRequired">Required</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-warning" onclick="submitEditField()">
                    <i class="fa fa-save me-1"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
