<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Character counter for testimony
        const testimonyInput = document.getElementById('testimony');
        const charCounter = document.getElementById('charCounter');
        const maxLength = 250;

        if (testimonyInput && charCounter) {
            function updateCharCounter() {
                const currentLength = testimonyInput.value.length;
                const remaining = maxLength - currentLength;
                charCounter.textContent = `${currentLength}/${maxLength} characters`;

                charCounter.classList.remove('warning', 'danger');
                if (remaining <= 20 && remaining > 0) {
                    charCounter.classList.add('warning');
                } else if (remaining <= 0) {
                    charCounter.classList.add('danger');
                }
            }

            testimonyInput.addEventListener('input', updateCharCounter);
            updateCharCounter(); // Initial count
        }

        // Image preview
        const pictureInput = document.getElementById('picture');
        const imagePreview = document.getElementById('imagePreview');
        const previewContainer = document.querySelector('.image-preview-container');

        if (pictureInput && imagePreview) {
            pictureInput.addEventListener('change', function(e) {
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
                        imagePreview.src = e.target.result;
                        if (previewContainer) {
                            previewContainer.classList.add('has-image');
                        }
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
                const profession = document.getElementById('profession');
                const testimony = document.getElementById('testimony');
                const picture = document.getElementById('picture');
                const isCreateForm = form.action.includes('store');

                // Validate name
                if (name && !name.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Name Required!',
                        text: 'Please enter a name for the testimony.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    name.focus();
                    return;
                }

                // Validate profession
                if (profession && !profession.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Profession Required!',
                        text: 'Please enter a profession.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    profession.focus();
                    return;
                }

                // Validate testimony
                if (testimony && !testimony.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Testimony Required!',
                        text: 'Please enter the testimony content.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    testimony.focus();
                    return;
                }

                // Validate picture for create
                if (isCreateForm && picture && !picture.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Picture Required!',
                        text: 'Please upload a profile picture.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    picture.focus();
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
