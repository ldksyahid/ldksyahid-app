<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Image preview for logo
        const logoInput = document.getElementById('structureLogo');
        const logoPreview = document.getElementById('logoPreview');
        const logoPreviewContainer = document.querySelector('#logoPreview').closest('.image-preview-container');

        if (logoInput && logoPreview) {
            logoInput.addEventListener('change', function(e) {
                handleImagePreview(e, logoPreview, logoPreviewContainer);
            });
        }

        // Image preview for structure image
        const imageInput = document.getElementById('structureImage');
        const imagePreview = document.getElementById('imagePreview');
        const imagePreviewContainer = document.querySelector('#imagePreview').closest('.image-preview-container');

        if (imageInput && imagePreview) {
            imageInput.addEventListener('change', function(e) {
                handleImagePreview(e, imagePreview, imagePreviewContainer);
            });
        }

        function handleImagePreview(e, previewElement, previewContainer) {
            const file = e.target.files[0];
            if (file) {
                // Validate file type
                const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                if (!validTypes.includes(file.type)) {
                    Swal.fire({
                        title: 'Invalid File Type!',
                        text: 'Please upload only JPG, JPEG, or PNG images.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    this.value = '';
                    return;
                }

                // Validate file size (5MB max)
                if (file.size > 5 * 1024 * 1024) {
                    Swal.fire({
                        title: 'File Too Large!',
                        text: 'Image must be less than 5MB.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    this.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewElement.src = e.target.result;
                    if (previewContainer) {
                        previewContainer.classList.add('has-image');
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        // Form validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const batch = document.getElementById('batch');
                const period = document.getElementById('period');
                const structureName = document.getElementById('structureName');
                const structureDescription = document.getElementById('structureDescription');
                const structureLogo = document.getElementById('structureLogo');
                const structureImage = document.getElementById('structureImage');
                const isCreateForm = form.action.includes('store');

                // Validate batch
                if (batch && !batch.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Batch Required!',
                        text: 'Please enter a batch.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    batch.focus();
                    return;
                }

                // Validate period
                if (period && !period.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Period Required!',
                        text: 'Please enter a period.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    period.focus();
                    return;
                }

                // Validate structure name
                if (structureName && !structureName.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Structure Name Required!',
                        text: 'Please enter a structure name.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    structureName.focus();
                    return;
                }

                // Validate structure description
                if (structureDescription && !structureDescription.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Description Required!',
                        text: 'Please enter a structure description.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    structureDescription.focus();
                    return;
                }

                // Validate logo for create
                if (isCreateForm && structureLogo && !structureLogo.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Logo Required!',
                        text: 'Please upload a logo for the structure.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    structureLogo.focus();
                    return;
                }

                // Validate structure image for create
                if (isCreateForm && structureImage && !structureImage.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Structure Image Required!',
                        text: 'Please upload a structure image.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    structureImage.focus();
                    return;
                }

                // Show loading
                const submitBtn = $(form).find('button[type="submit"]');
                if (submitBtn.length) {
                    submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Processing...');
                }
            });
        }

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

        // Show error message if exists
        @if(session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                confirmButtonColor: '#00a79d'
            });
        @endif
    });
</script>
