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
                // Notify multi-step navigator (if active) to go to error section first
                document.dispatchEvent(new CustomEvent('gf:validationErrors', { detail: data.errors }));
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
            showGeneralError('Terjadi kesalahan jaringan. Periksa koneksi kamu dan coba lagi.');
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
            : 'Alhamdulillah, jawaban kamu telah berhasil kami terima. Jazakumullahu Khairan atas partisipasi kamu, semoga Allah membalas kebaikan kamu dan memudahkan segala urusan kamu.';

        var againLink = isMultiple
            ? '<a href="/form/' + escHtml(formSlug) + '" class="gf-again-link">Kirim jawaban lain</a>'
            : '';

        wrap.innerHTML =
            '<div class="gf-state-card">' +
                '<h2 class="gf-state-form-title">' + escHtml(formTitle) + '</h2>' +
                '<p class="gf-state-body">' + bodyMsg + '</p>' +
                againLink +
                '<a href="/" class="gf-again-link"><i class="fas fa-home" style="margin-right:.3rem;"></i>Kembali ke beranda</a>' +
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

@if($isMultiStep ?? false)
<script>
(function () {
    'use strict';

    // ── Multi-step section navigation ───────────────────────────────
    var sections     = Array.from(document.querySelectorAll('.gf-form-section'));
    var totalSecs    = sections.length;
    var currentIndex = 0;

    // Show the first section on load (already has class 'active' from Blade)

    window.gfNextSection = function () {
        if (!validateSection(currentIndex)) return;
        goTo(currentIndex + 1);
    };

    window.gfPrevSection = function () {
        goTo(currentIndex - 1);
    };

    function goTo(index) {
        if (index < 0 || index >= totalSecs) return;
        sections[currentIndex].classList.remove('active');
        sections[index].classList.add('active');
        currentIndex = index;
        updateProgress();
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

    function updateProgress() {
        var label = document.getElementById('gfProgressLabel');
        var bar   = document.getElementById('gfProgressBar');
        var dots  = document.querySelectorAll('.gf-dot');

        if (label) label.textContent = 'Bagian ' + (currentIndex + 1) + ' dari ' + totalSecs;
        if (bar)   bar.style.width  = Math.round(((currentIndex + 1) / totalSecs) * 100) + '%';
        dots.forEach(function (dot, i) {
            dot.classList.toggle('active', i === currentIndex);
            dot.classList.toggle('done',   i < currentIndex);
        });
    }

    // Validate required fields in the current section before advancing
    function validateSection(index) {
        var section = sections[index];
        var valid   = true;

        // Clear previous section-level errors
        section.querySelectorAll('.is-invalid').forEach(function (el) {
            el.classList.remove('is-invalid');
        });
        section.querySelectorAll('.gf-invalid').forEach(function (el) {
            el.textContent = '';
        });
        section.querySelectorAll('.gf-card.has-error').forEach(function (el) {
            el.classList.remove('has-error');
        });

        var firstErrorCard = null;

        section.querySelectorAll('[required]').forEach(function (input) {
            var empty = false;

            if (input.type === 'checkbox') {
                var name    = input.name.replace('[]', '');
                var checked = section.querySelectorAll('[name="' + input.name + '"]:checked, [name="' + name + '[]"]:checked');
                if (!checked.length) empty = true;
            } else if (input.type === 'radio') {
                var radios  = section.querySelectorAll('[name="' + input.name + '"]:checked');
                if (!radios.length) empty = true;
            } else if (input.type === 'file') {
                if (!input.files || !input.files.length) empty = true;
            } else {
                if (!input.value.trim()) empty = true;
            }

            if (empty) {
                valid = false;
                input.classList.add('is-invalid');
                var card = input.closest('.gf-card');
                if (card) {
                    card.classList.add('has-error');
                    var errEl = card.querySelector('.gf-invalid');
                    if (errEl && !errEl.textContent) errEl.textContent = 'Kolom ini wajib diisi.';
                    if (!firstErrorCard) firstErrorCard = card;
                }
            }
        });

        if (firstErrorCard) firstErrorCard.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return valid;
    }

    // After server-side validation error: navigate to the section containing the first error
    // Override the form submission error handler's behaviour
    var origShowValidation = window._gfShowValidationErrors;
    document.addEventListener('gf:validationErrors', function (e) {
        var errors = e.detail;
        if (!errors) return;
        var form = document.getElementById('publicFormSubmit');
        if (!form) return;

        var targetSection = null;
        Object.keys(errors).forEach(function (key) {
            if (targetSection !== null) return;
            var input = form.querySelector('[name="' + key + '"]') ||
                        form.querySelector('[name="' + key + '[]"]');
            if (!input) return;
            var sec = input.closest('.gf-form-section');
            if (sec) targetSection = parseInt(sec.getAttribute('data-section'), 10);
        });

        if (targetSection !== null && targetSection !== currentIndex) {
            goTo(targetSection);
        }
    });

})();
</script>
@endif
