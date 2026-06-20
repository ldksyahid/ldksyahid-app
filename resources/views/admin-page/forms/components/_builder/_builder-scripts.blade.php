<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
const FORM_ID      = {{ $form->formID }};
const CSRF_TOKEN   = document.querySelector('meta[name="csrf-token"]').content;
const FIELD_TYPES  = @json($fieldTypes);
const CHOICE_TYPES        = ['dropdown', 'radio', 'checkbox'];
const LINEAR_SCALE_TYPES  = ['linear_scale'];
const RATING_TYPES        = ['rating'];
const FILE_TYPES          = ['file'];
const IMAGE_DISPLAY_TYPES = ['image'];
const HEADER_IMAGE_TYPES  = ['header_image'];
const DISPLAY_ONLY_TYPES  = ['section_break', 'paragraph', 'image', 'header_image'];
const PLACEHOLDER_TYPES   = ['short_text', 'long_text', 'email', 'number', 'phone', 'url'];

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

    document.getElementById('optionsSection').style.display      = CHOICE_TYPES.includes(type)       ? '' : 'none';
    document.getElementById('linearScaleSection').style.display  = LINEAR_SCALE_TYPES.includes(type) ? '' : 'none';
    document.getElementById('ratingSection').style.display       = RATING_TYPES.includes(type)       ? '' : 'none';
    document.getElementById('fileSection').style.display         = FILE_TYPES.includes(type)          ? '' : 'none';
    document.getElementById('imageUrlSection').style.display     = IMAGE_DISPLAY_TYPES.includes(type) ? '' : 'none';

    // Reset linear scale defaults
    if (LINEAR_SCALE_TYPES.includes(type)) {
        document.getElementById('modalLinearScaleMin').value      = '1';
        document.getElementById('modalLinearScaleMax').value      = '5';
        document.getElementById('modalLinearScaleMinLabel').value = '';
        document.getElementById('modalLinearScaleMaxLabel').value = '';
    }

    // Reset rating defaults + live preview
    if (RATING_TYPES.includes(type)) {
        const sel = document.getElementById('modalRatingMax');
        sel.value = '5';
        updateRatingPreview('modalRatingPreview', 5);
    }

    const isDisplay  = DISPLAY_ONLY_TYPES.includes(type);
    const isImageDisp = IMAGE_DISPLAY_TYPES.includes(type);
    document.getElementById('modalPlaceholderWrap').style.display = PLACEHOLDER_TYPES.includes(type) ? '' : 'none';
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

        if (LINEAR_SCALE_TYPES.includes(type)) {
            const lsMin = parseInt(document.getElementById('modalLinearScaleMin').value);
            const lsMax = parseInt(document.getElementById('modalLinearScaleMax').value);
            body.fieldConfig = {
                minValue : isNaN(lsMin) ? 0 : lsMin,
                maxValue : isNaN(lsMax) ? 5 : lsMax,
                minLabel : document.getElementById('modalLinearScaleMinLabel').value.trim(),
                maxLabel : document.getElementById('modalLinearScaleMaxLabel').value.trim(),
            };
        }

        if (RATING_TYPES.includes(type)) {
            body.fieldConfig = {
                maxRating: parseInt(document.getElementById('modalRatingMax').value) || 5,
            };
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
    document.getElementById('editPlaceholderWrap').style.display  = PLACEHOLDER_TYPES.includes(fieldType)   ? ''     : 'none';
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

    // Show / hide linear scale section
    const isLinearScale = LINEAR_SCALE_TYPES.includes(fieldType);
    document.getElementById('editLinearScaleSection').style.display = isLinearScale ? '' : 'none';
    if (isLinearScale) {
        const fieldConfig = JSON.parse(card.dataset.fieldConfig || '{}');
        document.getElementById('editLinearScaleMin').value      = fieldConfig.minValue ?? 1;
        document.getElementById('editLinearScaleMax').value      = fieldConfig.maxValue ?? 5;
        document.getElementById('editLinearScaleMinLabel').value = fieldConfig.minLabel ?? '';
        document.getElementById('editLinearScaleMaxLabel').value = fieldConfig.maxLabel ?? '';
    }

    // Show / hide rating section
    const isRating = RATING_TYPES.includes(fieldType);
    document.getElementById('editRatingSection').style.display = isRating ? '' : 'none';
    if (isRating) {
        const fieldConfig = JSON.parse(card.dataset.fieldConfig || '{}');
        const maxR = fieldConfig.maxRating ?? 5;
        const sel  = document.getElementById('editRatingMax');
        sel.value  = maxR;
        updateRatingPreview('editRatingPreview', maxR);
    }
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

    // Section Routing (radio + dropdown — single-answer choice types)
    const routingWrap    = document.getElementById('editSectionRoutingWrap');
    const isSingleChoice = ['radio', 'dropdown'].includes(fieldType);
    if (routingWrap) routingWrap.style.display = isSingleChoice ? '' : 'none';
    if (isSingleChoice) {
        const fc       = JSON.parse(card.dataset.fieldConfig || '{}');
        const routing  = fc.sectionRouting || { enabled: false, routes: [] };
        const enableCb = document.getElementById('editRoutingEnabled');
        const body     = document.getElementById('editRoutingBody');
        enableCb.checked      = !!routing.enabled;
        body.style.display    = routing.enabled ? '' : 'none';
        buildRoutingRows(options, routing.routes || []);
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

// ===== SECTION ROUTING HELPERS =====
function _escHtml(s) {
    return String(s || '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

function _getSectionCards() {
    return Array.from(dropZone.querySelectorAll('.field-card--section-break')).map(c => ({
        id   : c.dataset.fieldId,
        label: c.dataset.label || 'Untitled Section',
    }));
}

function buildRoutingRows(opts, existingRoutes) {
    const rowsEl = document.getElementById('editRoutingRows');
    if (!rowsEl) return;
    const sections = _getSectionCards();
    if (!sections.length) {
        rowsEl.innerHTML = '<div class="sr-no-sections">No sections found. Add sections to the form first.</div>';
        return;
    }
    const secOpts = sections.map(s =>
        `<option value="${_escHtml(s.id)}">${_escHtml(s.label)}</option>`
    ).join('');

    rowsEl.innerHTML = '';
    const labels = opts.map(o => (o.label || o.value || '')).filter(Boolean);
    if (!labels.length) {
        rowsEl.innerHTML = '<div class="sr-no-sections">Add options first to configure routing.</div>';
        return;
    }
    labels.forEach(optVal => {
        const existing  = existingRoutes.find(r => r.optionValue === optVal);
        const targetID  = existing ? (existing.targetSectionFieldID ?? '') : '';
        const selected  = id => id == targetID ? 'selected' : '';
        const row = document.createElement('div');
        row.className = 'sr-row';
        row.innerHTML = `
            <span class="sr-row-label" title="${_escHtml(optVal)}">${_escHtml(optVal)}</span>
            <i class="fas fa-arrow-right sr-arrow"></i>
            <select class="form-select form-select-sm sr-route-select"
                    data-option-value="${_escHtml(optVal)}">
                <option value="">Next section (default)</option>
                ${sections.map(s => `<option value="${_escHtml(s.id)}" ${selected(s.id)}>${_escHtml(s.label)}</option>`).join('')}
            </select>`;
        rowsEl.appendChild(row);
    });
}

function onRoutingToggle(cb) {
    const body = document.getElementById('editRoutingBody');
    body.style.display = cb.checked ? '' : 'none';
    if (cb.checked) {
        // Only rebuild rows if none exist yet (preserve selections if user toggled off then back on)
        const existingRows = document.querySelectorAll('.sr-route-select');
        if (!existingRows.length) {
            const opts = Array.from(document.querySelectorAll('.edit-option-input'))
                .map(i => ({ label: i.value.trim(), value: i.value.trim() }));
            buildRoutingRows(opts, []);
        }
    }
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
    let body = null;

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
        body = { label, placeholder, helpText, isRequired };

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

        if (LINEAR_SCALE_TYPES.includes(fieldType)) {
            const lsMin = parseInt(document.getElementById('editLinearScaleMin').value);
            const lsMax = parseInt(document.getElementById('editLinearScaleMax').value);
            body.fieldConfig = {
                minValue : isNaN(lsMin) ? 0 : lsMin,
                maxValue : isNaN(lsMax) ? 5 : lsMax,
                minLabel : document.getElementById('editLinearScaleMinLabel').value.trim(),
                maxLabel : document.getElementById('editLinearScaleMaxLabel').value.trim(),
            };
        }

        if (RATING_TYPES.includes(fieldType)) {
            body.fieldConfig = {
                maxRating: parseInt(document.getElementById('editRatingMax').value) || 5,
            };
        }

        if (['radio', 'dropdown'].includes(fieldType)) {
            const routingEnabled = document.getElementById('editRoutingEnabled')?.checked || false;
            const routes = routingEnabled
                ? Array.from(document.querySelectorAll('.sr-route-select')).map(sel => ({
                    optionValue         : sel.dataset.optionValue,
                    targetSectionFieldID: sel.value ? parseInt(sel.value) : null,
                }))
                : [];
            body.fieldConfig = Object.assign(body.fieldConfig || {}, {
                sectionRouting: { enabled: routingEnabled, routes },
            });
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
                if (body) {
                    if (body.options     !== undefined) currentEditCard.dataset.options     = JSON.stringify(body.options);
                    if (body.validation  !== undefined) currentEditCard.dataset.validation  = JSON.stringify(body.validation);
                    if (body.fieldConfig !== undefined) currentEditCard.dataset.fieldConfig = JSON.stringify(body.fieldConfig);
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
                        // Routing badge (radio + dropdown)
                        const fc             = JSON.parse(currentEditCard.dataset.fieldConfig || '{}');
                        const hasRouting     = ['radio','dropdown'].includes(fieldType) && (fc.sectionRouting?.enabled ?? false);
                        const routingBadge   = hasRouting
                            ? '<span class="field-card-routing-badge"><i class="fas fa-code-branch fa-xs me-1"></i>Routing</span>'
                            : '';
                        labelDiv.innerHTML = (icon?.outerHTML ?? '') + ' ' + label + ' ' + required + badge + routingBadge;
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
    const isSection    = fieldType === 'section_break';
    const isHeaderImg  = fieldType === 'header_image';
    const itemName     = isSection   ? (label || 'this section')
                       : isHeaderImg ? 'the header banner'
                       : label       ? `"${label}"`
                                     : 'this field';

    Swal.fire({
        title: isSection ? 'Remove this section?' : isHeaderImg ? 'Remove header banner?' : 'Remove this field?',
        html: `${isSection ? 'Section' : isHeaderImg ? 'Banner' : 'Field'} <strong>${itemName}</strong> will be permanently removed from this form.`,
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
    window.refreshModalPreview && window.refreshModalPreview();
}

function removeOption(btn) {
    const rows = document.querySelectorAll('.option-row');
    if (rows.length <= 1) return;
    btn.closest('.option-row').remove();
    window.refreshModalPreview && window.refreshModalPreview();
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

// ===== RATING PREVIEW =====
function updateRatingPreview(containerId, max) {
    const el = document.getElementById(containerId);
    if (!el) return;
    el.innerHTML = '';
    for (let i = 1; i <= max; i++) {
        const icon = document.createElement('i');
        icon.className = 'far fa-star';
        el.appendChild(icon);
    }
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

// ===== MODAL LIVE PREVIEW =====
(function () {
    function esc(s) {
        return String(s || '')
            .replace(/&/g,'&amp;').replace(/</g,'&lt;')
            .replace(/>/g,'&gt;').replace(/"/g,'&quot;');
    }

    function getOpts() {
        return Array.from(document.querySelectorAll('#optionsList .option-input'))
            .map(i => i.value.trim()).filter(Boolean);
    }

    const ANN = { label: () => '', help: () => '', ph: () => '', spc: () => '' };

    function buildPreview(type, label, ph, help, req) {
        const lbl = label || 'Field label';

        // Row: badge + content
        const row = (badge, content) =>
            `<div class="bmp-row">${badge}${content}</div>`;

        const labelRow = () => row(
            ANN.label(),
            `<div class="bmp-field-label">${esc(lbl)}${req ? '<span class="bmp-req">*</span>' : ''}</div>`
        );

        const helpRow = () => help
            ? row(ANN.help(), `<div class="bmp-field-help">${esc(help)}</div>`)
            : '';

        const underlineRow = (dflt) => row(
            ph ? ANN.ph() : ANN.spc(),
            `<div class="bmp-field-input">${esc(ph || dflt || 'Your answer...')}</div>`
        );

        const triggerRow = (icon, text) =>
            `<div class="bmp-field-trigger">
                <i class="fas ${icon}"></i>
                <span>${esc(text)}</span>
            </div>`;

        switch (type) {
            case 'short_text':
                return labelRow() + helpRow() + underlineRow('Short answer...');

            case 'long_text':
                return labelRow() + helpRow() + row(
                    ph ? ANN.ph() : ANN.spc(),
                    `<div class="bmp-field-textarea">${esc(ph || 'Long answer...')}</div>`
                );

            case 'email':
                return labelRow() + helpRow() + underlineRow('contoh@email.com');

            case 'number':
                return labelRow() + helpRow() + underlineRow('0');

            case 'phone':
                return labelRow() + helpRow() + underlineRow('+62812...');

            case 'url':
                return labelRow() + helpRow() + underlineRow('https://');

            case 'date': {
                const now = new Date();
                const y = now.getFullYear(), m = now.getMonth();
                const MNAMES = ['January','February','March','April','May','June',
                                'July','August','September','October','November','December'];
                const WDAYS  = ['Su','Mo','Tu','We','Th','Fr','Sa'];
                const firstDay = new Date(y, m, 1).getDay();
                const daysInMonth = new Date(y, m + 1, 0).getDate();
                const today = now.getDate();
                const sel   = today - 3 > 0 ? today - 3 : today;

                let cells = '';
                for (let i = 0; i < firstDay; i++) {
                    const d = new Date(y, m, 0).getDate() - firstDay + 1 + i;
                    cells += `<div class="bmp-cal-cell other">${d}</div>`;
                }
                for (let d = 1; d <= daysInMonth && cells.split('bmp-cal-cell').length <= 30; d++) {
                    const cls = d === today ? 'today' : d === sel ? 'sel' : '';
                    cells += `<div class="bmp-cal-cell ${cls}">${d}</div>`;
                }

                return labelRow() + helpRow() +
                    `<div class="bmp-field-trigger"><i class="fas fa-calendar-alt"></i> <span>Select date</span></div>
                    <div class="bmp-cal">
                        <div class="bmp-cal-head">
                            <div class="bmp-cal-nav"><i class="fas fa-chevron-left"></i></div>
                            <span class="bmp-cal-month">${MNAMES[m]} ${y}</span>
                            <div class="bmp-cal-nav"><i class="fas fa-chevron-right"></i></div>
                        </div>
                        <div class="bmp-cal-wd">${WDAYS.map(d=>`<span>${d}</span>`).join('')}</div>
                        <div class="bmp-cal-grid">${cells}</div>
                    </div>`;
            }

            case 'time': {
                const hn = new Date().getHours();
                const mn = new Date().getMinutes();
                const hRows = [hn-1, hn, hn+1].map((h,i) =>
                    `<div class="bmp-tp-item${i===1?' sel':i===0||i===2?' near':''}">${String((h+24)%24).padStart(2,'0')}</div>`
                ).join('');
                const mRows = [mn-1, mn, mn+1].map((mm,i) =>
                    `<div class="bmp-tp-item${i===1?' sel':i===0||i===2?' near':''}">${String((mm+60)%60).padStart(2,'0')}</div>`
                ).join('');

                return labelRow() + helpRow() +
                    `<div class="bmp-field-trigger"><i class="fas fa-clock"></i> <span>--:--</span></div>
                    <div class="bmp-tp">
                        <div class="bmp-tp-col-wrap">
                            <div class="bmp-tp-lbl">Hour</div>
                            <div class="bmp-tp-col">${hRows}</div>
                        </div>
                        <div class="bmp-tp-sep">:</div>
                        <div class="bmp-tp-col-wrap">
                            <div class="bmp-tp-lbl">Minute</div>
                            <div class="bmp-tp-col">${mRows}</div>
                        </div>
                    </div>`;
            }

            case 'datetime': {
                const now2  = new Date();
                const y2 = now2.getFullYear(), m2 = now2.getMonth();
                const MNAMES2 = ['January','February','March','April','May','June',
                                 'July','August','September','October','November','December'];
                const WDAYS2  = ['Su','Mo','Tu','We','Th','Fr','Sa'];
                const firstDay2 = new Date(y2, m2, 1).getDay();
                const dim2 = new Date(y2, m2 + 1, 0).getDate();
                const today2 = now2.getDate();
                const sel2 = today2 - 2 > 0 ? today2 - 2 : today2;
                let cells2 = '';
                for (let i = 0; i < firstDay2; i++) {
                    cells2 += `<div class="bmp-cal-cell other">${new Date(y2,m2,0).getDate()-firstDay2+1+i}</div>`;
                }
                for (let d = 1; d <= dim2 && cells2.split('bmp-cal-cell').length <= 30; d++) {
                    cells2 += `<div class="bmp-cal-cell${d===today2?' today':d===sel2?' sel':''}">${d}</div>`;
                }
                const hn2 = now2.getHours(), mn2 = now2.getMinutes();
                const hR2 = [hn2-1,hn2,hn2+1].map((h,i)=>
                    `<div class="bmp-tp-item${i===1?' sel':i!==1?' near':''}">${String((h+24)%24).padStart(2,'0')}</div>`).join('');
                const mR2 = [mn2-1,mn2,mn2+1].map((mm,i)=>
                    `<div class="bmp-tp-item${i===1?' sel':i!==1?' near':''}">${String((mm+60)%60).padStart(2,'0')}</div>`).join('');

                return labelRow() + helpRow() +
                    `<div class="bmp-field-trigger"><i class="fas fa-calendar-alt"></i> <span>dd/mm/yyyy --:--</span></div>
                    <div class="bmp-cal">
                        <div class="bmp-cal-head">
                            <div class="bmp-cal-nav"><i class="fas fa-chevron-left"></i></div>
                            <span class="bmp-cal-month">${MNAMES2[m2]} ${y2}</span>
                            <div class="bmp-cal-nav"><i class="fas fa-chevron-right"></i></div>
                        </div>
                        <div class="bmp-cal-wd">${WDAYS2.map(d=>`<span>${d}</span>`).join('')}</div>
                        <div class="bmp-cal-grid">${cells2}</div>
                    </div>
                    <div class="bmp-tp" style="margin-top:5px;">
                        <div class="bmp-tp-col-wrap">
                            <div class="bmp-tp-lbl">Hour</div>
                            <div class="bmp-tp-col">${hR2}</div>
                        </div>
                        <div class="bmp-tp-sep">:</div>
                        <div class="bmp-tp-col-wrap">
                            <div class="bmp-tp-lbl">Minute</div>
                            <div class="bmp-tp-col">${mR2}</div>
                        </div>
                    </div>`;
            }

            case 'dropdown': {
                const opts = getOpts();
                let html = labelRow() + helpRow() +
                    `<div class="bmp-field-trigger bmp-dd-trigger">
                        <span>-- Select one --</span>
                        <i class="fas fa-chevron-down"></i>
                    </div>
                    <div class="bmp-dd-list">
                        <div class="bmp-dd-opt bmp-dd-opt--ph">-- Select one --</div>`;
                if (opts.length) {
                    opts.slice(0, 6).forEach((o, i) => {
                        html += `<div class="bmp-dd-opt${i===0?' bmp-dd-opt--sel':''}">
                            ${i===0 ? '<i class="fas fa-check bmp-dd-check"></i>' : '<span class="bmp-dd-spc"></span>'}
                            ${esc(o)}
                        </div>`;
                    });
                    if (opts.length > 6) html += `<div class="bmp-dd-more">+${opts.length-6} opsi lainnya...</div>`;
                } else {
                    html += `<div class="bmp-dd-opt bmp-dd-opt--empty"><i class="fas fa-plus bmp-dd-check"></i> Add options on the left...</div>`;
                }
                html += `</div>`;
                return html;
            }

            case 'radio': {
                const opts = getOpts();
                const rows = opts.length
                    ? opts.map((o, i) => `
                        <div class="bmp-opt-row${i===0?' bmp-opt-row--sel':''}">
                            <div class="bmp-radio${i===0?' bmp-radio--on':''}"></div>
                            <span>${esc(o)}</span>
                        </div>`).join('')
                    : `<div class="bmp-empty"><i class="fas fa-plus fa-xs me-1"></i>Add options on the left...</div>`;
                return labelRow() + helpRow() + rows;
            }

            case 'checkbox': {
                const opts = getOpts();
                const rows = opts.length
                    ? opts.map((o, i) => `
                        <div class="bmp-opt-row${i<2?' bmp-opt-row--sel':''}">
                            <div class="bmp-checkbox${i<2?' bmp-checkbox--on':''}"></div>
                            <span>${esc(o)}</span>
                        </div>`).join('')
                    : `<div class="bmp-empty"><i class="fas fa-plus fa-xs me-1"></i>Add options on the left...</div>`;
                return labelRow() + helpRow() + rows;
            }

            case 'linear_scale': {
                const min = +(document.getElementById('modalLinearScaleMin')?.value || 1);
                const max = +(document.getElementById('modalLinearScaleMax')?.value || 5);
                const minL = document.getElementById('modalLinearScaleMinLabel')?.value || '';
                const maxL = document.getElementById('modalLinearScaleMaxLabel')?.value || '';
                const nums = [];
                for (let n = min; n <= max; n++) nums.push(n);
                const mid = Math.floor(nums.length / 2);
                const dots = nums.map((n, i) => `
                    <div class="bmp-scale-item">
                        <span class="bmp-scale-n">${n}</span>
                        <div class="bmp-scale-dot${i===mid?' bmp-scale-dot--on':''}"></div>
                    </div>`).join('');
                return labelRow() + helpRow() +
                    `<div class="bmp-scale-row">
                        ${minL ? `<span class="bmp-scale-edge">${esc(minL)}</span>` : ''}
                        ${dots}
                        ${maxL ? `<span class="bmp-scale-edge">${esc(maxL)}</span>` : ''}
                    </div>`;
            }

            case 'rating': {
                const max = +(document.getElementById('modalRatingMax')?.value || 5);
                const half = Math.ceil(max / 2);
                let stars = '';
                for (let i = 0; i < max; i++)
                    stars += `<i class="${i<half?'fas':'far'} fa-star bmp-star"></i>`;
                return labelRow() + helpRow() + `<div class="bmp-stars">${stars}</div>`;
            }

            case 'file':
                return labelRow() + helpRow() +
                    `<div class="bmp-upload">
                        <i class="fas fa-cloud-upload-alt bmp-upload-icon"></i>
                        <div class="bmp-upload-text">Click or drag a file here</div>
                        <div class="bmp-upload-hint">All file types accepted</div>
                    </div>`;

            case 'paragraph':
                return row(ANN.label(), `<div class="bmp-para">${esc(lbl)}</div>`);

            case 'image':
                return `<div class="bmp-img-mock"><i class="fas fa-image"></i> Image</div>
                    ${lbl !== 'Field label'
                        ? row(ANN.spc(), `<div class="bmp-img-caption">${esc(lbl)}</div>`)
                        : ''}`;

            case 'section_break':
                return `<div class="bmp-section">
                    ${lbl !== 'Field label'
                        ? `<div class="bmp-section-title">${esc(lbl)}</div>` : ''}
                    ${help ? `<div class="bmp-section-desc">${esc(help)}</div>` : ''}
                </div>`;

            default:
                return labelRow() + helpRow() + underlineRow('Your answer...');
        }
    }

    function refresh() {
        const el  = document.getElementById('modalPreviewField');
        const elM = document.getElementById('modalPreviewFieldMobile');
        if (!el) return;
        const type = document.getElementById('modalFieldType')?.value || '';
        const label = document.getElementById('modalLabel')?.value || '';
        const ph    = document.getElementById('modalPlaceholder')?.value || '';
        const help  = document.getElementById('modalHelpText')?.value || '';
        const req   = document.getElementById('modalIsRequired')?.checked || false;
        const html  = buildPreview(type, label, ph, help, req);
        el.innerHTML = html;
        if (elM) elM.innerHTML = html;
    }

    // Tab switching: Desktop / Mobile
    document.addEventListener('click', function (e) {
        const tab = e.target.closest('.bmp-preview-tab');
        if (!tab) return;
        const view = tab.dataset.view;
        document.querySelectorAll('.bmp-preview-tab').forEach(t => t.classList.remove('active'));
        tab.classList.add('active');
        document.querySelectorAll('.bmp-preview-view').forEach(v => v.style.display = 'none');
        const target = document.querySelector(`.bmp-preview-view--${view}`);
        if (target) target.style.display = '';
    });

    // Auto-switch preview tab based on screen width
    function syncPreviewTab() {
        const isMobile = window.innerWidth < 768;
        const targetView = isMobile ? 'mobile' : 'desktop';
        document.querySelectorAll('.bmp-preview-tab').forEach(t => {
            t.classList.toggle('active', t.dataset.view === targetView);
        });
        document.querySelectorAll('.bmp-preview-view').forEach(v => {
            v.style.display = v.classList.contains('bmp-preview-view--' + targetView) ? '' : 'none';
        });
    }
    window.addEventListener('resize', syncPreviewTab);

    // Hook into existing openAddFieldModal
    const _origOpen = window.openAddFieldModal;
    window.openAddFieldModal = function (type, label) {
        _origOpen && _origOpen(type, label);
        syncPreviewTab();
        setTimeout(refresh, 80);
    };

    // Live-update on input changes
    document.addEventListener('input', function (e) {
        const ids = ['modalLabel','modalPlaceholder','modalHelpText',
                     'modalLinearScaleMin','modalLinearScaleMax',
                     'modalLinearScaleMinLabel','modalLinearScaleMaxLabel'];
        if (ids.includes(e.target.id) || e.target.classList.contains('option-input'))
            refresh();
    });

    document.addEventListener('change', function (e) {
        const ids = ['modalIsRequired','modalLinearScaleMin','modalLinearScaleMax',
                     'modalLinearScaleMinLabel','modalLinearScaleMaxLabel','modalRatingMax'];
        if (ids.includes(e.target.id)) refresh();
    });

    // Expose for manual call after option add/remove
    window.refreshModalPreview = refresh;
})();

// ===== FIELD PREVIEW POPUP — REMOVED =====
/* (function () {
    const PREVIEWS = {
        short_text: {
            label: 'Short Text', desc: 'Single-line text input',
            html: `<div class="fpp-name">Full Name <span class="fpp-req">*</span></div>
                   <div class="fpp-hint">Short answer</div>
                   <div class="fpp-underline">Your answer...</div>`
        },
        long_text: {
            label: 'Long Text', desc: 'Multi-line text area',
            html: `<div class="fpp-name">Tell us about yourself</div>
                   <div class="fpp-underline-tall">Long answer...</div>`
        },
        email: {
            label: 'Email', desc: 'Email address input',
            html: `<div class="fpp-name">Email Address <span class="fpp-req">*</span></div>
                   <div class="fpp-hint">Confirmation will be sent to this email</div>
                   <div class="fpp-underline">example@email.com</div>`
        },
        number: {
            label: 'Number', desc: 'Numeric input only',
            html: `<div class="fpp-name">Age</div>
                   <div class="fpp-underline">0</div>`
        },
        phone: {
            label: 'Phone', desc: 'Phone number input',
            html: `<div class="fpp-name">Phone Number <span class="fpp-req">*</span></div>
                   <div class="fpp-hint">Use an active number</div>
                   <div class="fpp-underline">+1234...</div>`
        },
        url: {
            label: 'URL / Link', desc: 'Web address input',
            html: `<div class="fpp-name">Website / Portfolio</div>
                   <div class="fpp-underline">https://</div>`
        },
        date: {
            label: 'Date', desc: 'Calendar date picker',
            html: `<div class="fpp-name">Date of Birth <span class="fpp-req">*</span></div>
                   <div class="fpp-box"><i class="fas fa-calendar-alt fpp-box-icon"></i> Select date</div>`
        },
        time: {
            label: 'Time', desc: 'Clock time picker',
            html: `<div class="fpp-name">Arrival Time <span class="fpp-req">*</span></div>
                   <div class="fpp-box"><i class="fas fa-clock fpp-box-icon"></i> --:--</div>`
        },
        datetime: {
            label: 'Date & Time', desc: 'Combined date + time picker',
            html: `<div class="fpp-name">Event Date & Time <span class="fpp-req">*</span></div>
                   <div class="fpp-box"><i class="fas fa-calendar-alt fpp-box-icon"></i> dd/mm/yyyy --:--</div>`
        },
        dropdown: {
            label: 'Dropdown', desc: 'Single selection from a list',
            html: `<div class="fpp-name">Gender</div>
                   <div class="fpp-dd">-- Select one -- <i class="fas fa-chevron-down" style="font-size:.55rem;"></i></div>
                   <div class="fpp-hint" style="margin-top:5px;">Male / Female / ...</div>`
        },
        radio: {
            label: 'Multiple Choice', desc: 'Pick one option',
            html: `<div class="fpp-name">Grade / Class <span class="fpp-req">*</span></div>
                   <div class="fpp-opt"><div class="fpp-radio-dot on"></div> Grade 10</div>
                   <div class="fpp-opt"><div class="fpp-radio-dot"></div> Grade 11</div>
                   <div class="fpp-opt"><div class="fpp-radio-dot"></div> Grade 12</div>`
        },
        checkbox: {
            label: 'Checkboxes', desc: 'Pick multiple options',
            html: `<div class="fpp-name">Areas of Interest</div>
                   <div class="fpp-opt"><div class="fpp-cb on"></div> Mathematics</div>
                   <div class="fpp-opt"><div class="fpp-cb on"></div> Science</div>
                   <div class="fpp-opt"><div class="fpp-cb"></div> Languages</div>`
        },
        linear_scale: {
            label: 'Linear Scale', desc: 'Numbered rating scale',
            html: `<div class="fpp-name">Satisfaction level</div>
                   <div class="fpp-hint">1 = Not satisfied &nbsp; 5 = Very satisfied</div>
                   <div class="fpp-scale-row">
                       ${[1,2,3,4,5].map((n,i) => `<div class="fpp-scale-item"><div class="fpp-scale-num">${n}</div><div class="fpp-scale-dot${i===2?' on':''}"></div></div>`).join('')}
                   </div>`
        },
        rating: {
            label: 'Rating', desc: 'Star rating input',
            html: `<div class="fpp-name">Event Rating</div>
                   <div class="fpp-stars">★★★☆☆</div>
                   <div class="fpp-hint">1 — 5 stars</div>`
        },
        file: {
            label: 'File Upload', desc: 'Accept file attachments',
            html: `<div class="fpp-name">Proof of Payment <span class="fpp-req">*</span></div>
                   <div class="fpp-upload"><i class="fas fa-cloud-upload-alt fpp-upload-icon"></i>Click or drag a file here<br><span style="font-size:.62rem;">PDF · JPG · PNG · Max 5 MB</span></div>`
        },
        paragraph: {
            label: 'Paragraph Text', desc: 'Static display text / instructions',
            html: `<div class="fpp-para">Please read the following terms carefully before filling out this form...</div>`
        },
        image: {
            label: 'Image Display', desc: 'Show an image inside the form',
            html: `<div class="fpp-img-mock"><i class="fas fa-image"></i> Image displayed here</div>`
        },
        section_break: {
            label: 'Section Break', desc: 'Splits form into multiple pages',
            html: `<div class="fpp-section-divider"><i class="fas fa-columns"></i> New Section <div class="fpp-section-line"></div></div>
                   <div class="fpp-hint" style="margin-top:4px;">Form is divided into multiple pages (steps).</div>`
        },
        header_image: {
            label: 'Header Image', desc: 'Banner image pinned to form top',
            html: `<div class="fpp-img-mock" style="height:50px; background:linear-gradient(135deg,#00a79d,#0ea5e9); color:#fff; border-radius:7px;"><i class="fas fa-image"></i> Banner 1600×400</div>`
        }
    };

    const popup   = document.getElementById('fppWrap');
    const fppLbl  = document.getElementById('fppLabel');
    const fppDesc = document.getElementById('fppDesc');
    const fppBody = document.getElementById('fppBody');
    let hideTimer = null;

    function show(btn) {
        const type = btn.dataset.type;
        const p    = PREVIEWS[type];
        if (!p || !popup) return;

        fppLbl.textContent  = p.label;
        fppDesc.textContent = p.desc;
        fppBody.innerHTML   = p.html;

        // Position to the right of the button
        popup.style.top  = '-9999px';
        popup.style.left = '-9999px';
        popup.classList.add('visible');

        const rect = btn.getBoundingClientRect();
        const ph   = popup.offsetHeight;
        let top    = rect.top + rect.height / 2 - ph / 2;
        const left = rect.right + 10;

        // Clamp vertically
        if (top + ph > window.innerHeight - 8) top = window.innerHeight - ph - 8;
        if (top < 8) top = 8;

        popup.style.top  = top + 'px';
        popup.style.left = left + 'px';
    }

    function hide() { popup && popup.classList.remove('visible'); }

    document.querySelectorAll('.field-type-btn').forEach(function (btn) {
        btn.addEventListener('mouseenter', function () {
            clearTimeout(hideTimer);
            show(btn);
        });
        btn.addEventListener('mouseleave', function () {
            hideTimer = setTimeout(hide, 100);
        });
    });

    if (popup) {
        popup.addEventListener('mouseenter', function () { clearTimeout(hideTimer); });
        popup.addEventListener('mouseleave', function () { hideTimer = setTimeout(hide, 100); });
    }
}); */
</script>
