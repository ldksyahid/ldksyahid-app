<script>
(function () {
    // Auto-refresh Bisabiller balance every 5 minutes
    var REFRESH_INTERVAL = 5 * 60 * 1000;
    var balanceEl   = document.getElementById('bisabiller-balance-value');
    var refreshedEl = document.getElementById('bisabiller-balance-refreshed');

    function refreshBalance() {
        if (!balanceEl) return;
        fetch('{{ route("admin.celsyahid.withdrawal.balance") }}', {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
        })
        .then(function (r) { return r.json(); })
        .then(function (data) {
            if (data.balance !== undefined && data.balance !== null) {
                balanceEl.textContent = 'Rp ' + parseInt(data.balance).toLocaleString('id-ID');
            }
            if (refreshedEl) {
                var now = new Date();
                refreshedEl.textContent = now.getHours().toString().padStart(2,'0') + ':' + now.getMinutes().toString().padStart(2,'0');
            }
        })
        .catch(function () { /* silent */ });
    }

    setInterval(refreshBalance, REFRESH_INTERVAL);
})();
</script>
