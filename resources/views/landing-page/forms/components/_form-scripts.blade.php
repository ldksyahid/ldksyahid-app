<script>
(function () {
    'use strict';

    // ── File upload drag & drop ─────────────────────────────────────
    document.querySelectorAll('.gf-file-drop').forEach(function (drop) {
        var input  = drop.querySelector('input[type="file"]');
        var badge  = drop.querySelector('.gf-file-badge');
        var badgeTxt = badge ? badge.querySelector('span') : null;

        // Click on drop area → trigger input
        drop.addEventListener('click', function (e) {
            if (e.target !== input) input.click();
        });

        // Drag over
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
                // Attempt to set DataTransfer to input
                try { input.files = e.dataTransfer.files; } catch (_) {}
            }
        });

        // Input change
        input && input.addEventListener('change', function () {
            if (this.files && this.files[0]) {
                setFile(this.files[0]);
            } else {
                resetFile();
            }
        });

        function setFile(file) {
            if (badgeTxt) badgeTxt.textContent = file.name;
            if (badge) {
                badge.style.display = '';
                badge.querySelector('i').className = 'fas fa-file-check fa-xs';
            }
        }

        function resetFile() {
            if (badgeTxt) badgeTxt.textContent = 'Belum ada file dipilih';
        }
    });

    // ── Double-submit prevention ────────────────────────────────────
    var form = document.getElementById('publicFormSubmit');
    if (form) {
        form.addEventListener('submit', function () {
            var btn = document.getElementById('gfSubmitBtn');
            if (!btn) return;
            btn.disabled = true;
            var span = btn.querySelector('span');
            if (span) span.textContent = 'Mengirimkan...';
            var icon = btn.querySelector('i');
            if (icon) {
                icon.className = 'fas fa-spinner fa-spin';
            }
            // Restore after 12s in case of network/server issues
            setTimeout(function () {
                btn.disabled = false;
                if (span) span.textContent = 'Kirimkan Formulir';
                if (icon) icon.className = 'fas fa-paper-plane';
            }, 12000);
        });
    }
})();
</script>
