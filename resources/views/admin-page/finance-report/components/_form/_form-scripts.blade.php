<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Select2
        const ldkElement = $('#ldkID');
        if (ldkElement.length && ldkElement.is('select')) {
            ldkElement.select2({
                placeholder: 'Select LDK Tag',
                width: '100%',
                dropdownPosition: 'below',
                allowClear: false,
                dropdownParent: ldkElement.closest('.mb-3')
            });
        }

        // PDF file validation
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

        // Form validation and submission
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
            if (ldkID && (!ldkID.value || ldkID.value === '')) {
                e.preventDefault();
                Swal.fire({
                    title: 'LDK Tag Required!',
                    text: 'Please select an LDK tag.',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                // Focus on Select2
                $(ldkID).select2('open');
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

        // Handle Select2 styling for error state
        $('select.select2-hidden-accessible').on('change', function() {
            if ($(this).hasClass('is-invalid')) {
                $(this).removeClass('is-invalid');
                $(this).next('.select2-container').find('.select2-selection').css('border-color', '#ced4da');
            }
        });

        // Apply error styling to Select2 when there's an error
        @error('ldkID')
            $(document).ready(function() {
                const ldkSelect = $('#ldkID');
                if (ldkSelect.length) {
                    ldkSelect.next('.select2-container').find('.select2-selection')
                        .css('border-color', '#dc3545')
                        .css('box-shadow', '0 0 0 0.2rem rgba(220, 53, 69, 0.25)');
                }
            });
        @enderror
    });
</script>
