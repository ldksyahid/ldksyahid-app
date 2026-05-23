<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const FORM_ID      = {{ $form->formID }};
const CSRF_TOKEN   = document.querySelector('meta[name="csrf-token"]').content;
const FIELD_TYPES  = @json($fieldTypes);
const CHOICE_TYPES = ['dropdown', 'radio', 'checkbox'];
const FILE_TYPES   = ['file', 'image'];

// ===== SORTABLE =====
const dropZone = document.getElementById('fieldDropZone');
Sortable.create(dropZone, {
    handle:      '.drag-handle',
    animation:   150,
    ghostClass:  'sortable-ghost',
    chosenClass: 'sortable-chosen',
    onMove: function(evt) {
        // Prevent any field from being dragged past a system field (locks its position)
        if (evt.related.classList.contains('is-system')) return false;
    },
    onEnd: function() { saveFieldOrder(); }
});

function saveFieldOrder() {
    const cards = dropZone.querySelectorAll('.field-card[data-field-id]');
    const order = Array.from(cards).map(c => parseInt(c.dataset.fieldId));

    fetch(`/admin/forms/${FORM_ID}/fields/reorder`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify({ order })
    }).catch(err => showAlert('danger', 'Failed to save order: ' + err.message));
}

// ===== ADD FIELD MODAL =====
function openAddFieldModal(type, label) {
    document.getElementById('modalFieldType').value = type;
    document.getElementById('modalFieldTypeLabel').textContent = label;
    document.getElementById('modalLabel').value = '';
    document.getElementById('modalPlaceholder').value = '';
    document.getElementById('modalHelpText').value = '';
    document.getElementById('modalIsRequired').checked = false;

    // Reset options list to 2 empty rows
    const optionsList = document.querySelector('#optionsList .options-list');
    optionsList.innerHTML = `
        <div class="option-row">
            <input type="text" class="form-control form-control-sm option-input" placeholder="Option 1" />
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeOption(this)">×</button>
        </div>
        <div class="option-row">
            <input type="text" class="form-control form-control-sm option-input" placeholder="Option 2" />
            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeOption(this)">×</button>
        </div>`;

    // Reset file validation fields
    document.getElementById('modalMaxSizeKB').value = '';
    document.getElementById('modalAcceptedTypes').value = '';

    document.getElementById('optionsSection').style.display = CHOICE_TYPES.includes(type) ? '' : 'none';
    document.getElementById('fileSection').style.display    = FILE_TYPES.includes(type)   ? '' : 'none';

    new bootstrap.Modal(document.getElementById('addFieldModal')).show();
}

function submitAddField() {
    const type        = document.getElementById('modalFieldType').value;
    const label       = document.getElementById('modalLabel').value.trim();
    const placeholder = document.getElementById('modalPlaceholder').value.trim();
    const helpText    = document.getElementById('modalHelpText').value.trim();
    const isRequired  = document.getElementById('modalIsRequired').checked;

    if (!label) {
        document.getElementById('modalLabel').focus();
        return;
    }

    const body = { fieldType: type, label, placeholder, helpText, isRequired };

    if (CHOICE_TYPES.includes(type)) {
        const inputs = document.querySelectorAll('.option-input');
        body.options = Array.from(inputs)
            .map(i => i.value.trim())
            .filter(v => v.length > 0)
            .map(v => ({ label: v, value: v }));
    }

    if (FILE_TYPES.includes(type)) {
        const maxSizeKB     = parseInt(document.getElementById('modalMaxSizeKB').value);
        const acceptedTypes = document.getElementById('modalAcceptedTypes').value.trim();
        body.validation = {};
        if (maxSizeKB > 0)  body.validation.maxSizeKB     = maxSizeKB;
        if (acceptedTypes)  body.validation.acceptedTypes = acceptedTypes.split(',').map(s => s.trim());
    }

    const btn = document.getElementById('btnAddField');
    btn.disabled = true;
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Adding...';

    fetch(`/admin/forms/${FORM_ID}/fields`, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify(body)
    })
    .then(r => r.json())
    .then(data => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-plus me-1"></i> Add Field';

        if (data.success) {
            bootstrap.Modal.getInstance(document.getElementById('addFieldModal')).hide();

            const emptyZone = document.getElementById('emptyZone');
            if (emptyZone) emptyZone.remove();

            dropZone.insertAdjacentHTML('beforeend', data.html);
            updateFieldCount(1);
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: `Field "${label}" added successfully.`, showConfirmButton: false, timer: 2500, timerProgressBar: true });
        } else {
            showAlert('danger', 'Failed: ' + (data.message || 'Unknown error'));
        }
    })
    .catch(err => {
        btn.disabled = false;
        btn.innerHTML = '<i class="fa fa-plus me-1"></i> Add Field';
        showAlert('danger', 'Error: ' + err.message);
    });
}

