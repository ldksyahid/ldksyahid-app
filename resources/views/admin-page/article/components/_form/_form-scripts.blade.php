<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Image preview
        const posterInput = document.getElementById('poster');
        const imagePreview = document.getElementById('imagePreview');
        const previewContainer = document.querySelector('.image-preview-container');

        if (posterInput && imagePreview) {
            posterInput.addEventListener('change', function(e) {
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
                        imagePreview.style.display = '';
                        var svgEl = imagePreview.parentElement.querySelector('.svg-placeholder');
                        if (svgEl) svgEl.style.display = 'none';
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
                const title = document.getElementById('title');
                const theme = document.getElementById('theme');
                const datearticle = document.getElementById('datearticle');
                const writer = document.getElementById('writer');
                const editor = document.getElementById('editor');
                const embedpdf = document.getElementById('embedpdf');
                const poster = document.getElementById('poster');
                const isCreateForm = form.action.includes('store');

                // Validate title
                if (title && !title.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Title Required!',
                        text: 'Please enter a title for the article.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    title.focus();
                    return;
                }

                // Validate theme
                if (theme && !theme.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Theme Required!',
                        text: 'Please enter a theme for the article.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    theme.focus();
                    return;
                }

                // Validate date
                if (datearticle && !datearticle.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Date Required!',
                        text: 'Please select a publish date.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    datearticle.focus();
                    return;
                }

                // Validate writer
                if (writer && !writer.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Writer Required!',
                        text: 'Please enter the writer name.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    writer.focus();
                    return;
                }

                // Validate editor
                if (editor && !editor.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Editor Required!',
                        text: 'Please enter the editor name.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    editor.focus();
                    return;
                }

                // Validate embed link
                if (embedpdf && !embedpdf.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Embed Link Required!',
                        text: 'Please enter the anyflip embed link.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    embedpdf.focus();
                    return;
                }

                // Validate poster for create
                if (isCreateForm && poster && !poster.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Poster Required!',
                        text: 'Please upload a poster image.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    poster.focus();
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
