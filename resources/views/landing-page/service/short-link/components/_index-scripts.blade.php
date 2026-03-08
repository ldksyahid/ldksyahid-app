<script>
document.addEventListener('DOMContentLoaded', function () {

    /* ============================================================
       AJAX FORM SUBMISSION
       ============================================================ */
    var form         = document.getElementById('sl-form');
    var submitBtn    = document.getElementById('sl-submit');
    var successPanel = document.getElementById('sl-form-success');
    var sendAgainBtn = document.getElementById('sl-send-again');

    /* Map field name → error element ID */
    var errorMap = {
        'name':        'sl-err-name',
        'email':       'sl-err-email',
        'whatsapp':    'sl-err-whatsapp',
        'defaultLink': 'sl-err-defaultLink',
        'customLink':  'sl-err-customLink',
        'note':        'sl-err-note',
    };

    function getWrapper(name) {
        var el = form.querySelector('[name="' + name + '"]');
        return el ? el.closest('.sl-form-group') : null;
    }

    function clearErrors() {
        Object.keys(errorMap).forEach(function (name) {
            var wrapper = getWrapper(name);
            var errEl   = document.getElementById(errorMap[name]);
            if (wrapper) wrapper.classList.remove('sl-invalid', 'sl-valid');
            if (errEl)   errEl.textContent = '';
        });
    }

    function showServerErrors(errors) {
        Object.keys(errors).forEach(function (name) {
            var wrapper = getWrapper(name);
            var errEl   = document.getElementById(errorMap[name]);
            if (wrapper) {
                wrapper.classList.add('sl-invalid');
                wrapper.classList.remove('sl-valid');
            }
            if (errEl) errEl.textContent = errors[name][0];
        });

        /* Scroll to first invalid field */
        var first = form.querySelector('.sl-form-group.sl-invalid input, .sl-form-group.sl-invalid textarea');
        if (first) first.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    /* Clear field error on user input */
    if (form) {
        Object.keys(errorMap).forEach(function (name) {
            var input = form.querySelector('[name="' + name + '"]');
            if (!input) return;
            input.addEventListener('input', function () {
                var wrapper = getWrapper(name);
                var errEl   = document.getElementById(errorMap[name]);
                if (wrapper) wrapper.classList.remove('sl-invalid');
                if (errEl)   errEl.textContent = '';
            });
        });
    }

    /* SweetAlert toast helper — below navbar (Fix #4) */
    function toast(icon, title) {
        if (typeof Swal === 'undefined') return;
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: icon,
            title: title,
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            customClass: { container: 'sl-swal-below-nav' },
        });
    }

    /* Submit handler */
    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            clearErrors();

            var data = new FormData(form);

            submitBtn.disabled = true;
            submitBtn.classList.add('sl-loading');

            fetch('{{ route("service.shortlink.strore") }}', {
                method: 'POST',
                body: data,
                headers: { 'X-Requested-With': 'XMLHttpRequest' },
            })
            .then(function (res) {
                if (res.status === 422) {
                    return res.json().then(function (body) {
                        showServerErrors(body.errors || {});
                        throw { handled: true };
                    });
                }
                if (!res.ok) throw { handled: false };
                return res.json();
            })
            .then(function () {
                /* Show success panel */
                form.style.display        = 'none';
                if (successPanel) successPanel.classList.add('sl-visible');
                toast('success', 'Permintaan berhasil dikirim!');
            })
            .catch(function (err) {
                if (err && err.handled) return; /* validation errors already shown */
                toast('error', 'Terjadi kesalahan. Silakan coba lagi.');
            })
            .finally(function () {
                submitBtn.disabled = false;
                submitBtn.classList.remove('sl-loading');
            });
        });
    }

    /* "Kirim Lagi" button — reset form and show it again */
    if (sendAgainBtn) {
        sendAgainBtn.addEventListener('click', function () {
            if (successPanel) successPanel.classList.remove('sl-visible');
            if (form) {
                form.style.display = '';
                form.reset();
                clearErrors();
            }
        });
    }

});
</script>
