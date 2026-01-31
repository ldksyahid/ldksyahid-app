<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Init Select2 for dropdowns
        $('#inputFaculty, #inputMajor, #inputGeneration').each(function() {
            $(this).select2({
                placeholder: $(this).data('placeholder') || '-- Select --',
                width: '100%',
                allowClear: true
            });
        });

        // Faculty change -> load majors via AJAX
        $('#inputFaculty').on('change', function() {
            var facultyID = $(this).val();
            if (!facultyID) return;

            $.ajax({
                type: "post",
                url: "{{ url('/admin/ktaldksyahid/get-major') }}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { id: facultyID },
                success: function(data) {
                    $('#inputMajor').empty().append('<option value="">-- Choose Major --</option>');
                    $.each(data, function (id, name) {
                        $('#inputMajor').append(new Option(name, id, false, false));
                    });
                    $('#inputMajor').trigger('change');
                },
                error: function(data) {
                    console.log(data.responseJSON);
                }
            });
        });

        // Photo preview
        const photoInput = document.getElementById('photo');
        const photoPreview = document.getElementById('frame');
        if (photoInput && photoPreview) {
            photoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                    if (!validTypes.includes(file.type)) {
                        Swal.fire({ title: 'Invalid File Type!', text: 'Please upload only JPG, JPEG, PNG, or WebP images.', icon: 'error', confirmButtonColor: '#00a79d' });
                        e.target.value = '';
                        return;
                    }
                    if (file.size > 5 * 1024 * 1024) {
                        Swal.fire({ title: 'File Too Large!', text: 'Image must be less than 5MB.', icon: 'error', confirmButtonColor: '#00a79d' });
                        e.target.value = '';
                        return;
                    }
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

        // Link profile: prevent special characters
        const linkProfileInput = document.querySelector('#inputLinkProfile');
        if (linkProfileInput) {
            linkProfileInput.addEventListener('keydown', function(e) {
                if (e.which === 188 || e.which === 32 || e.which === 186 || e.which === 187 || e.which === 190 || e.which === 191 || e.which === 192 || e.which === 219 || e.which === 220 || e.which === 221 || e.which === 222) {
                    e.preventDefault();
                }
            });
        }

        // Form submit loading
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const submitBtn = $(form).find('button[type="submit"]');
                if (submitBtn.length) {
                    submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Processing...');
                }
            });
        }
    });
</script>