// ===== EDIT FIELD =====
let currentEditCard = null;

function openEditModal(btn) {
    const card        = btn.closest('.field-card');
    currentEditCard   = card;
    const fieldType   = card.dataset.fieldType;
    const label       = card.dataset.label;
    const placeholder = card.dataset.placeholder;
    const helpText    = card.dataset.helpText;
    const isRequired  = card.dataset.isRequired === '1';
    const options     = JSON.parse(card.dataset.options  || '[]');
    const validation  = JSON.parse(card.dataset.validation || '{}');

    const isDisplay = ['section_break', 'paragraph'].includes(fieldType);

    document.getElementById('editFieldID').value      = card.dataset.fieldId;
    document.getElementById('editLabel').value        = label;
    document.getElementById('editPlaceholder').value  = placeholder;
    document.getElementById('editHelpText').value     = helpText;
    document.getElementById('editIsRequired').checked = isRequired;

    // Hide placeholder for display-only types (section_break, paragraph)
    document.getElementById('editPlaceholderWrap').style.display = isDisplay ? 'none' : '';

    // Show / hide options section
    const isChoice = CHOICE_TYPES.includes(fieldType);
    document.getElementById('editOptionsSection').style.display = isChoice ? '' : 'none';
    if (isChoice) {
        const listEl = document.getElementById('editOptionsListInner');
        listEl.innerHTML = '';
        const opts = options.length ? options : [{label:'', value:''}, {label:'', value:''}];
        opts.forEach((opt, idx) => {
            const val = opt.label ?? opt.value ?? opt ?? '';
            const row = document.createElement('div');
            row.className = 'option-row';
            row.innerHTML = `
                <input type="text" class="form-control form-control-sm edit-option-input" value="${val.replace(/"/g,'&quot;')}" placeholder="Option ${idx + 1}">
                <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeEditOption(this)">×</button>`;
            listEl.appendChild(row);
        });
    }

    // Show / hide file section
    const isFile = FILE_TYPES.includes(fieldType);
    document.getElementById('editFileSection').style.display = isFile ? '' : 'none';
    if (isFile) {
        document.getElementById('editMaxSizeKB').value     = validation?.maxSizeKB ?? '';
        document.getElementById('editAcceptedTypes').value = (validation?.acceptedTypes ?? []).join(',');
    }

    new bootstrap.Modal(document.getElementById('editFieldModal')).show();
}

function addEditOption() {
    const list = document.getElementById('editOptionsListInner');
    const idx  = list.querySelectorAll('.option-row').length + 1;
    const row  = document.createElement('div');
    row.className = 'option-row';
    row.innerHTML = `
        <input type="text" class="form-control form-control-sm edit-option-input" placeholder="Option ${idx}">
        <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeEditOption(this)">×</button>`;
    list.appendChild(row);
}

function removeEditOption(btn) {
    const rows = document.querySelectorAll('#editOptionsListInner .option-row');
    if (rows.length <= 1) return;
    btn.closest('.option-row').remove();
}

