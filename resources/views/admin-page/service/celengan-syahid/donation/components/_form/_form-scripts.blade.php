<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function () {

    // --- Select2 for all dropdowns ---
    $('#da-campaign').select2({
        placeholder: '-- Select Campaign --',
        allowClear: true,
        width: '100%',
    });

    $('#da-metode').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
    });

    $('#da-status').select2({
        minimumResultsForSearch: Infinity,
        width: '100%',
    });

    // --- Rupiah formatting for Donation Amount ---
    var $display = $('#da-jumlah-display');
    var $hidden  = $('#da-jumlah-hidden');

    function formatRupiah(angka) {
        var str = angka.replace(/[^\d]/g, '');
        if (!str) return '';
        var sisa   = str.length % 3;
        var result = str.substr(0, sisa);
        var ribuan = str.substr(sisa).match(/\d{3}/gi);
        if (ribuan) {
            result += (sisa ? '.' : '') + ribuan.join('.');
        }
        return 'Rp' + result;
    }

    function parseRupiah(str) {
        return parseInt(str.replace(/[^\d]/g, ''), 10) || 0;
    }

    if ($display.length) {
        // Format on input
        $display.on('input', function () {
            var raw = parseRupiah(this.value);
            $hidden.val(raw || '');
            this.value = raw ? formatRupiah(String(raw)) : '';
        });

        // Format initial value on page load (edit mode)
        if ($hidden.val()) {
            $display.val(formatRupiah(String($hidden.val())));
        }
    }

    // --- Auto-set Payment Status to PAID when method is CASH ---
    var $method = $('#da-metode');
    var $status = $('#da-status');

    function syncStatus() {
        if ($method.val() === 'CASH') {
            $status.val('PAID').trigger('change.select2');
        }
    }

    if ($method.length && $status.length) {
        $method.on('change', syncStatus);
        syncStatus();
    }

    // --- Submit loading state ---
    $('form.da-form').on('submit', function () {
        var $btn = $(this).find('button[type="submit"]');
        if ($btn.length) {
            $btn.prop('disabled', true)
                .html('<i class="fa fa-spinner fa-spin me-1"></i> Saving...');
        }
    });

});
</script>
