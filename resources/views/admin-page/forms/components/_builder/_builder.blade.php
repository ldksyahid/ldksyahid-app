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

        {{-- Alert zone --}}
        <div class="col-12 mb-2" id="builderAlertWrap" style="display:none;">
            <div id="builderAlert"></div>
        </div>

        {{-- Main Builder Card --}}
        <div class="col-12 mb-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">

                    {{-- Breadcrumb + Preview button --}}
                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4 builder-card-header">
                        <p class="text-muted mb-0" style="font-size:.875rem;">
                            <a href="{{ route('admin.forms.show', $form->formID) }}">{{ Str::limit($form->title, 40) }}</a>
                            &nbsp;·&nbsp; v{{ $form->version }}
                            &nbsp;·&nbsp;
                            <span class="badge @if($form->status==='published') bg-success @elseif($form->status==='draft') bg-secondary @else bg-warning text-dark @endif">
                                {{ ucfirst($form->status) }}
                            </span>
                        </p>
                        <a href="{{ url('/form/' . $form->slug) }}" target="_blank" class="btn-preview-form">
                            <i class="fa fa-eye"></i>
                            <span>Preview Form</span>
                            <i class="fa fa-external-link-alt btn-preview-ext"></i>
                        </a>
                    </div>

                    {{-- Builder Grid --}}
                    <div class="builder-wrap">

                {{-- ===== LEFT: Field Type Palette ===== --}}
                <div>
                    <div class="card border-0 shadow-sm">
                        <div class="card-body" style="max-height: calc(100vh - 220px); overflow-y: auto;">
                            <h5 class="section-title"><i class="fa fa-plus-square me-2"></i>Add Field</h5>
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
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <div class="builder-fields-header">
                                <div class="d-flex align-items-center justify-content-between mb-2">
                                    <span class="fw-semibold" style="font-size:1rem;"><i class="fa fa-list me-2"></i>Active Fields</span>
                                    <span class="badge bg-light text-dark border" id="fieldCount">{{ $form->activeFields->count() }} fields</span>
                                </div>
                                <div class="d-flex align-items-center gap-2 flex-wrap">
                                    <button type="button" class="btn-add-header-image" onclick="addHeaderImage()" title="Add a banner image pinned to the top of the form">
                                        <i class="fa fa-image me-1"></i> Header Image
                                    </button>
                                    <button type="button" class="btn-add-section" onclick="addSection()" title="Add a new section to split the form into pages">
                                        <i class="fa fa-columns me-1"></i> Add Section
                                    </button>
                                </div>
                            </div>

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
                    <div class="card border-0 shadow-sm mb-3">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fab fa-google-drive me-2"></i>Google Drive</h5>
                            @if($form->gdriveSpreadsheetUrl || $form->gdriveAttachmentsFolderUrl || $form->gdriveAssetsFolderUrl)
                                @php
                                    $currentUser     = auth()->user();
                                    $canAccessGdrive = ($isSuperadmin ?? false)
                                        || ($currentUser && in_array($currentUser->email, $form->collaboratorEmails ?? []));
                                @endphp
                                @if($canAccessGdrive)
                                @if($form->gdriveSpreadsheetUrl)
                                <a href="{{ $form->gdriveSpreadsheetUrl }}" target="_blank" class="gdrive-link">
                                    <i class="fas fa-table gdrive-icon text-success"></i>
                                    <span class="gdrive-text">
                                        <strong>Responses Spreadsheet</strong>
                                        <small>All submissions are written here as rows.</small>
                                    </span>
                                    <i class="fas fa-external-link-alt gdrive-ext"></i>
                                </a>
                                @endif
                                @if($form->gdriveAttachmentsFolderUrl)
                                <a href="{{ $form->gdriveAttachmentsFolderUrl }}" target="_blank" class="gdrive-link">
                                    <i class="fas fa-folder gdrive-icon text-warning"></i>
                                    <span class="gdrive-text">
                                        <strong>Attachments Folder</strong>
                                        <small>Uploaded files (file fields) are stored here.</small>
                                    </span>
                                    <i class="fas fa-external-link-alt gdrive-ext"></i>
                                </a>
                                @endif
                                @if($form->gdriveAssetsFolderUrl)
                                <a href="{{ $form->gdriveAssetsFolderUrl }}" target="_blank" class="gdrive-link">
                                    <i class="fas fa-images gdrive-icon text-info"></i>
                                    <span class="gdrive-text">
                                        <strong>Assets Folder</strong>
                                        <small>Uploaded images (image fields) are stored here.</small>
                                    </span>
                                    <i class="fas fa-external-link-alt gdrive-ext"></i>
                                </a>
                                @endif
                                @else
                                <p class="mb-0" style="font-size:.75rem; color:#6b7280;">
                                    <i class="fa fa-lock fa-xs me-1 text-warning"></i>
                                    Google Drive access is restricted to the form creator and superadmin only.
                                </p>
                                @endif
                            @else
                            <p class="text-muted mb-0" style="font-size:.8rem;">
                                <i class="fa fa-info-circle me-1"></i>
                                Google Drive not yet configured.
                            </p>
                            @endif
                        </div>
                    </div>

                    {{-- Tips --}}
                    <div class="card border-0 shadow-sm">
                        <div class="card-body">
                            <h5 class="section-title"><i class="fa fa-info-circle me-2"></i>Tips</h5>
                            <div style="font-size:.8rem; color:#6b7280; line-height:1.6;">
                                <p class="mb-2"><i class="fa fa-lock fa-xs me-1 text-warning"></i> <strong>Email field</strong> cannot be removed — it is required on every form.</p>
                                <p class="mb-2"><i class="fa fa-arrows-alt fa-xs me-1"></i> Drag and drop to reorder fields.</p>
                                <p class="mb-0"><i class="fa fa-save fa-xs me-1"></i> Changes are saved automatically to the database.</p>
                            </div>
                        </div>
                    </div>
                </div>

                    </div>{{-- end builder-wrap --}}

                </div>{{-- end card-body --}}
            </div>{{-- end card --}}
        </div>{{-- end col-12 --}}

        {{-- Bottom action bar — Back on the right --}}
        <div class="col-12 builder-bottom-bar">
            <div class="d-flex justify-content-end">
                <a href="{{ route('admin.forms.index') }}" class="btn btn-secondary">
                    <i class="fa fa-arrow-left me-1"></i> Back
                </a>
            </div>
        </div>

    </div>
