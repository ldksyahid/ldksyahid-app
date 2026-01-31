<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Group photo preview
        const groupPhotoInput = document.getElementById('groupPhoto');
        const groupPhotoPreview = document.getElementById('groupPhotoPreview');

        if (groupPhotoInput && groupPhotoPreview) {
            groupPhotoInput.addEventListener('change', function(e) {
                handleImagePreview(e, groupPhotoPreview, '.group-photo');
            });
        }

        // Additional photos preview (1-12)
        for (let i = 1; i <= 12; i++) {
            const photoInput = document.getElementById('photo' + i);
            const photoPreview = document.getElementById('photoPreview' + i);

            if (photoInput && photoPreview) {
                photoInput.addEventListener('change', function(e) {
                    handleImagePreview(e, photoPreview, null);
                });
            }
        }

        // Handle image preview function
        function handleImagePreview(e, previewElement, containerSelector) {
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
                    e.target.value = '';
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
                    e.target.value = '';
                    return;
                }

                // Show preview
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewElement.src = e.target.result;
                    previewElement.style.display = '';
                    var svgEl = previewElement.parentElement.querySelector('.svg-placeholder');
                    if (svgEl) svgEl.style.display = 'none';
                    if (containerSelector) {
                        const container = document.querySelector(containerSelector);
                        if (container) {
                            container.classList.add('has-image');
                        }
                    } else {
                        previewElement.closest('.image-preview-container').classList.add('has-image');
                    }
                };
                reader.readAsDataURL(file);
            }
        }

        // Form validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const eventName = document.getElementById('eventName');
                const eventTheme = document.getElementById('eventTheme');
                const eventDescription = document.getElementById('eventDescription');
                const groupPhoto = document.getElementById('groupPhoto');
                const isCreateForm = form.action.includes('store');

                // Validate event name
                if (eventName && !eventName.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Event Name Required!',
                        text: 'Please enter an event name.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    eventName.focus();
                    return;
                }

                // Validate event theme
                if (eventTheme && !eventTheme.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Event Theme Required!',
                        text: 'Please enter an event theme.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    eventTheme.focus();
                    return;
                }

                // Validate group photo for create
                if (isCreateForm && groupPhoto && !groupPhoto.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Group Photo Required!',
                        text: 'Please upload a group photo.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    groupPhoto.focus();
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
