<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Photo profile preview
        const photoInput = document.getElementById('photoProfile');
        const photoPreview = document.getElementById('photoProfilePreview');

        if (photoInput && photoPreview) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    // Validate file type
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        Swal.fire({
                            title: 'Invalid File Type!',
                            text: 'Please upload only JPG, JPEG, PNG, or WebP images.',
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
                        photoPreview.src = e.target.result;
                        photoPreview.style.display = '';
                        var svgEl = photoPreview.parentElement.querySelector('.svg-placeholder');
                        if (svgEl) svgEl.style.display = 'none';
                        photoPreview.closest('.image-preview-container').classList.add('has-image');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Form validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const name = document.getElementById('name');
                const forkat = document.getElementById('forkat');
                const position = document.getElementById('position');

                if (name && !name.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Name Required!',
                        text: 'Please enter a name.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    name.focus();
                    return;
                }

                if (forkat && !forkat.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Forkat Required!',
                        text: 'Please enter a forkat.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    forkat.focus();
                    return;
                }

                if (position && !position.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Position Required!',
                        text: 'Please enter a position.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    position.focus();
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