</div>


{{-- ===== ADD FIELD MODAL ===== --}}
<div class="modal fade add-field-modal" id="addFieldModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bm-card">
            <div class="bm-header bm-header--add">
                <div class="bm-header-icon"><i class="fa fa-plus-square"></i></div>
                <div class="bm-header-text">
                    <div class="bm-header-title">Add New Field</div>
                    <div class="bm-header-sub" id="modalFieldTypeLabel"></div>
                </div>
                <button type="button" class="btn-close bm-btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bm-body p-0" style="overflow:hidden;">
              <div class="d-flex" style="align-items:stretch;min-height:0;">
                <div class="bmp-config-col">
                <input type="hidden" id="modalFieldType">
                <input type="hidden" id="modalFormID" value="{{ $form->formID }}">

                <div class="row g-3">
                    <div class="col-12">
                        <label class="field-modal-label" id="modalLabelText">Label / Question <span class="text-danger" id="modalLabelRequired">*</span></label>
                        <input type="text" class="form-control" id="modalLabel" placeholder="e.g. Full Name" maxlength="500">
                    </div>
                    <div class="col-md-6" id="modalPlaceholderWrap">
                        <label class="field-modal-label">Placeholder</label>
                        <input type="text" class="form-control" id="modalPlaceholder" placeholder="e.g. Enter your name" maxlength="255">
                    </div>
                    <div class="col-md-6" id="modalHelpTextWrap">
                        <label class="field-modal-label">Help Text</label>
                        <input type="text" class="form-control" id="modalHelpText" placeholder="Optional — hint shown below the field" maxlength="500">
                    </div>

                    {{-- Image file upload (shown only for image display field) --}}
                    <div class="col-12" id="imageUrlSection" style="display:none;">
                        <label class="field-modal-label">Upload Image</label>
                        <input type="file" class="form-control" id="modalImageFile" accept="image/*">
                        <div class="form-text">Max 5 MB. Image will be stored in Google Drive and displayed in the form.</div>
                    </div>
                    <div class="col-12" id="modalRequiredWrap">
                        <div class="bm-required-toggle">
                            <input class="form-check-input" type="checkbox" id="modalIsRequired">
                            <label for="modalIsRequired">Mark as Required</label>
                        </div>
                    </div>

                    {{-- Options section (shown only for choice fields) --}}
                    <div class="col-12" id="optionsSection" style="display:none;">
                        <label class="field-modal-label">Options <span class="text-danger">*</span></label>
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

                    {{-- Linear Scale config --}}
                    <div class="col-12" id="linearScaleSection" style="display:none;">
                        <label class="field-modal-label">Scale Range <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <select class="form-select form-select-sm" id="modalLinearScaleMin" style="width:80px;">
                                <option value="0">0</option>
                                <option value="1" selected>1</option>
                            </select>
                            <span class="text-muted">to</span>
                            <select class="form-select form-select-sm" id="modalLinearScaleMax" style="width:80px;">
                                @foreach([2,3,4,5,6,7,8,9,10] as $v)
                                <option value="{{ $v }}" {{ $v === 5 ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="field-modal-label text-muted" style="font-size:.78rem;">Minimum Label <small>(optional)</small></label>
                                <input type="text" class="form-control form-control-sm" id="modalLinearScaleMinLabel" placeholder="e.g. Poor" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="field-modal-label text-muted" style="font-size:.78rem;">Maximum Label <small>(optional)</small></label>
                                <input type="text" class="form-control form-control-sm" id="modalLinearScaleMaxLabel" placeholder="e.g. Excellent" maxlength="100">
                            </div>
                        </div>
                    </div>

                    {{-- Rating config --}}
                    <div class="col-12" id="ratingSection" style="display:none;">
                        <label class="field-modal-label">Number of Stars <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-3">
                            <select class="form-select form-select-sm" id="modalRatingMax" style="width:80px;"
                                onchange="updateRatingPreview('modalRatingPreview', parseInt(this.value))">
                                @foreach([3,4,5,6,7,8,9,10] as $v)
                                <option value="{{ $v }}" {{ $v === 5 ? 'selected' : '' }}>{{ $v }}</option>
                                @endforeach
                            </select>
                            <div id="modalRatingPreview" class="d-flex gap-1" style="font-size:1.3rem; color:#f5a623;">
                                @for($s = 1; $s <= 5; $s++)<i class="far fa-star"></i>@endfor
                            </div>
                        </div>
                    </div>

                    {{-- File validation --}}
                    <div class="col-12" id="fileSection" style="display:none;">
                        <div class="mb-2">
                            <label class="field-modal-label">Max Size (KB)</label>
                            <input type="number" class="form-control form-control-sm" id="modalMaxSizeKB" placeholder="e.g. 5120" min="1" style="max-width:160px;">
                        </div>
                        <label class="field-modal-label">Accepted File Types</label>
                        <div class="file-type-picker">
                            <div class="file-type-picker-group">
                                <span class="file-type-picker-cat">Images</span>
                                @foreach(['jpg','jpeg','png','gif','webp','svg'] as $ext)
                                <label class="file-type-pill"><input type="checkbox" class="modal-accept-check" value="{{ $ext }}"> {{ $ext }}</label>
                                @endforeach
                            </div>
                            <div class="file-type-picker-group">
                                <span class="file-type-picker-cat">Documents</span>
                                @foreach(['pdf','doc','docx','xls','xlsx','ppt','pptx','txt','csv'] as $ext)
                                <label class="file-type-pill"><input type="checkbox" class="modal-accept-check" value="{{ $ext }}"> {{ $ext }}</label>
                                @endforeach
                            </div>
                            <div class="file-type-picker-group">
                                <span class="file-type-picker-cat">Archives</span>
                                @foreach(['zip','rar','7z'] as $ext)
                                <label class="file-type-pill"><input type="checkbox" class="modal-accept-check" value="{{ $ext }}"> {{ $ext }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-text mt-1">Leave all unchecked to allow any file type.</div>
                    </div>
                </div>{{-- end row g-3 --}}
                </div>{{-- end bmp-config-col --}}

                {{-- ── Live Preview Panel ───────────────── --}}
                <div class="bmp-preview-col">
                    <div class="bmp-preview-header">
                        <div class="bmp-preview-header-left"><i class="fas fa-eye me-1"></i>Live Preview</div>
                        <div class="bmp-preview-tabs">
                            <button class="bmp-preview-tab active" data-view="desktop" title="Desktop">
                                <i class="fas fa-desktop"></i>
                            </button>
                            <button class="bmp-preview-tab" data-view="mobile" title="Mobile">
                                <i class="fas fa-mobile-alt"></i>
                            </button>
                        </div>
                    </div>
                    <div class="bmp-preview-view bmp-preview-view--desktop">
                        <div id="modalPreviewField" class="bmp-preview-field"></div>
                    </div>
                    <div class="bmp-preview-view bmp-preview-view--mobile" style="display:none;">
                        <div class="bmp-phone-frame">
                            <div class="bmp-phone-notch"></div>
                            <div class="bmp-phone-screen">
                                <div id="modalPreviewFieldMobile" class="bmp-preview-field bmp-preview-field--phone"></div>
                            </div>
                            <div class="bmp-phone-home"></div>
                        </div>
                    </div>
                </div>

              </div>{{-- end d-flex --}}
            </div>{{-- end bm-body --}}
            <div class="bm-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Cancel
                </button>
                <button type="button" class="bm-btn-submit bm-btn-submit--add" id="btnAddField" onclick="submitAddField()">
                    <i class="fa fa-plus me-1"></i> Add Field
                </button>
            </div>
        </div>
    </div>
</div>

{{-- ===== EDIT FIELD MODAL ===== --}}
<div class="modal fade" id="editFieldModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content bm-card">
            <div class="bm-header bm-header--edit">
                <div class="bm-header-icon"><i class="fa fa-edit"></i></div>
                <div class="bm-header-text">
                    <div class="bm-header-title" id="editModalTitle">Edit Field</div>
                    <div class="bm-header-sub" id="editModalSub">Update label, placeholder, or help text</div>
                </div>
                <button type="button" class="btn-close bm-btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body bm-body">
                <input type="hidden" id="editFieldID">
                <div class="row g-3">
                    <div class="col-12" id="editLabelWrap">
                        <label class="field-modal-label" id="editLabelText">Label <span class="text-danger" id="editLabelRequired">*</span></label>
                        <input type="text" class="form-control" id="editLabel" maxlength="500">
                    </div>
                    <div class="col-md-6" id="editPlaceholderWrap">
                        <label class="field-modal-label">Placeholder</label>
                        <input type="text" class="form-control" id="editPlaceholder" maxlength="255">
                    </div>
                    <div class="col-md-6" id="editHelpTextWrap">
                        <label class="field-modal-label">Help Text</label>
                        <input type="text" class="form-control" id="editHelpText" maxlength="500">
                    </div>

                    {{-- Image file upload (shown only for image display field) --}}
                    <div class="col-12" id="editImageUrlSection" style="display:none;">
                        <div id="editCurrentImagePreview" style="display:none; margin-bottom:10px;">
                            <p class="field-modal-label mb-1">Current image:</p>
                            <img id="editCurrentImageThumb" src="" alt="" style="max-height:120px; max-width:100%; border-radius:6px; object-fit:contain;">
                        </div>
                        <label class="field-modal-label">Replace Image <small class="text-muted">(optional)</small></label>
                        <input type="file" class="form-control" id="editImageFile" accept="image/*">
                        <div class="form-text">Leave blank to keep the current image. Max 5 MB.</div>
                    </div>

                    <div class="col-12" id="editRequiredWrap">
                        <div class="bm-required-toggle">
                            <input class="form-check-input" type="checkbox" id="editIsRequired">
                            <label for="editIsRequired">Mark as Required</label>
                        </div>
                    </div>

                    {{-- Options section (dropdown / radio / checkbox) --}}
                    <div class="col-12" id="editOptionsSection" style="display:none;">
                        <label class="field-modal-label">Options <span class="text-danger">*</span></label>
                        <div class="options-list" id="editOptionsListInner"></div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="addEditOption()">
                            <i class="fa fa-plus me-1"></i> Add Option
                        </button>
                    </div>

                    {{-- Section Routing (radio only) --}}
                    <div class="col-12" id="editSectionRoutingWrap" style="display:none;">
                        <div class="sr-panel">
                            <div class="sr-panel-header">
                                <div class="sr-panel-title">
                                    <i class="fas fa-code-branch me-1"></i>Section Routing
                                </div>
                                <label class="sr-toggle-label">
                                    <input type="checkbox" id="editRoutingEnabled" onchange="onRoutingToggle(this)">
                                    <span class="sr-toggle-track"><span class="sr-toggle-thumb"></span></span>
                                </label>
                            </div>
                            <div id="editRoutingBody" style="display:none;">
                                <p class="sr-hint">Choose which section respondents jump to based on their answer.</p>
                                <div id="editRoutingRows"></div>
                            </div>
                        </div>
                    </div>

                    {{-- Linear Scale config (edit) --}}
                    <div class="col-12" id="editLinearScaleSection" style="display:none;">
                        <label class="field-modal-label">Scale Range <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-2 mb-2">
                            <select class="form-select form-select-sm" id="editLinearScaleMin" style="width:80px;">
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                            <span class="text-muted">to</span>
                            <select class="form-select form-select-sm" id="editLinearScaleMax" style="width:80px;">
                                @foreach([2,3,4,5,6,7,8,9,10] as $v)
                                <option value="{{ $v }}">{{ $v }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="field-modal-label text-muted" style="font-size:.78rem;">Minimum Label <small>(optional)</small></label>
                                <input type="text" class="form-control form-control-sm" id="editLinearScaleMinLabel" placeholder="e.g. Poor" maxlength="100">
                            </div>
                            <div class="col-md-6">
                                <label class="field-modal-label text-muted" style="font-size:.78rem;">Maximum Label <small>(optional)</small></label>
                                <input type="text" class="form-control form-control-sm" id="editLinearScaleMaxLabel" placeholder="e.g. Excellent" maxlength="100">
                            </div>
                        </div>
                    </div>

                    {{-- Rating config (edit) --}}
                    <div class="col-12" id="editRatingSection" style="display:none;">
                        <label class="field-modal-label">Number of Stars <span class="text-danger">*</span></label>
                        <div class="d-flex align-items-center gap-3">
                            <select class="form-select form-select-sm" id="editRatingMax" style="width:80px;"
                                onchange="updateRatingPreview('editRatingPreview', parseInt(this.value))">
                                @foreach([3,4,5,6,7,8,9,10] as $v)
                                <option value="{{ $v }}">{{ $v }}</option>
                                @endforeach
                            </select>
                            <div id="editRatingPreview" class="d-flex gap-1" style="font-size:1.3rem; color:#f5a623;">
                                @for($s = 1; $s <= 5; $s++)<i class="far fa-star"></i>@endfor
                            </div>
                        </div>
                    </div>

                    {{-- File validation (file / image) --}}
                    <div class="col-12" id="editFileSection" style="display:none;">
                        <div class="mb-2">
                            <label class="field-modal-label">Max Size (KB)</label>
                            <input type="number" class="form-control form-control-sm" id="editMaxSizeKB" placeholder="e.g. 5120" min="1" style="max-width:160px;">
                        </div>
                        <label class="field-modal-label">Accepted File Types</label>
                        <div class="file-type-picker">
                            <div class="file-type-picker-group">
                                <span class="file-type-picker-cat">Images</span>
                                @foreach(['jpg','jpeg','png','gif','webp','svg'] as $ext)
                                <label class="file-type-pill"><input type="checkbox" class="edit-accept-check" value="{{ $ext }}"> {{ $ext }}</label>
                                @endforeach
                            </div>
                            <div class="file-type-picker-group">
                                <span class="file-type-picker-cat">Documents</span>
                                @foreach(['pdf','doc','docx','xls','xlsx','ppt','pptx','txt','csv'] as $ext)
                                <label class="file-type-pill"><input type="checkbox" class="edit-accept-check" value="{{ $ext }}"> {{ $ext }}</label>
                                @endforeach
                            </div>
                            <div class="file-type-picker-group">
                                <span class="file-type-picker-cat">Archives</span>
                                @foreach(['zip','rar','7z'] as $ext)
                                <label class="file-type-pill"><input type="checkbox" class="edit-accept-check" value="{{ $ext }}"> {{ $ext }}</label>
                                @endforeach
                            </div>
                        </div>
                        <div class="form-text mt-1">Leave all unchecked to allow any file type.</div>
                    </div>
                </div>
            </div>
            <div class="bm-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                    <i class="fa fa-times me-1"></i> Cancel
                </button>
                <button type="button" class="bm-btn-submit bm-btn-submit--edit" onclick="submitEditField()">
                    <i class="fa fa-save me-1"></i> Save Changes
                </button>
            </div>
        </div>
    </div>
</div>