function submitEditField() {
    const fieldID     = document.getElementById('editFieldID').value;
    const fieldType   = currentEditCard?.dataset.fieldType ?? '';
    const label       = document.getElementById('editLabel').value.trim();
    const placeholder = document.getElementById('editPlaceholder').value.trim();
    const helpText    = document.getElementById('editHelpText').value.trim();
    const isRequired  = document.getElementById('editIsRequired').checked;

    if (!label) { document.getElementById('editLabel').focus(); return; }

    const body = { label, placeholder, helpText, isRequired };

    if (CHOICE_TYPES.includes(fieldType)) {
        body.options = Array.from(document.querySelectorAll('.edit-option-input'))
            .map(i => i.value.trim()).filter(v => v.length > 0)
            .map(v => ({ label: v, value: v }));
    }

    if (FILE_TYPES.includes(fieldType)) {
        const maxSizeKB     = parseInt(document.getElementById('editMaxSizeKB').value);
        const acceptedTypes = document.getElementById('editAcceptedTypes').value.trim();
        body.validation = {};
        if (maxSizeKB > 0) body.validation.maxSizeKB     = maxSizeKB;
        if (acceptedTypes) body.validation.acceptedTypes = acceptedTypes.split(',').map(s => s.trim());
    }

    fetch(`/admin/forms/${FORM_ID}/fields/${fieldID}`, {
        method: 'PUT',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
        body: JSON.stringify(body)
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            if (currentEditCard) {
                // Sync data-* attributes for next open
                currentEditCard.dataset.label      = label;
                currentEditCard.dataset.placeholder = placeholder;
                currentEditCard.dataset.helpText    = helpText;
                currentEditCard.dataset.isRequired  = isRequired ? '1' : '0';
                if (body.options !== undefined)    currentEditCard.dataset.options    = JSON.stringify(body.options);
                if (body.validation !== undefined) currentEditCard.dataset.validation = JSON.stringify(body.validation);

                // Refresh visible label
                const labelDiv = currentEditCard.querySelector('.field-card-label');
                const icon     = labelDiv.querySelector('i');
                const required = isRequired ? '<span class="field-card-required">*</span>' : '';
                const badge    = labelDiv.querySelector('.field-card-system-badge')?.outerHTML ?? '';
                labelDiv.innerHTML = (icon?.outerHTML ?? '') + ' ' + label + ' ' + required + badge;
            }
            bootstrap.Modal.getInstance(document.getElementById('editFieldModal')).hide();
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Field updated successfully.', showConfirmButton: false, timer: 2500, timerProgressBar: true });
        } else {
            showAlert('danger', 'Failed to update field.');
        }
    })
    .catch(err => showAlert('danger', 'Error: ' + err.message));
}

// ===== REMOVE FIELD =====
function removeField(btn) {
    const card    = btn.closest('.field-card');
    const fieldID = card.dataset.fieldId;
    const label   = card.dataset.label;

    Swal.fire({
        title: 'Remove this field?',
        html: `Field <strong>"${label}"</strong> will be permanently removed from this form.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, remove it',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (!result.isConfirmed) return;

        fetch(`/admin/forms/${FORM_ID}/fields/${fieldID}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                card.remove();
                updateFieldCount(-1);
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: `Field "${label}" removed.`, showConfirmButton: false, timer: 2500, timerProgressBar: true });
            } else {
                showAlert('danger', data.message || 'Cannot remove this field.');
            }
        })
        .catch(err => showAlert('danger', 'Error: ' + err.message));
    });
}

// ===== OPTIONS HELPERS =====
function addOption() {
    const list = document.querySelector('.options-list');
    const idx  = list.querySelectorAll('.option-row').length + 1;
    const row  = document.createElement('div');
    row.className = 'option-row';
    row.innerHTML = `
        <input type="text" class="form-control form-control-sm option-input" placeholder="Option ${idx}">
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
    const badge   = document.getElementById('fieldCount');
    const current = parseInt(badge.textContent) + delta;
    badge.textContent = current + ' fields';
}

function showAlert(type, message) {
    const wrap = document.getElementById('builderAlertWrap');
    const el   = document.getElementById('builderAlert');
    wrap.style.display = '';
    el.innerHTML = `<div class="alert alert-${type} alert-dismissible fade show py-2 px-3" style="font-size:.875rem;">
        ${message}
        <button type="button" class="btn-close btn-sm" data-bs-dismiss="alert"></button>
    </div>`;
    setTimeout(() => { el.innerHTML = ''; wrap.style.display = 'none'; }, 4000);
}
</script>
