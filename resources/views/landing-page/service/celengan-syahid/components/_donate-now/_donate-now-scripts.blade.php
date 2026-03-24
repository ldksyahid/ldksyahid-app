<script>
(function () {
    'use strict';

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

    /* ── Anonymous toggle ────────────────────────────────────── */
    var anonCheck = document.getElementById('dn-anon-check');
    var nameInput = document.getElementById('dn-nama-donatur');

    if (anonCheck && nameInput) {
        anonCheck.addEventListener('change', function () {
            if (this.checked) {
                nameInput.dataset.realValue = nameInput.value;
                nameInput.value    = 'Manusia Baik';
                nameInput.readOnly = true;
            } else {
                nameInput.value    = nameInput.dataset.realValue || '';
                nameInput.readOnly = false;
            }
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

    /* ── Bootstrap form validation ───────────────────────────── */
    var forms = document.querySelectorAll('.dn-form');
    forms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            // Validate amount manually
            if (amountInput) {
                var raw = amountInput.value.replace(/[^\d]/g, '');
                if (!raw || parseInt(raw, 10) < 1000) {
                    amountInput.classList.add('is-invalid');
                    e.preventDefault();
                    e.stopPropagation();
                    amountInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    return;
                } else {
                    amountInput.classList.remove('is-invalid');
                }
            }
            if (!form.checkValidity()) {
                e.preventDefault();
                e.stopPropagation();
            }
            form.classList.add('was-validated');
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

    // Visual validation for Select2 fields on form submit
    $('.dn-form').on('submit.dnS2', function () {
        [$domisili, $pekerjaan].forEach(function ($sel) {
            var $wrap = $sel.closest('.dn-select-wrap');
            var $msg  = $wrap.next('.dn-invalid-msg');
            if (!$sel.val()) {
                $wrap.addClass('is-invalid');
                $msg.show();
            } else {
                $wrap.removeClass('is-invalid');
                $msg.hide();
            }
        });
    });
});
</script>
