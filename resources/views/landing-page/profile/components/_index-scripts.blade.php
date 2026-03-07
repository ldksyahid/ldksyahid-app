<script>
(function () {
    // --- Export PNG ---
    var downloadBtn = document.getElementById('prf-download');
    if (downloadBtn) {
        downloadBtn.addEventListener('click', function (e) {
            e.preventDefault();

            var navbar = document.getElementById('navbar');
            if (navbar) navbar.classList.remove('sticky-top');

            html2canvas(document.getElementById('photo'), {
                useCORS: true,
                allowTaint: false,
            }).then(function (canvas) {
                var link = document.createElement('a');
                link.href = canvas.toDataURL('image/png');
                link.download = 'Profilku.png';
                document.body.appendChild(link);
                link.click();
                document.body.removeChild(link);
            }).finally(function () {
                setTimeout(function () {
                    location.reload();
                }, 800);
            });
        });
    }
})();
</script>
