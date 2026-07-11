@php
    $captchaEnabled = config('services.recaptcha_enabled', true) && config('recaptcha.api_site_key');
    $captchaType    = config('services.recaptcha_type', 'score');   // "score" | "checkbox"
    $siteKey        = config('recaptcha.api_site_key');
@endphp

@if($captchaEnabled)
    @if($captchaType === 'checkbox')
        {{-- Enterprise checkbox: visible widget, user must tick --}}
        <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
        @if($errors->has('g-recaptcha-response'))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                if (window.grecaptcha && window.grecaptcha.enterprise) {
                    grecaptcha.enterprise.ready(function () { grecaptcha.enterprise.reset(); });
                } else {
                    var iv = setInterval(function () {
                        if (window.grecaptcha && window.grecaptcha.enterprise) {
                            clearInterval(iv);
                            grecaptcha.enterprise.ready(function () { grecaptcha.enterprise.reset(); });
                        }
                    }, 300);
                }
            });
        </script>
        @endif
    @else
        {{-- Enterprise score-based: invisible, token injected by JS before submit --}}
        <script src="https://www.google.com/recaptcha/enterprise.js?render={{ $siteKey }}"></script>
    @endif
@endif

<script>
(function () {
    'use strict';

    var formAlreadySubmitted = false;
    var DN_SUBMIT_KEY = 'dn_submitting';

    window.addEventListener('pageshow', function (e) {
        if (e.persisted) {
            // Page restored from bfcache (browser Back button).
            // If a submission was in-flight, keep the form locked — don't allow
            // the user to submit again while the first request is still running.
            if (localStorage.getItem(DN_SUBMIT_KEY)) {
                formAlreadySubmitted = true;
                document.querySelectorAll('.dn-form [type="submit"]').forEach(function (btn) {
                    btn.disabled = true;
                    btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Sedang diproses...';
                });
                return;
            }
            // No in-flight submission — normal reset (e.g. came back after a gateway error).
            formAlreadySubmitted = false;
            var tokenEl = document.getElementById('dn-recaptcha-token');
            if (tokenEl) tokenEl.value = '';
            document.querySelectorAll('.dn-form [type="submit"]').forEach(function (btn) {
                btn.disabled = false;
                btn.innerHTML = btn.dataset.originalText || btn.innerHTML;
            });
        } else {
            // Fresh page load (server redirect) — clear any stale in-flight flag.
            localStorage.removeItem(DN_SUBMIT_KEY);
        }
    });

    /* ── Rupiah formatter ────────────────────────────────────── */
    function formatRupiah(raw) {
        var digits = raw.toString().replace(/[^\d]/g, '');
        if (!digits) return '';
        var parts  = [];
        while (digits.length > 3) {
            parts.unshift(digits.slice(-3));
            digits = digits.slice(0, -3);
        }
        if (digits) parts.unshift(digits);
        return 'Rp' + parts.join('.');
    }

    function parseRupiah(val) {
        return parseInt(val.toString().replace(/[^\d]/g, '') || '0', 10);
    }

    /* ── Amount input ────────────────────────────────────────── */
    var amountInput = document.getElementById('dn-amount-input');
    var totalValue  = document.getElementById('dn-total-value');
    var totalInput  = document.getElementById('dn-total-input');
    var presetBtns  = document.querySelectorAll('.dn-preset-btn');

    function syncTotal(val) {
        var amount   = val ? parseInt(val.toString().replace(/[^\d]/g, ''), 10) : 0;
        var adminFee = Math.round(amount * 0.01);
        var total    = amount + adminFee;

        var display = total ? formatRupiah(total) : 'Rp0';
        if (totalValue) totalValue.textContent = display;
        if (totalInput) totalInput.value = display;

        var breakdownEl = document.getElementById('dn-fee-breakdown');
        var donasiEl    = document.getElementById('dn-breakdown-donasi');
        var adminEl     = document.getElementById('dn-breakdown-admin');
        if (breakdownEl) breakdownEl.style.display = amount > 0 ? '' : 'none';
        if (donasiEl)    donasiEl.textContent    = amount   ? formatRupiah(amount)   : 'Rp0';
        if (adminEl)     adminEl.textContent     = adminFee ? formatRupiah(adminFee) : 'Rp0';
    }

    if (amountInput) {
        amountInput.addEventListener('input', function () {
            var raw = this.value.replace(/[^\d]/g, '');
            var fmt = raw ? 'Rp' + raw.replace(/\B(?=(\d{3})+(?!\d))/g, '.') : '';
            // reformat
            var cursor = this.selectionStart;
            var oldLen = this.value.length;
            this.value = fmt;
            var newLen = this.value.length;
            this.setSelectionRange(cursor + (newLen - oldLen), cursor + (newLen - oldLen));
            syncTotal(raw);
            // remove active from presets
            presetBtns.forEach(function (b) { b.classList.remove('active'); });
        });
    }

    presetBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            var raw = this.dataset.value;
            if (amountInput) amountInput.value = formatRupiah(raw);
            syncTotal(raw);
            presetBtns.forEach(function (b) { b.classList.remove('active'); });
            this.classList.add('active');
        });
    });

    /* ── Anonymous toggle ──────────────────────────────────────
       Keep the real name in the field (stored for admin/receipt);
       only flip the hidden flag that masks the name on the public
       donor list. ───────────────────────────────────────────── */
    var anonCheck = document.getElementById('dn-anon-check');
    var anonInput = document.getElementById('dn-anon-input');

    if (anonCheck && anonInput) {
        anonCheck.addEventListener('change', function () {
            anonInput.value = this.checked ? '1' : '0';
        });
    }

    /* ── Phone / age: numbers only ──────────────────────────── */
    document.querySelectorAll('.dn-num-only').forEach(function (el) {
        el.addEventListener('keypress', function (e) {
            var ch = e.which || e.keyCode;
            if (ch > 31 && (ch < 48 || ch > 57)) e.preventDefault();
        });
        el.addEventListener('input', function () {
            this.value = this.value.replace(/[^\d]/g, '');
        });
    });

    /* ── Phone country code: update placeholder dynamically ─── */
    var phoneCodeEl  = document.getElementById('dn-phone-code');
    var phoneLocalEl = document.getElementById('dn-telpon-local');

    function updatePhonePlaceholder() {
        if (!phoneCodeEl || !phoneLocalEl) return;
        var selected = phoneCodeEl.options[phoneCodeEl.selectedIndex];
        phoneLocalEl.placeholder = selected.getAttribute('data-placeholder') || 'xxxxxxxxxx';
    }

    if (phoneCodeEl) {
        phoneCodeEl.addEventListener('change', updatePhonePlaceholder);
        updatePhonePlaceholder();
    }

    /* Combine country code + local number into the hidden field. */
    function buildFullPhone() {
        if (!phoneCodeEl || !phoneLocalEl) return;
        var code  = phoneCodeEl.value;
        var local = phoneLocalEl.value.replace(/[^\d]/g, '').replace(/^0+/, '');
        var fullEl = document.getElementById('dn-telpon-full');
        if (fullEl) fullEl.value = local ? code + local : '';
    }

    /* ── Form validation + submit ────────────────────────────── */
    var forms = document.querySelectorAll('.dn-form');
    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();
            e.stopImmediatePropagation();

            // Prevent double-submission (e.g. rapid double-click or bfcache replay).
            if (formAlreadySubmitted) return;
            formAlreadySubmitted = true;

            var valid = true;
            var firstInvalidEl = null;

            // 1. Amount — re-read from DOM each time so the reference is fresh.
            var amtEl = document.getElementById('dn-amount-input');
            if (amtEl) {
                var raw = amtEl.value.replace(/[^\d]/g, '');
                if (!raw || parseInt(raw, 10) < 1000) {
                    amtEl.classList.add('is-invalid');
                    if (!firstInvalidEl) firstInvalidEl = amtEl;
                    valid = false;
                } else {
                    amtEl.classList.remove('is-invalid');
                }
            }

            // 2. Select2 fields — native .value stays in sync with Select2 selection.
            // checkValidity() skips hidden elements, so we check these manually.
            ['dn-domisili', 'dn-pekerjaan'].forEach(function (id) {
                var el   = document.getElementById(id);
                var wrap = el && el.closest('.dn-select-wrap');
                var msg  = wrap && wrap.nextElementSibling;
                var empty = !el || !el.value;
                if (wrap) wrap.classList[empty ? 'add' : 'remove']('is-invalid');
                if (msg && msg.classList.contains('dn-invalid-msg')) {
                    msg.style.display = empty ? '' : 'none';
                }
                if (empty) {
                    if (!firstInvalidEl) firstInvalidEl = wrap || el;
                    valid = false;
                }
            });

            // 3. All other required fields (nama, email, telpon, usia, etc.)
            if (!form.checkValidity()) {
                valid = false;
            }
            form.classList.add('was-validated');

            // Scroll to first invalid field so user knows what to fix.
            if (!valid) {
                formAlreadySubmitted = false;
                if (firstInvalidEl) {
                    firstInvalidEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
                }
                return;
            }

            // All validations passed — build combined phone then disable button.
            buildFullPhone();

            var btn = form.querySelector('[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            }

            @if($captchaEnabled && $captchaType === 'score')
            // Score-based: fetch Enterprise token async, then submit.
            // tokenSubmitted guards against the .then() callback firing more
            // than once (defensive — should not happen, but prevents double POST).
            var tokenSubmitted = false;
            grecaptcha.enterprise.ready(function () {
                grecaptcha.enterprise.execute('{{ $siteKey }}', { action: 'submit_donation' })
                    .then(function (token) {
                        if (tokenSubmitted) return;
                        tokenSubmitted = true;
                        var tokenEl = document.getElementById('dn-recaptcha-token');
                        if (tokenEl) tokenEl.value = token;
                        localStorage.setItem(DN_SUBMIT_KEY, '1');
                        form.submit();
                    })
                    .catch(function () {
                        formAlreadySubmitted = false;
                        if (btn) {
                            btn.disabled = false;
                            btn.innerHTML = btn.dataset.originalText || btn.innerHTML;
                        }
                    });
            });
            @else
            localStorage.setItem(DN_SUBMIT_KEY, '1');
            form.submit();
            @endif
        });
    });

})();
</script>

