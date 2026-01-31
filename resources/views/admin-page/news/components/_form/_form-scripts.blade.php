<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Initialize Summernote
        $('.summernote').summernote({
            height: 400,
            minHeight: 300,
            maxHeight: 800,
            focus: false,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic', 'clear']],
                ['fontname', ['fontname']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Georgia', 'Helvetica', 'Impact', 'Tahoma', 'Times New Roman', 'Trebuchet MS', 'Verdana'],
            fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '20', '24', '28', '36', '48', '64', '72'],
            callbacks: {
                onInit: function() {
                    $('body > .note-popover').hide();
                }
            }
        });

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
                const datepublish = document.getElementById('datepublish');
                const publisher = document.getElementById('publisher');
                const reporter = document.getElementById('reporter');
                const editor = document.getElementById('editor');
                const picture = document.getElementById('picture');
                const descpicture = document.getElementById('descpicture');
                const body = document.getElementById('body');
                const isCreateForm = form.action.includes('store');

                // Validate title
                if (title && !title.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Title Required!',
                        text: 'Please enter a title for the news.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    title.focus();
                    return;
                }

                // Validate date publish
                if (datepublish && !datepublish.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Date Publish Required!',
                        text: 'Please select a publish date.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    datepublish.focus();
                    return;
                }

                // Validate picture for create
                if (isCreateForm && picture && !picture.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Picture Required!',
                        text: 'Please upload a picture for the news.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    picture.focus();
                    return;
                }

                // Validate body content
                const bodyContent = $('.summernote').summernote('code');
                if (!bodyContent || bodyContent === '<p><br></p>' || bodyContent.trim() === '') {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Content Required!',
                        text: 'Please write the news content.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    $('.summernote').summernote('focus');
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
