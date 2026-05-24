<script>
(function () {
    'use strict';

    // ── File upload drag & drop ─────────────────────────────────────
    document.querySelectorAll('.gf-file-drop').forEach(function (drop) {
        var input    = drop.querySelector('input[type="file"]');
        var badge    = drop.querySelector('.gf-file-badge');
        var badgeTxt = badge ? badge.querySelector('span') : null;

        drop.addEventListener('click', function (e) {
            if (e.target !== input) input.click();
        });
        drop.addEventListener('dragover', function (e) {
            e.preventDefault();
            drop.classList.add('dragover');
        });
        drop.addEventListener('dragleave', function () {
            drop.classList.remove('dragover');
        });
        drop.addEventListener('drop', function (e) {
            e.preventDefault();
            drop.classList.remove('dragover');
            if (e.dataTransfer.files.length) {
                setFile(e.dataTransfer.files[0]);
                try { input.files = e.dataTransfer.files; } catch (_) {}
            }
        });
        input && input.addEventListener('change', function () {
            if (this.files && this.files[0]) setFile(this.files[0]);
            else resetFile();
        });

        function setFile(file) {
            if (badgeTxt) badgeTxt.textContent = file.name;
            if (badge) {
                badge.style.display = '';
                var ic = badge.querySelector('i');
                if (ic) ic.className = 'fas fa-file-check fa-xs';
            }
        }
        function resetFile() {
            if (badgeTxt) badgeTxt.textContent = 'Belum ada file dipilih';
        }
    });

    // ── Form config (injected from Blade) ───────────────────────────
    var gfIsMultiple = {{ $form->isMultipleSubmit ? 'true' : 'false' }};
    var gfFormSlug   = '{{ $form->slug }}';

    // ── AJAX form submission ────────────────────────────────────────
    var form = document.getElementById('publicFormSubmit');
    if (!form) return;

    form.addEventListener('submit', function (e) {
        e.preventDefault();

        var btn  = document.getElementById('gfSubmitBtn');
        var span = btn ? btn.querySelector('span') : null;
        var icon = btn ? btn.querySelector('i') : null;

        // Loading state on button
        if (btn) {
            btn.disabled = true;
            if (span) span.textContent = 'Mengirimkan...';
            if (icon) icon.className = 'fas fa-spinner fa-spin';
        }

        clearErrors();

        var csrfMeta = document.querySelector('meta[name="csrf-token"]');

        fetch(form.action, {
            method : 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN'    : csrfMeta ? csrfMeta.content : '',
            },
            body: new FormData(form),
        })
        .then(function (res) {
            return res.json().then(function (data) {
                return { status: res.status, data: data };
            });
        })
        .then(function (result) {
            var status = result.status;
            var data   = result.data;

            if (status === 200 && data.success) {
                // ── Success ──────────────────────────────────────────
                if (data.redirectUrl) {
                    window.location.href = data.redirectUrl;
                } else {
                    showSuccessCard(data.formTitle, data.confirmationMessage, data.isMultipleSubmit, data.formSlug);
                }
            } else if (status === 422 && data.errors) {
                // ── Validation errors ────────────────────────────────
                showValidationErrors(data.errors);
                restoreBtn(btn, span, icon);
            } else if (status === 429) {
                // ── Rate limit (throttle middleware or controller) ────
                showGeneralError('Terlalu banyak percobaan pengiriman. Silakan tunggu beberapa saat dan coba lagi.');
                restoreBtn(btn, span, icon);
            } else {
                // ── Server / closed error ─────────────────────────────
                showGeneralError(data.message || 'Terjadi kesalahan. Silakan coba lagi.');
                restoreBtn(btn, span, icon);
            }
        })
        .catch(function () {
            showGeneralError('Terjadi kesalahan jaringan. Periksa koneksi Anda dan coba lagi.');
            restoreBtn(btn, span, icon);
        });
    });

    // ── Helpers ─────────────────────────────────────────────────────

    function restoreBtn(btn, span, icon) {
        if (!btn) return;
        btn.disabled = false;
        if (span) span.textContent = 'Kirimkan Formulir';
        if (icon) icon.className = 'fas fa-paper-plane';
    }

    function clearErrors() {
        form.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        form.querySelectorAll('.gf-invalid').forEach(function (el) {
            el.textContent = '';
        });
        form.querySelectorAll('.gf-card.has-error').forEach(function (el) {
            el.classList.remove('has-error');
        });
        var gen = document.getElementById('gfGeneralError');
        if (gen) gen.remove();
    }

    function showGeneralError(message) {
        var wrap = document.querySelector('.gf-wrap');
        if (!wrap) return;
        var card = document.createElement('div');
        card.id        = 'gfGeneralError';
        card.className = 'gf-error-card';
        card.innerHTML = '<i class="fas fa-exclamation-triangle me-2"></i>' + escHtml(message);
        wrap.insertBefore(card, form);
        card.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function showValidationErrors(errors) {
        if (!errors) return;
        var firstCard = null;

        Object.keys(errors).forEach(function (key) {
            var msgs  = errors[key];
            if (!msgs || !msgs.length) return;

            var input = form.querySelector('[name="' + key + '"]') ||
                        form.querySelector('[name="' + key + '[]"]');
            if (!input) return;

            input.classList.add('is-invalid');
            var card = input.closest('.gf-card');
            if (card) {
                card.classList.add('has-error');
                var errEl = card.querySelector('.gf-invalid');
                if (errEl) errEl.textContent = msgs[0];
                if (!firstCard) firstCard = card;
            }
        });

        if (firstCard) firstCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
    }

    function showSuccessCard(formTitle, confirmationMessage, isMultiple, formSlug) {
        var wrap = document.querySelector('.gf-wrap');
        if (!wrap) return;

        // Fall back to Blade-injected values if server didn't return them
        if (typeof isMultiple === 'undefined') isMultiple = gfIsMultiple;
        if (typeof formSlug  === 'undefined') formSlug   = gfFormSlug;

        var bodyMsg = confirmationMessage
            ? escHtml(confirmationMessage)
            : 'Jazakumullahu Khairan atas partisipasi Anda dalam mengisi formulir <strong>' +
              escHtml(formTitle) +
              '</strong>. Respons Anda telah kami terima dan email konfirmasi akan segera dikirimkan.';

        var againLink = isMultiple
            ? '<div style="margin-top:.85rem;">' +
                  '<a href="/form/' + escHtml(formSlug) + '" class="gf-again-link">' +
                      '<i class="fas fa-redo"></i> Kirim jawaban lain' +
                  '</a>' +
              '</div>'
            : '';

        wrap.innerHTML =
            '<div class="gf-state-card" style="max-width:100%;">' +
                '<div class="gf-state-icon-wrap success"><i class="fas fa-check"></i></div>' +
                '<h3 class="gf-state-title">Alhamdulillah, Formulir Berhasil Dikirim!</h3>' +
                '<p class="gf-state-body">' + bodyMsg + '</p>' +
                '<div class="gf-divider"></div>' +
                '<a href="/" class="gf-home-btn">' +
                    '<i class="fas fa-home me-2"></i>' +
                    '<span>Kembali ke Beranda</span>' +
                '</a>' +
                againLink +
            '</div>';

        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function escHtml(str) {
        return String(str || '')
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;');
    }

})();
</script>
