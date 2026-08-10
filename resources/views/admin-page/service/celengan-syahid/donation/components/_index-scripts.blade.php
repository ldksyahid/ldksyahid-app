<script>
    // Export the donation list as CSV, carrying the active column filters.
    function exportDonationsCsv() {
        var base   = @json(route('admin.service.export.donation'));
        var params = new URLSearchParams();
        ['nama_donatur', 'jumlah_donasi', 'payment_status', 'metode_pembayaran', 'campaign_id', 'created_at'].forEach(function (name) {
            var el = document.querySelector('[name="' + name + '"]');
            if (el && el.value) params.set(name, el.value);
        });
        var qs = params.toString();
        window.location = base + (qs ? '?' + qs : '');
    }
</script>
