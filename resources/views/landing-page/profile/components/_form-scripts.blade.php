<script>
(function () {
    'use strict';
    // Bootstrap form validation
    var forms = document.querySelectorAll('.prf-needs-validation');
    forms.forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Show selected filename for file input
    var fileInput = document.getElementById('inputprofilepicture');
    var fileHint  = document.getElementById('prf-file-hint');
    if (fileInput && fileHint) {
        fileInput.addEventListener('change', function () {
            fileHint.textContent = this.files.length
                ? this.files[0].name
                : 'Tidak ada file dipilih';
        });
    }
})();
</script>
