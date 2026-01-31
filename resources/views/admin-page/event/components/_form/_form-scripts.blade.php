<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs4.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Select2 for dropdowns
        const tagElement = $('#tag');
        if (tagElement.length && tagElement.is('select')) {
            tagElement.select2({
                placeholder: 'Select Tag',
                width: '100%',
                dropdownPosition: 'below'
            });
        }

        const placeElement = $('#place');
        if (placeElement.length && placeElement.is('select')) {
            placeElement.select2({
                placeholder: 'Select Place Type',
                width: '100%',
                dropdownPosition: 'below'
            });
        }

        // Initialize Summernote for broadcast
        const broadcastElement = $('#broadcast');
        if (broadcastElement.length) {
            broadcastElement.summernote({
                height: 300,
                dialogsInBody: true,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                callbacks: {
                    onInit: function() {
                        $('body > .note-popover').hide();
                    }
                }
            });
        }

        // Poster preview functionality
        document.getElementById('poster')?.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const frame = document.getElementById('posterPreview');
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (frame) {
                        frame.src = e.target.result;
                        frame.style.display = 'block';
                        var svgEl = frame.parentElement.querySelector('.svg-placeholder');
                        if (svgEl) svgEl.style.display = 'none';
                    }
                };
                reader.readAsDataURL(file);
            }
        });

        // Form validation and submission
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const title = document.getElementById('title')?.value;
            if (!title) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Title is required',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                return;
            }

            const division = document.getElementById('division')?.value;
            if (!division) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Event Organizer is required',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                return;
            }

            // Validate required select fields
            const requiredSelects = ['tag', 'place'];
            for (const selectId of requiredSelects) {
                const select = document.getElementById(selectId);
                if (select && !select.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Error!',
                        text: `${select.previousElementSibling?.textContent?.replace('*', '').trim()} is required`,
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    select.focus();
                    return;
                }
            }
        });

        // Helper function to validate URLs
        function isValidUrl(string) {
            try {
                new URL(string);
                return true;
            } catch (_) {
                return false;
            }
        }

        // Show/hide link location based on place type
        function toggleLinkLocation() {
            const placeValue = $('#place').val();
            const linkLocationField = $('#linkLocation').closest('.mb-3');

            if (placeValue === 'Online') {
                linkLocationField.find('label').html('Link Location <span class="text-danger">*</span>');
                $('#linkLocation').prop('required', true);
            } else {
                linkLocationField.find('label').html('Link Location');
                $('#linkLocation').prop('required', false);
            }
        }

        // Initialize link location visibility
        toggleLinkLocation();

        // Add change event listener for place type
        $('#place').on('change', function() {
            toggleLinkLocation();
        });
    });
</script>
