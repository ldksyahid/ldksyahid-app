<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Submit spinner — create form
const _createFormEl = document.getElementById('createFormForm');
if (_createFormEl) {
    _createFormEl.addEventListener('submit', function () {
        const btn = document.getElementById('btnCreate');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Creating...';
    });
}

// Submit spinner — edit form
const _editFormEl = document.getElementById('editFormForm');
if (_editFormEl) {
    _editFormEl.addEventListener('submit', function () {
        const btn = document.getElementById('btnSave');
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';
    });
}

// Copy public URL — view mode
function copyFormUrl() {
    const url = document.getElementById('formPublicUrl').textContent.trim();
    navigator.clipboard.writeText(url).then(() => {
        Swal.fire({
            toast: true, position: 'top-end', icon: 'success',
            title: 'Form URL copied to clipboard!',
            showConfirmButton: false, timer: 2000
        });
    }).catch(() => {
        Swal.fire({
            title: 'Copy this URL', input: 'text', inputValue: url,
            confirmButtonColor: '#00a79d', confirmButtonText: 'Close'
        });
    });
}
</script>
