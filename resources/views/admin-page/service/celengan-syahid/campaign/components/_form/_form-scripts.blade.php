<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.js"></script>
<script>
    $(document).ready(function () {
        // Init Select2 for dropdowns
        $('#inputProvinsiCampaign, #inputKotaCampaign').each(function() {
            $(this).select2({
                placeholder: $(this).data('placeholder') || '-- Select --',
                width: '100%',
                allowClear: true
            });
        });

        // Province change -> load cities via AJAX
        $('#inputProvinsiCampaign').on('change', function() {
            var provinsi_id = $(this).val();
            if (!provinsi_id) return;

            $.ajax({
                type: "post",
                url: "{{ url('/admin/service/celengansyahid/campaign/get-city') }}",
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: { id: provinsi_id },
                success: function(data) {
                    $('#inputKotaCampaign').empty().append('<option value="">-- Choose City --</option>');
                    $.each(data, function (id, name) {
                        $('#inputKotaCampaign').append(new Option(name, id, false, false));
                    });
                    $('#inputKotaCampaign').trigger('change');
                },
                error: function(data) {
                    console.log(data.responseJSON);
                }
            });
        });

        // Summernote editor
        $('.summernote').summernote({
            height: 500,
            dialogsInBody: true,
            callbacks: {
                onInit: function() {
                    $('body > .note-popover').hide();
                }
            },
        });

        // Poster preview
        const posterInput = document.getElementById('poster');
        const posterPreview = document.getElementById('framePoster');
        if (posterInput && posterPreview) {
            posterInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const validTypes = ['image/jpeg', 'image/png', 'image/jpg'];
                    if (!validTypes.includes(file.type)) {
                        Swal.fire({ title: 'Invalid File Type!', text: 'Please upload only JPG, JPEG, or PNG images.', icon: 'error', confirmButtonColor: '#00a79d' });
                        e.target.value = '';
                        return;
                    }
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        posterPreview.src = e.target.result;
                        posterPreview.closest('.image-preview-container').classList.add('has-image');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Logo preview
        const logoInput = document.getElementById('logoPj');
        const logoPreview = document.getElementById('frameLogo');
        if (logoInput && logoPreview) {
            logoInput.addEventListener('change', function(e) {
                const file = e.target.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        logoPreview.src = e.target.result;
                        logoPreview.closest('.image-preview-container').classList.add('has-image');
                    };
                    reader.readAsDataURL(file);
                }
            });
        }

        // Rupiah formatting
        const rupiahInput = document.getElementById('inputTargetBiaya');
        if (rupiahInput) {
            rupiahInput.addEventListener('keyup', function() {
                this.value = formatRupiah(this.value, 'Rp');
            });
        }

        // Organization checkbox toggle
        const cekOrg = document.getElementById('cekOrganisasi');
        const formOrg = document.getElementById('formOrganisasi');
        if (cekOrg && formOrg) {
            cekOrg.addEventListener('change', function() {
                formOrg.style.display = this.checked ? 'block' : 'none';
            });
        }

        // Link input: prevent special characters
        const linkInput = document.querySelector('#inputLink');
        if (linkInput) {
            linkInput.addEventListener('keydown', function(e) {
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

    function formatRupiah(angka, prefix) {
        var number_string = angka.replace(/[^\d]/g, '').toString(),
            split = number_string.split(','),
            sisa = split[0].length % 3,
            rupiah = split[0].substr(0, sisa),
            ribuan = split[0].substr(sisa).match(/\d{3}/gi);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
        return prefix == undefined ? rupiah : (rupiah ? 'Rp' + rupiah : '');
    }
</script>
