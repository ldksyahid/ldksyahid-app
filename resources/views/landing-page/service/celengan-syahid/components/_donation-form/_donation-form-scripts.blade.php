@if(config('services.recaptcha_enabled', true) && config('recaptcha.api_site_key'))
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
@if($errors->has('g-recaptcha-response'))
{{-- Reset widget jika ada error captcha supaya user dapat token baru --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        if (window.grecaptcha) {
            grecaptcha.ready(function () { grecaptcha.reset(); });
        } else {
            // Tunggu api.js selesai load
            var iv = setInterval(function () {
                if (window.grecaptcha) {
                    clearInterval(iv);
                    grecaptcha.ready(function () { grecaptcha.reset(); });
                }
            }, 300);
        }
    });
</script>
@endif
@endif

<script>
(function () {
    'use strict';

    // Reset submit button if browser restores page from bfcache (Back navigation).
    // Without this, the button stays disabled after the user navigates back.
    window.addEventListener('pageshow', function (e) {
        if (e.persisted) {
            document.querySelectorAll('.dn-form [type="submit"]').forEach(function (btn) {
                btn.disabled = false;
                btn.innerHTML = btn.dataset.originalText || btn.innerHTML;
            });
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
        var display = val ? formatRupiah(val) : 'Rp0';
        if (totalValue) totalValue.textContent = display;
        if (totalInput) totalInput.value = display;
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

    /* ── Bootstrap form validation + reCAPTCHA Enterprise ───── */
    var forms = document.querySelectorAll('.dn-form');
    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            // Validate amount manually
            if (amountInput) {
                var raw = amountInput.value.replace(/[^\d]/g, '');
                if (!raw || parseInt(raw, 10) < 1000) {
                    amountInput.classList.add('is-invalid');
                    amountInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                } else {
                    amountInput.classList.remove('is-invalid');
                }
            }

            // Validate Select2 fields with native DOM — browsers skip hidden
            // elements so checkValidity() misses them. Select2 keeps the
            // underlying <select> value in sync, so native .value is reliable.
            var select2Valid = true;
            ['dn-domisili', 'dn-pekerjaan'].forEach(function (id) {
                var el   = document.getElementById(id);
                var wrap = el && el.closest('.dn-select-wrap');
                var msg  = wrap && wrap.nextElementSibling;
                var empty = !el || !el.value;
                if (wrap) {
                    wrap.classList[empty ? 'add' : 'remove']('is-invalid');
                }
                if (msg && msg.classList.contains('dn-invalid-msg')) {
                    msg.style.display = empty ? '' : 'none';
                }
                if (empty) select2Valid = false;
            });
            if (!select2Valid) return;

            if (!form.checkValidity()) {
                form.classList.add('was-validated');
                return;
            }
            form.classList.add('was-validated');

            // Disable submit button to prevent double-click
            var btn = form.querySelector('[type="submit"]');
            if (btn) {
                btn.disabled = true;
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Memproses...';
            }

            // Submit — token reCAPTCHA v2 sudah auto-terisi oleh checkbox widget
            form.submit();
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
});
</script>
