@extends('admin-page.template.body')

@section('styles')
<style>
/* ===== BUILDER LAYOUT ===== */
.builder-wrap {
    display: grid;
    grid-template-columns: 260px 1fr 280px;
    gap: 1.25rem;
    align-items: start;
}
@media (max-width: 1199px) {
    .builder-wrap { grid-template-columns: 1fr; }
    .builder-sidebar-right { order: -1; }
}

/* ===== PANEL CARD ===== */
.panel-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0,0,0,.06);
    overflow: hidden;
}
.panel-header {
    padding: .85rem 1.1rem;
    background: #f9fafb;
    border-bottom: 1px solid #e5e7eb;
    font-weight: 700;
    font-size: .85rem;
    color: #374151;
    display: flex;
    align-items: center;
    gap: .5rem;
}
.panel-body { padding: .85rem; }

/* ===== FIELD TYPE PALETTE ===== */
.field-type-group { margin-bottom: .85rem; }
.field-type-group-label {
    font-size: .7rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: .05em;
    color: #9ca3af;
    padding: 0 .35rem .4rem;
    border-bottom: 1px solid #f3f4f6;
    margin-bottom: .4rem;
}
.field-type-btn {
    display: flex;
    align-items: center;
    gap: .6rem;
    width: 100%;
    padding: .5rem .75rem;
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 8px;
    font-size: .82rem;
    color: #374151;
    cursor: pointer;
    transition: all .15s;
    margin-bottom: .3rem;
    text-align: left;
}
.field-type-btn:hover {
    background: #f0fdf4;
    border-color: #86efac;
    color: #166534;
}
.field-type-btn i { width: 18px; text-align: center; color: #6b7280; }
.field-type-btn:hover i { color: #166534; }

/* ===== DROP ZONE ===== */
.drop-zone {
    min-height: 300px;
    padding: .5rem;
}
.drop-zone-empty {
    border: 2px dashed #d1d5db;
    border-radius: 10px;
    padding: 3rem 2rem;
    text-align: center;
    color: #9ca3af;
    background: #fafafa;
}

/* ===== FIELD CARDS ===== */
.field-card {
    background: #fff;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: .85rem 1rem;
    margin-bottom: .5rem;
    display: flex;
    align-items: flex-start;
    gap: .75rem;
    transition: all .15s;
    cursor: default;
}
.field-card:hover { border-color: #86efac; box-shadow: 0 2px 8px rgba(22,101,52,.08); }
.field-card.is-system { background: #fffbeb; border-color: #fde68a; }
.drag-handle {
    color: #d1d5db;
    cursor: grab;
    padding-top: .2rem;
    font-size: 1rem;
}
.drag-handle:active { cursor: grabbing; }
.field-card-body { flex: 1; min-width: 0; }
.field-card-label { font-weight: 600; font-size: .875rem; color: #111827; margin-bottom: .15rem; }
.field-card-type { font-size: .75rem; color: #9ca3af; }
.field-card-required { color: #ef4444; margin-left: .25rem; }
.field-card-system-badge {
    font-size: .65rem; background: #fef3c7; color: #92400e;
    border: 1px solid #fde68a; border-radius: 4px; padding: 1px 6px;
    vertical-align: middle; margin-left: .35rem;
}
.field-card-actions { display: flex; gap: .3rem; }
.field-card-actions button {
    border: none; background: none; cursor: pointer;
    color: #9ca3af; font-size: .85rem; padding: .2rem .35rem;
    border-radius: 4px; transition: all .15s;
}
.field-card-actions button:hover { color: #374151; background: #f3f4f6; }
.field-card-actions button.btn-del:hover { color: #ef4444; background: #fee2e2; }

/* ===== MODAL ===== */
.add-field-modal .modal-header { background: #f9fafb; border-bottom: 1px solid #e5e7eb; }
.add-field-modal .modal-title { font-weight: 700; font-size: .95rem; }
.field-modal-label { font-size: .75rem; font-weight: 700; text-transform: uppercase; letter-spacing: .05em; color: #6b7280; margin-bottom: .3rem; }
.options-list .option-row { display: flex; gap: .5rem; margin-bottom: .4rem; align-items: center; }
.options-list .option-row input { flex: 1; }

/* ===== SORTABLE GHOST ===== */
.sortable-ghost { opacity: .4; background: #f0fdf4 !important; border: 2px dashed #86efac !important; }
.sortable-chosen { box-shadow: 0 4px 16px rgba(0,0,0,.1); }
</style>
@endsection

@section('content')
<div class="container-fluid px-4">

    {{-- Header --}}
    <div class="d-flex align-items-center justify-content-between mb-3 flex-wrap gap-2">
        <div>
            <h4 class="mb-1"><i class="fa fa-hammer me-2 text-primary"></i>Form Builder</h4>
            <p class="text-muted mb-0" style="font-size:.875rem;">
                <a href="{{ route('admin.forms.show', $form->formID) }}">{{ $form->title }}</a>
                &nbsp;·&nbsp; v{{ $form->version }}
                &nbsp;·&nbsp;
                <span class="badge @if($form->status==='published') bg-success @elseif($form->status==='draft') bg-secondary @else bg-warning text-dark @endif">
                    {{ ucfirst($form->status) }}
                </span>
            </p>
        </div>
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ url('/form/' . $form->slug) }}" target="_blank" class="btn btn-outline-info btn-sm">
                <i class="fa fa-eye me-1"></i> Preview Form
            </a>
            <a href="{{ route('admin.forms.show', $form->formID) }}" class="btn btn-outline-secondary btn-sm">
                <i class="fa fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div id="builderAlert"></div>

    <div class="builder-wrap">

        {{-- ===== LEFT: Field Type Palette ===== --}}
        <div>
            <div class="panel-card">
                <div class="panel-header"><i class="fa fa-plus-square text-primary"></i> Tambah Field</div>
                <div class="panel-body" style="max-height: calc(100vh - 200px); overflow-y: auto;">
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
                    <span>Field Aktif</span>
                    <span class="ms-auto badge bg-light text-dark border" id="fieldCount">{{ $form->activeFields->count() }} field</span>
                </div>
                <div class="panel-body">

                    @if($form->activeFields->isEmpty())
                    <div class="drop-zone-empty" id="emptyZone">
                        <i class="fa fa-mouse-pointer fa-2x mb-2 d-block"></i>
                        Klik field di sebelah kiri untuk menambahkan pertanyaan.
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
            <div class="panel-card mb-3">
                <div class="panel-header"><i class="fab fa-google-drive text-success"></i> Google Drive</div>
                <div class="panel-body">
                    @if($form->gdriveSpreadsheetUrl)
                    <a href="{{ $form->gdriveSpreadsheetUrl }}" target="_blank"
                       class="btn btn-outline-success btn-sm w-100 mb-2">
                        <i class="fa fa-table me-1"></i> Lihat Spreadsheet
                    </a>
                    @endif
                    @if($form->gdriveAttachmentsFolderUrl)
                    <a href="{{ $form->gdriveAttachmentsFolderUrl }}" target="_blank"
                       class="btn btn-outline-secondary btn-sm w-100">
                        <i class="fa fa-folder me-1"></i> Folder Attachments
                    </a>
                    @endif
                </div>
            </div>

            <div class="panel-card">
                <div class="panel-header"><i class="fa fa-info-circle text-muted"></i> Tips</div>
                <div class="panel-body" style="font-size:.8rem; color:#6b7280; line-height:1.6;">
                    <p class="mb-2"><i class="fa fa-lock fa-xs me-1 text-warning"></i> <strong>Kolom email</strong> tidak dapat dihapus — wajib ada di setiap form.</p>
                    <p class="mb-2"><i class="fa fa-arrows-alt fa-xs me-1"></i> Drag-drop untuk mengubah urutan field.</p>
                    <p class="mb-0"><i class="fa fa-save fa-xs me-1"></i> Perubahan tersimpan otomatis ke database.</p>
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
                    Tambah Field: <span id="modalFieldTypeLabel"></span>
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="modalFieldType">
                <input type="hidden" id="modalFormID" value="{{ $form->formID }}">

                <div class="row g-3">
                    <div class="col-12">
                        <label class="field-modal-label">Label / Pertanyaan <span style="color:#ef4444">*</span></label>
                        <input type="text" class="form-control" id="modalLabel" placeholder="Contoh: Nama Lengkap" maxlength="500">
                    </div>
                    <div class="col-md-6">
                        <label class="field-modal-label">Placeholder</label>
                        <input type="text" class="form-control" id="modalPlaceholder" placeholder="Contoh: Masukkan nama kamu" maxlength="255">
                    </div>
                    <div class="col-md-6">
                        <label class="field-modal-label">Teks Bantuan (Help Text)</label>
                        <input type="text" class="form-control" id="modalHelpText" placeholder="Opsional — petunjuk di bawah field" maxlength="500">
                    </div>
                    <div class="col-12">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="modalIsRequired">
                            <label class="form-check-label" for="modalIsRequired">
                                Wajib diisi
                            </label>
                        </div>
                    </div>

                    {{-- Options section (shown only for choice fields) --}}
                    <div class="col-12" id="optionsSection" style="display:none;">
                        <label class="field-modal-label">Pilihan Opsi <span style="color:#ef4444">*</span></label>
                        <div id="optionsList">
                            <div class="options-list">
                                <div class="option-row">
                                    <input type="text" class="form-control form-control-sm option-input" placeholder="Opsi 1" />
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeOption(this)">×</button>
                                </div>
                                <div class="option-row">
                                    <input type="text" class="form-control form-control-sm option-input" placeholder="Opsi 2" />
                                    <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeOption(this)">×</button>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-secondary mt-1" onclick="addOption()">
                            <i class="fa fa-plus me-1"></i> Tambah Opsi
                        </button>
                    </div>

                    {{-- File validation --}}
                    <div class="col-12" id="fileSection" style="display:none;">
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label class="field-modal-label">Ukuran Maks. (KB)</label>
                                <input type="number" class="form-control form-control-sm" id="modalMaxSizeKB" placeholder="5120" min="1">
                            </div>
                            <div class="col-md-6">
                                <label class="field-modal-label">Tipe File Diterima</label>
                                <input type="text" class="form-control form-control-sm" id="modalAcceptedTypes" placeholder="pdf,doc,docx">
                                <div style="font-size:.75rem;color:#9ca3af;margin-top:.2rem;">Pisahkan dengan koma, tanpa titik.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-primary" id="btnAddField" onclick="submitAddField()">
                    <i class="fa fa-plus me-1"></i> Tambahkan Field
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
                            <label class="form-check-label" for="editIsRequired">Wajib diisi</label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-warning" onclick="submitEditField()">
                    <i class="fa fa-save me-1"></i> Simpan
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
{{-- SortableJS for drag-drop reordering --}}
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>

<script>
const FORM_ID      = {{ $form->formID }};
const CSRF_TOKEN   = document.querySelector('meta[name="csrf-token"]').content;
const FIELD_TYPES  = @json($fieldTypes);
const CHOICE_TYPES = ['dropdown', 'radio', 'checkbox'];
const FILE_TYPES   = ['file', 'image'];

// ===== SORTABLE =====
const dropZone = document.getElementById('fieldDropZone');
Sortable.create(dropZone, {
    handle:       '.drag-handle',
    animation:    150,
    ghostClass:   'sortable-ghost',
    chosenClass:  'sortable-chosen',
    onEnd: function() {
        saveFieldOrder();
    }
});

function saveFieldOrder() {
    const cards = dropZone.querySelectorAll('.field-card[data-field-id]');
    const order = Array.from(cards).map(c => parseInt(c.dataset.fieldId));

    fetch(`/admin/forms/${FORM_ID}/fields/reorder`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ order })
    }).catch(err => showAlert('danger', 'Gagal menyimpan urutan: ' + err.message));
}

// ===== ADD FIELD MODAL =====
function openAddFieldModal(type, label) {
    document.getElementById('modalFieldType').value = type;
    document.getElementById('modalFieldTypeLabel').textContent = label;
    document.getElementById('modalLabel').value = '';
    document.getElementById('modalPlaceholder').value = '';
    document.getElementById('modalHelpText').value = '';
    document.getElementById('modalIsRequired').checked = false;

    // Show/hide conditional sections
    document.getElementById('optionsSection').style.display = CHOICE_TYPES.includes(type) ? '' : 'none';
    document.getElementById('fileSection').style.display    = FILE_TYPES.includes(type)   ? '' : 'none';

    new bootstrap.Modal(document.getElementById('addFieldModal')).show();
}

function submitAddField() {
    const type       = document.getElementById('modalFieldType').value;
    const label      = document.getElementById('modalLabel').value.trim();
    const placeholder= document.getElementById('modalPlaceholder').value.trim();
    const helpText   = document.getElementById('modalHelpText').value.trim();
    const isRequired = document.getElementById('modalIsRequired').checked;

    if (!label) {
        document.getElementById('modalLabel').focus();
        return;
    }

    const body = { fieldType: type, label, placeholder, helpText, isRequired };

    // Collect options for choice fields
    if (CHOICE_TYPES.includes(type)) {
        const inputs = document.querySelectorAll('.option-input');
        body.options = Array.from(inputs)
            .map(i => i.value.trim())
            .filter(v => v.length > 0)
            .map(v => ({ label: v, value: v }));
    }

    // Collect file validation
    if (FILE_TYPES.includes(type)) {
        const maxSizeKB    = parseInt(document.getElementById('modalMaxSizeKB').value);
        const acceptedTypes= document.getElementById('modalAcceptedTypes').value.trim();
        body.validation = {};
        if (maxSizeKB > 0)       body.validation.maxSizeKB     = maxSizeKB;
        if (acceptedTypes)       body.validation.acceptedTypes = acceptedTypes.split(',').map(s => s.trim());
    }

    const btn = document.getElementById('btnAddField');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Menambahkan...';

    fetch(`/admin/forms/${FORM_ID}/fields`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify(body)
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-plus me-1"></i> Tambahkan Field';

        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('addFieldModal')).hide();

            // Remove empty state placeholder
            const emptyZone = document.getElementById('emptyZone');
            if (emptyZone) emptyZone.remove();

            // Append the new field card HTML
            dropZone.insertAdjacentHTML('beforeend', data.html);
            updateFieldCount(1);
            showAlert('success', `Field "${label}" berhasil ditambahkan.`);
        } else {
            showAlert('danger', 'Gagal: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-plus me-1"></i> Tambahkan Field';
        showAlert('danger', 'Error: ' + err.message);
    });
}

// ===== EDIT FIELD =====
let currentEditFieldID = null;

function openEditModal(fieldID, label, placeholder, helpText, isRequired) {
    currentEditFieldID = fieldID;
    document.getElementById('editFieldID').value = fieldID;
    document.getElementById('editLabel').value       = label;
    document.getElementById('editPlaceholder').value = placeholder;
    document.getElementById('editHelpText').value    = helpText;
    document.getElementById('editIsRequired').checked= isRequired;

    new bootstrap.Modal(document.getElementById('editFieldModal')).show();
}

function submitEditField() {
    const fieldID    = currentEditFieldID;
    const label      = document.getElementById('editLabel').value.trim();
    const placeholder= document.getElementById('editPlaceholder').value.trim();
    const helpText   = document.getElementById('editHelpText').value.trim();
    const isRequired = document.getElementById('editIsRequired').checked;

    if (!label) { document.getElementById('editLabel').focus(); return; }

    fetch(`/admin/forms/${FORM_ID}/fields/${fieldID}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ label, placeholder, helpText, isRequired })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            const card = document.querySelector(`.field-card[data-field-id="${fieldID}"]`);
            if (card) {
                card.querySelector('.field-card-label').textContent = label +
                    (isRequired ? ' *' : '');
            }
            bootstrap.Modal.getInstance(document.getElementById('editFieldModal')).hide();
            showAlert('success', 'Field berhasil diperbarui.');
        } else {
            showAlert('danger', 'Gagal memperbarui field.');
        }
    })
    .catch(err => showAlert('danger', 'Error: ' + err.message));
}

// ===== REMOVE FIELD =====
function removeField(fieldID, label) {
    if (!confirm(`Yakin ingin menghapus field "${label}"?`)) return;

    fetch(`/admin/forms/${FORM_ID}/fields/${fieldID}`, {
        method: 'DELETE',
        headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            document.querySelector(`.field-card[data-field-id="${fieldID}"]`)?.remove();
            updateFieldCount(-1);
            showAlert('success', `Field "${label}" berhasil dihapus.`);
        } else {
            showAlert('danger', data.message || 'Tidak dapat menghapus field ini.');
        }
    })
    .catch(err => showAlert('danger', 'Error: ' + err.message));
}

// ===== OPTIONS HELPERS =====
function addOption() {
    const list = document.querySelector('.options-list');
    const idx  = list.querySelectorAll('.option-row').length + 1;
    const row  = document.createElement('div');
    row.className = 'option-row';
    row.innerHTML = `
        <input type="text" class="form-control form-control-sm option-input" placeholder="Opsi ${idx}">
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeOption(this)">×</button>
    `;
    list.appendChild(row);
}

function removeOption(btn) {
    const rows = document.querySelectorAll('.option-row');
    if (rows.length <= 1) return;
    btn.closest('.option-row').remove();
}

// ===== HELPERS =====
function updateFieldCount(delta) {
    const badge    = document.getElementById('fieldCount');
    const current  = parseInt(badge.textContent) + delta;
    badge.textContent = current + ' field';
}

function showAlert(type, message) {
    const el = document.getElementById('builderAlert');
    el.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show py-2 px-3" style="font-size:.875rem;">
        ${message}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>`;
    setTimeout(() => el.innerHTML = '', 4000);
}
</script>
@endsection