<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function () {
    var $domisili  = $('#dn-domisili');
    var $pekerjaan = $('#dn-pekerjaan');

    $domisili.select2({
        placeholder: 'Pilih Kota',
        allowClear: false,
        width: '100%',
        minimumResultsForSearch: 8,
        dropdownParent: $('body')
    });
    $pekerjaan.select2({
        placeholder: 'Cari atau pilih pekerjaan…',
        allowClear: false,
        width: '100%',
        minimumInputLength: 0,
        dropdownParent: $('body'),
        ajax: {
            url: '{{ route("service.celengansyahid.api.jobs") }}',
            dataType: 'json',
            delay: 200,
            data: function (params) { return { q: params.term || '' }; },
            processResults: function (data) { return { results: data.results }; },
            cache: true
        }
    });

    function clearSelectError($sel) {
        $sel.closest('.dn-select-wrap').removeClass('is-invalid');
        $sel.closest('.dn-field').find('.dn-invalid-msg').hide();
    }

    $domisili.on('select2:select',  function () { clearSelectError($(this)); });
    $pekerjaan.on('select2:select', function () { clearSelectError($(this)); });

    /* ── Phone code Select2 ────────────────────────────────── */
    $('#dn-phone-code').select2({
        dropdownParent: $('body'),
        dropdownCssClass: 'dn-phone-dropdown',
        width: 'auto',
        minimumResultsForSearch: 0,
        templateResult: function (opt) {
            if (!opt.id) return opt.text;
            var el = opt.element;
            return $('<span class="d-flex align-items-center gap-2">' +
                '<span class="pc-flag">'  + ($(el).data('flag') || '') + '</span>' +
                '<span class="pc-code">+' + opt.id + '</span>' +
                '<span class="pc-name">'  + ($(el).data('name') || '') + '</span>' +
            '</span>');
        },
        templateSelection: function (opt) {
            if (!opt.id) return opt.text;
            var el = opt.element;
            return $('<span>' + ($(el).data('flag') || '') + ' <strong>+' + opt.id + '</strong></span>');
        },
    });

    $('#dn-phone-code').on('select2:select', function () {
        // updatePhonePlaceholder lives in the IIFE scope — replicate inline here.
        var localEl  = document.getElementById('dn-telpon-local');
        var selected = this.options[this.selectedIndex];
        if (localEl && selected) {
            localEl.placeholder = selected.getAttribute('data-placeholder') || 'xxxxxxxxxx';
        }
    });
});
</script>
