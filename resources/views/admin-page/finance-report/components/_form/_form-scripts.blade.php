<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Select2 for LDK tag dropdown (only for create/edit mode)
        const ldkElement = $('#ldkID');
        if (ldkElement.length && ldkElement.is('select')) {
            ldkElement.select2({
                placeholder: 'Select LDK Tag',
                width: '100%',
                dropdownPosition: 'below'
            });
        }

        // PDF file validation (only for create/edit mode)
        const pdfFileInput = document.getElementById('pdfFile');
        if (pdfFileInput) {
            pdfFileInput.addEventListener('change', function(event) {
                const file = event.target.files[0];
                if (file) {
                    // Check file type
                    if (file.type !== 'application/pdf') {
                        Swal.fire({
                            title: 'Invalid File Type!',
                            text: 'Please upload only PDF files.',
                            icon: 'error',
                            confirmButtonColor: '#00a79d'
                        });
                        this.value = '';
                        return;
                    }

                    // Check file size (5MB max)
                    if (file.size > 5 * 1024 * 1024) {
                        Swal.fire({
                            title: 'File Too Large!',
                            text: 'PDF file must be less than 5MB.',
                            icon: 'error',
                            confirmButtonColor: '#00a79d'
                        });
                        this.value = '';
                        return;
                    }
                }
            });
        }

        // Form validation and submission (only for create/edit mode)
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const fileName = document.getElementById('fileName');
            const ldkID = document.getElementById('ldkID');
            const pdfFile = document.getElementById('pdfFile');

            // Validate file name
            if (fileName && !fileName.value.trim()) {
                e.preventDefault();
                Swal.fire({
                    title: 'File Name Required!',
                    text: 'Please enter a file name for the report.',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                fileName.focus();
                return;
            }

            // Validate LDK tag
            if (ldkID && !ldkID.value) {
                e.preventDefault();
                Swal.fire({
                    title: 'LDK Tag Required!',
                    text: 'Please select an LDK tag.',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                ldkID.focus();
                return;
            }

            // Validate PDF file for create operation
            const isCreateForm = this.action.includes('store');
            if (isCreateForm && pdfFile && !pdfFile.value) {
                e.preventDefault();
                Swal.fire({
                    title: 'PDF File Required!',
                    text: 'Please upload a PDF file for the finance report.',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                pdfFile.focus();
                return;
            }

            // Show loading on form submit
            const submitBtn = $(this).find('button[type="submit"]');
            if (submitBtn.length) {
                submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Processing...');
            }
        });

        // Show success message if exists
        @if(session('success'))
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}'
            });
        @endif
    });
</script>
