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

    // Update filename display when user picks a file
    var fileInput = document.getElementById('inputprofilepicture');
    var fileName  = document.getElementById('prf-file-name');
    if (fileInput && fileName) {
        fileInput.addEventListener('change', function () {
            if (this.files.length) {
                fileName.textContent = this.files[0].name;
                fileName.classList.remove('prf-file-name-display--set');
                fileName.style.color = '#1f2937';
            }
        });
    }
})();
</script>
