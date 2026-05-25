<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const FORM_ID      = {{ $form->formID }};
const CSRF_TOKEN   = document.querySelector('meta[name="csrf-token"]').content;
const FIELD_TYPES  = @json($fieldTypes);
const CHOICE_TYPES        = ['dropdown', 'radio', 'checkbox'];
const FILE_TYPES          = ['file'];
const IMAGE_DISPLAY_TYPES = ['image'];
const HEADER_IMAGE_TYPES  = ['header_image'];
const DISPLAY_ONLY_TYPES  = ['section_break', 'paragraph', 'image', 'header_image'];

// ===== SORTABLE =====
const dropZone = document.getElementById('fieldDropZone');
Sortable.create(dropZone, {
    handle:      '.drag-handle',
    animation:   150,
    ghostClass:  'sortable-ghost',
    chosenClass: 'sortable-chosen',
    onMove: function(evt) {
        // Prevent dragging past system fields or header image, and prevent header image from being dragged
        if (evt.related.classList.contains('is-system')) return false;
        if (evt.related.classList.contains('field-card--header-image')) return false;
        if (evt.dragged.classList.contains('field-card--header-image')) return false;
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
    document.querySelectorAll('.modal-accept-check').forEach(cb => cb.checked = false);

    // Reset image file input
    const modalImgFile = document.getElementById('modalImageFile');
    if (modalImgFile) modalImgFile.value = '';

    document.getElementById('optionsSection').style.display    = CHOICE_TYPES.includes(type)        ? '' : 'none';
    document.getElementById('fileSection').style.display       = FILE_TYPES.includes(type)           ? '' : 'none';
    document.getElementById('imageUrlSection').style.display   = IMAGE_DISPLAY_TYPES.includes(type)  ? '' : 'none';

    const isDisplay  = DISPLAY_ONLY_TYPES.includes(type);
    const isImageDisp = IMAGE_DISPLAY_TYPES.includes(type);
    document.getElementById('modalPlaceholderWrap').style.display = isDisplay  ? 'none' : '';
    document.getElementById('modalRequiredWrap').style.display    = isDisplay  ? 'none' : '';
    document.getElementById('modalHelpTextWrap').style.display    = isImageDisp ? 'none' : '';

    // For image: label becomes an optional caption, not a required question
    const labelRequired = document.getElementById('modalLabelRequired');
    const labelText     = document.getElementById('modalLabelText');
    if (isImageDisp) {
        document.getElementById('modalLabel').placeholder = 'Optional caption shown below the image';
        if (labelRequired) labelRequired.style.display = 'none';
        if (labelText) labelText.childNodes[0].textContent = 'Caption ';
    } else {
        document.getElementById('modalLabel').placeholder = 'e.g. Full Name';
        if (labelRequired) labelRequired.style.display = '';
        if (labelText) labelText.childNodes[0].textContent = 'Label / Question ';
    }

    new bootstrap.Modal(document.getElementById('addFieldModal')).show();
}

function submitAddField() {
    const type        = document.getElementById('modalFieldType').value;
    const label       = document.getElementById('modalLabel').value.trim();
    const placeholder = document.getElementById('modalPlaceholder').value.trim();
    const helpText    = document.getElementById('modalHelpText').value.trim();
    const isRequired  = document.getElementById('modalIsRequired').checked;

    // For image display fields, label is an optional caption — don't block submission
    if (!label && !IMAGE_DISPLAY_TYPES.includes(type)) {
        document.getElementById('modalLabel').focus();
        return;
    }

    const addModal = document.getElementById('addFieldModal');
    const btn      = document.getElementById('btnAddField');
    setModalLock(addModal, true);
    btn.innerHTML  = '<span class="spinner-border spinner-border-sm me-1"></span>Adding...';

    let fetchOptions;

    if (IMAGE_DISPLAY_TYPES.includes(type)) {
        // Image field: multipart/form-data (file upload)
        const fd = new FormData();
        fd.append('fieldType', type);
        if (label) fd.append('label', label);
        const imgFile = document.getElementById('modalImageFile');
        if (imgFile && imgFile.files[0]) fd.append('imageFile', imgFile.files[0]);
        fetchOptions = {
            method : 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
            body   : fd,
        };
    } else {
        // All other fields: JSON
        const body = { fieldType: type, label, placeholder, helpText, isRequired };

        if (CHOICE_TYPES.includes(type)) {
            body.options = Array.from(document.querySelectorAll('.option-input'))
                .map(i => i.value.trim()).filter(v => v.length > 0)
                .map(v => ({ label: v, value: v }));
        }

        if (FILE_TYPES.includes(type)) {
            const maxSizeKB     = parseInt(document.getElementById('modalMaxSizeKB').value);
            const acceptedTypes = Array.from(document.querySelectorAll('.modal-accept-check:checked')).map(cb => cb.value);
            body.validation = {};
            if (maxSizeKB > 0)            body.validation.maxSizeKB     = maxSizeKB;
            if (acceptedTypes.length > 0) body.validation.acceptedTypes = acceptedTypes;
        }

        fetchOptions = {
            method : 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body   : JSON.stringify(body),
        };
    }

    fetch(`/admin/forms/${FORM_ID}/fields`, fetchOptions)
    .then(r => r.json())
    .then(data => {
        setModalLock(addModal, false);
        btn.innerHTML = '<i class="fa fa-plus me-1"></i> Add Field';

        if (data.success) {
            bootstrap.Modal.getInstance(addModal).hide();

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
        setModalLock(addModal, false);
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

    const isDisplay       = DISPLAY_ONLY_TYPES.includes(fieldType);
    const isImageDisplay  = IMAGE_DISPLAY_TYPES.includes(fieldType);
    const isSectionBreak  = fieldType === 'section_break';
    const isHeaderImg     = HEADER_IMAGE_TYPES.includes(fieldType);

    document.getElementById('editFieldID').value      = card.dataset.fieldId;
    document.getElementById('editLabel').value        = label;
    document.getElementById('editPlaceholder').value  = placeholder;
    document.getElementById('editIsRequired').checked = isRequired;

    // For image display type or header image: show preview of current image, reset file input
    if (isImageDisplay || isHeaderImg) {
        document.getElementById('editHelpText').value = '';
        const editImgFile = document.getElementById('editImageFile');
        if (editImgFile) editImgFile.value = '';

        const preview = document.getElementById('editCurrentImagePreview');
        const thumb   = document.getElementById('editCurrentImageThumb');
        if (preview && thumb) {
            if (helpText) {
                thumb.src              = helpText;
                preview.style.display  = '';
            } else {
                preview.style.display  = 'none';
            }
        }
    } else {
        document.getElementById('editHelpText').value = helpText;
    }

    // Hide placeholder/required for display-only types; also hide help text for section_break / header_image
    document.getElementById('editPlaceholderWrap').style.display  = isDisplay                               ? 'none' : '';
    document.getElementById('editRequiredWrap').style.display     = isDisplay                               ? 'none' : '';
    document.getElementById('editHelpTextWrap').style.display     = (isImageDisplay || isSectionBreak || isHeaderImg) ? 'none' : '';
    document.getElementById('editImageUrlSection').style.display  = (isImageDisplay || isHeaderImg)         ? ''     : 'none';

    // Hide label completely for header_image (it has no label)
    const editLabelWrap = document.getElementById('editLabelWrap');
    if (editLabelWrap) editLabelWrap.style.display = isHeaderImg ? 'none' : '';

    // Adjust label text + modal header based on field type
    const editLabelRequired = document.getElementById('editLabelRequired');
    const editLabelText     = document.getElementById('editLabelText');
    const editModalTitle    = document.getElementById('editModalTitle');
    const editModalSub      = document.getElementById('editModalSub');
    if (isHeaderImg) {
        if (editModalTitle) editModalTitle.textContent = 'Edit Header Image';
        if (editModalSub)   editModalSub.textContent   = 'Replace the banner image at the top of your form';
    } else if (isImageDisplay) {
        if (editLabelRequired) editLabelRequired.style.display = 'none';
        if (editLabelText) editLabelText.childNodes[0].textContent = 'Caption ';
        document.getElementById('editLabel').placeholder = 'Optional caption shown below the image';
        if (editModalTitle) editModalTitle.textContent = 'Edit Image';
        if (editModalSub)   editModalSub.textContent   = 'Replace the image or update the caption';
    } else if (isSectionBreak) {
        if (editLabelRequired) editLabelRequired.style.display = 'none';
        if (editLabelText) editLabelText.childNodes[0].textContent = 'Section Title ';
        document.getElementById('editLabel').placeholder = 'e.g. Personal Information';
        if (editModalTitle) editModalTitle.textContent = 'Edit Section';
        if (editModalSub)   editModalSub.textContent   = 'Update the section title shown at the top of this page';
    } else {
        if (editLabelRequired) editLabelRequired.style.display = '';
        if (editLabelText) editLabelText.childNodes[0].textContent = 'Label ';
        document.getElementById('editLabel').placeholder = 'e.g. Full Name';
        if (editModalTitle) editModalTitle.textContent = 'Edit Field';
        if (editModalSub)   editModalSub.textContent   = 'Update label, placeholder, or help text';
    }

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
        document.getElementById('editMaxSizeKB').value = validation?.maxSizeKB ?? '';
        const savedTypes = validation?.acceptedTypes ?? [];
        document.querySelectorAll('.edit-accept-check').forEach(cb => {
            cb.checked = savedTypes.includes(cb.value);
        });
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

    const LABEL_OPTIONAL_TYPES = [...IMAGE_DISPLAY_TYPES, ...HEADER_IMAGE_TYPES, 'section_break'];
    if (!label && !LABEL_OPTIONAL_TYPES.includes(fieldType)) {
        document.getElementById('editLabel').focus();
        return;
    }

    const editModal = document.getElementById('editFieldModal');
    const btn       = document.querySelector('#editFieldModal .bm-btn-submit--edit');
    const editBtn   = currentEditCard?.querySelector('.field-card-actions button');
    setModalLock(editModal, true);
    btn.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span>Saving...';
    if (editBtn) { editBtn.disabled = true; editBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>'; }
    if (currentEditCard) currentEditCard.classList.add('field-card--saving');

    let fetchOptions;

    if (IMAGE_DISPLAY_TYPES.includes(fieldType) || HEADER_IMAGE_TYPES.includes(fieldType)) {
        // Image / header_image field: multipart/form-data — may contain a new image file
        const fd = new FormData();
        if (!HEADER_IMAGE_TYPES.includes(fieldType)) fd.append('label', label);
        fd.append('_method', 'PUT');
        const imgFile = document.getElementById('editImageFile');
        if (imgFile && imgFile.files[0]) fd.append('imageFile', imgFile.files[0]);
        fetchOptions = {
            method : 'POST', // Laravel method spoofing via _method=PUT
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
            body   : fd,
        };
    } else {
        const body = { label, placeholder, helpText, isRequired };

        if (CHOICE_TYPES.includes(fieldType)) {
            body.options = Array.from(document.querySelectorAll('.edit-option-input'))
                .map(i => i.value.trim()).filter(v => v.length > 0)
                .map(v => ({ label: v, value: v }));
        }

        if (FILE_TYPES.includes(fieldType)) {
            const maxSizeKB     = parseInt(document.getElementById('editMaxSizeKB').value);
            const acceptedTypes = Array.from(document.querySelectorAll('.edit-accept-check:checked')).map(cb => cb.value);
            body.validation = {};
            if (maxSizeKB > 0)            body.validation.maxSizeKB     = maxSizeKB;
            if (acceptedTypes.length > 0) body.validation.acceptedTypes = acceptedTypes;
        }

        fetchOptions = {
            method : 'PUT',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
            body   : JSON.stringify(body),
        };
    }

    fetch(`/admin/forms/${FORM_ID}/fields/${fieldID}`, fetchOptions)
    .then(r => r.json())
    .then(data => {
        setModalLock(editModal, false);
        btn.innerHTML = '<i class="fa fa-save me-1"></i> Save Changes';
        if (editBtn) { editBtn.disabled = false; editBtn.innerHTML = '<i class="fa fa-edit"></i>'; }
        if (currentEditCard) currentEditCard.classList.remove('field-card--saving');

        if (data.success) {
            if (currentEditCard) {
                // For image field, helpText (GDrive URL) may have been updated server-side
                const savedHelpText = IMAGE_DISPLAY_TYPES.includes(fieldType)
                    ? (data.field?.helpText ?? currentEditCard.dataset.helpText)
                    : helpText;

                // Sync data-* attributes for next open
                currentEditCard.dataset.label       = label;
                currentEditCard.dataset.placeholder  = placeholder;
                currentEditCard.dataset.helpText     = savedHelpText;
                currentEditCard.dataset.isRequired   = isRequired ? '1' : '0';
                if (typeof body !== 'undefined') {
                    if (body.options    !== undefined) currentEditCard.dataset.options    = JSON.stringify(body.options);
                    if (body.validation !== undefined) currentEditCard.dataset.validation = JSON.stringify(body.validation);
                }

                if (HEADER_IMAGE_TYPES.includes(fieldType)) {
                    // Refresh header image thumbnail
                    const newUrl = data.field?.helpText ?? currentEditCard.dataset.helpText;
                    if (newUrl) {
                        const thumb = currentEditCard.querySelector('.header-img-thumb');
                        if (thumb) {
                            thumb.src = newUrl;
                        } else {
                            // Was placeholder (no image) — replace with img
                            const placeholder = currentEditCard.querySelector('.header-img-placeholder');
                            if (placeholder) {
                                const img = document.createElement('img');
                                img.src = newUrl;
                                img.alt = 'Header Image';
                                img.className = 'header-img-thumb';
                                placeholder.replaceWith(img);
                            }
                        }
                        currentEditCard.dataset.helpText = newUrl;
                    }
                } else if (fieldType === 'section_break') {
                    // Refresh section title text
                    const sectionLabelEl = currentEditCard.querySelector('.section-break-label');
                    if (sectionLabelEl) {
                        const icon = sectionLabelEl.querySelector('i');
                        sectionLabelEl.innerHTML = (icon?.outerHTML ?? '') + (label || 'New Section');
                    }
                } else {
                    // Refresh visible label
                    const labelDiv = currentEditCard.querySelector('.field-card-label');
                    if (labelDiv) {
                        const icon     = labelDiv.querySelector('i');
                        const required = isRequired ? '<span class="field-card-required">*</span>' : '';
                        const badge    = labelDiv.querySelector('.field-card-system-badge')?.outerHTML ?? '';
                        labelDiv.innerHTML = (icon?.outerHTML ?? '') + ' ' + label + ' ' + required + badge;
                    }

                    // Refresh field type + help text subtitle
                    const typeDiv = currentEditCard.querySelector('.field-card-type');
                    if (typeDiv) {
                        const rawType   = currentEditCard.dataset.fieldType ?? '';
                        const typeLabel = rawType.replace(/_/g, ' ').replace(/^./, c => c.toUpperCase());
                        const disp      = savedHelpText ?? '';
                        const truncated = disp.length > 50 ? disp.substring(0, 50) + '…' : disp;
                        typeDiv.textContent = disp ? `${typeLabel} · ${truncated}` : typeLabel;
                    }
                }
            }
            bootstrap.Modal.getInstance(document.getElementById('editFieldModal')).hide();
            const successMsg = HEADER_IMAGE_TYPES.includes(fieldType) ? 'Header image updated.' : (fieldType === 'section_break' ? 'Section updated successfully.' : 'Field updated successfully.');
            Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: successMsg, showConfirmButton: false, timer: 2500, timerProgressBar: true });
        } else {
            showAlert('danger', 'Failed to update field.');
        }
    })
    .catch(err => {
        setModalLock(editModal, false);
        btn.innerHTML = '<i class="fa fa-save me-1"></i> Save Changes';
        if (editBtn) { editBtn.disabled = false; editBtn.innerHTML = '<i class="fa fa-edit"></i>'; }
        if (currentEditCard) currentEditCard.classList.remove('field-card--saving');
        showAlert('danger', 'Error: ' + err.message);
    });
}

// ===== REMOVE FIELD =====
function removeField(btn) {
    const card      = btn.closest('.field-card');
    const fieldID   = card.dataset.fieldId;
    const label     = card.dataset.label;
    const fieldType = card.dataset.fieldType;
    const isSection = fieldType === 'section_break';
    const itemName  = isSection ? (label || 'this section') : `"${label}"`;

    Swal.fire({
        title: isSection ? 'Remove this section?' : 'Remove this field?',
        html: `${isSection ? 'Section' : 'Field'} <strong>${itemName}</strong> will be permanently removed from this form.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, remove it',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (!result.isConfirmed) return;

        // Show loading state on the card
        card.classList.add('field-card--deleting');
        const delBtn = card.querySelector('.btn-del');
        if (delBtn) {
            delBtn.disabled = true;
            delBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
        }

        fetch(`/admin/forms/${FORM_ID}/fields/${fieldID}`, {
            method: 'DELETE',
            headers: { 'X-CSRF-TOKEN': CSRF_TOKEN }
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) {
                card.remove();
                updateFieldCount(-1);
                Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: `${isSection ? 'Section' : 'Field'} ${itemName} removed.`, showConfirmButton: false, timer: 2500, timerProgressBar: true });
            } else {
                // Restore card on failure
                card.classList.remove('field-card--deleting');
                if (delBtn) { delBtn.disabled = false; delBtn.innerHTML = '<i class="fa fa-trash"></i>'; }
                showAlert('danger', data.message || 'Cannot remove this field.');
            }
        })
        .catch(err => {
            card.classList.remove('field-card--deleting');
            if (delBtn) { delBtn.disabled = false; delBtn.innerHTML = '<i class="fa fa-trash"></i>'; }
            showAlert('danger', 'Error: ' + err.message);
        });
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

// ===== MODAL LOCK =====
function setModalLock(modalEl, locked) {
    modalEl.querySelectorAll('input, textarea, select, button').forEach(el => {
        el.disabled = locked;
    });
}

// ===== HELPERS =====
function updateFieldCount(delta) {
    const badge   = document.getElementById('fieldCount');
    const current = parseInt(badge.textContent) + delta;
    badge.textContent = current + ' fields';
}

// ===== ADD HEADER IMAGE =====
function addHeaderImage() {
    if (dropZone.querySelector('.field-card--header-image')) {
        Swal.fire({ icon: 'info', title: 'Already Added', text: 'This form already has a header image. Edit or remove the existing one first.', confirmButtonColor: '#00a79d' });
        return;
    }

    Swal.fire({
        title: 'Add Header Image',
        html: `
            <div class="text-start">
                <label class="form-label fw-semibold" style="font-size:.85rem;">Choose Image <span class="text-danger">*</span></label>
                <input type="file" id="headerImageInput" class="form-control" accept="image/*">
                <div class="text-muted mt-2" style="font-size:.78rem;line-height:1.5;">
                    <strong>Recommended:</strong> 1600 × 400 px (landscape banner).<br>
                    Max file size: <strong>5 MB</strong>. Supported formats: JPG, PNG, WebP.<br>
                    The image will be pinned to the very top of the form and cannot be reordered.
                </div>
            </div>`,
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-upload me-1"></i> Upload & Add',
        confirmButtonColor: '#00a79d',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading(),
        preConfirm: () => {
            const fileInput = document.getElementById('headerImageInput');
            if (!fileInput.files[0]) {
                Swal.showValidationMessage('Please select an image file first.');
                return false;
            }
            const fd = new FormData();
            fd.append('fieldType', 'header_image');
            fd.append('imageFile', fileInput.files[0]);
            return fetch(`/admin/forms/${FORM_ID}/fields`, {
                method : 'POST',
                headers: { 'X-CSRF-TOKEN': CSRF_TOKEN },
                body   : fd,
            })
            .then(r => r.json())
            .then(data => {
                if (!data.success) {
                    Swal.showValidationMessage('Failed: ' + (data.message || 'Unknown error'));
                    return false;
                }
                return data;
            })
            .catch(err => {
                Swal.showValidationMessage('Error: ' + err.message);
                return false;
            });
        }
    }).then(result => {
        if (!result.isConfirmed || !result.value) return;
        const data = result.value;
        const emptyZone = document.getElementById('emptyZone');
        if (emptyZone) emptyZone.remove();
        // Insert at the very TOP — header image is always first
        dropZone.insertAdjacentHTML('afterbegin', data.html);
        updateFieldCount(1);
        // Persist the order so backend assigns sort_order = 0
        saveFieldOrder();
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: 'Header image added.', showConfirmButton: false, timer: 2500, timerProgressBar: true });
    });
}

// ===== ADD SECTION =====
function addSection() {
    Swal.fire({
        title: 'Add Section',
        html: `
            <div class="text-start">
                <label class="form-label fw-semibold" style="font-size:.85rem;">
                    Section Title <span class="text-muted fw-normal">(optional)</span>
                </label>
                <input id="sectionTitleInput" class="form-control" placeholder="e.g. Personal Information" maxlength="500">
                <div class="text-muted mt-2" style="font-size:.78rem;">
                    Sections split your form into multiple pages. Respondents navigate with Previous / Next buttons.
                </div>
            </div>`,
        showCancelButton: true,
        confirmButtonText: '<i class="fa fa-plus me-1"></i> Add Section',
        confirmButtonColor: '#00a79d',
        cancelButtonText: 'Cancel',
        showLoaderOnConfirm: true,
        allowOutsideClick: () => !Swal.isLoading(),
        preConfirm: () => {
            const title = document.getElementById('sectionTitleInput').value.trim() || 'New Section';
            return fetch(`/admin/forms/${FORM_ID}/fields`, {
                method : 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF_TOKEN },
                body   : JSON.stringify({ fieldType: 'section_break', label: title })
            })
            .then(r => r.json())
            .then(data => {
                if (!data.success) {
                    Swal.showValidationMessage('Failed: ' + (data.message || 'Unknown error'));
                    return false;
                }
                return { title, data };
            })
            .catch(err => {
                Swal.showValidationMessage('Error: ' + err.message);
                return false;
            });
        }
    }).then(result => {
        if (!result.isConfirmed || !result.value) return;

        const { title, data } = result.value;
        const emptyZone = document.getElementById('emptyZone');
        if (emptyZone) emptyZone.remove();
        dropZone.insertAdjacentHTML('beforeend', data.html);
        updateFieldCount(1);
        Swal.fire({ toast: true, position: 'top-end', icon: 'success', title: `Section "${title}" added.`, showConfirmButton: false, timer: 2500, timerProgressBar: true });
    });
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
