<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        $('#language').select2({
            placeholder: 'Select Language',
            width: '100%',
            dropdownPosition: 'below'
        });

        document.getElementById('coverImage')?.addEventListener('change', function(event) {
            const file = event.target.files[0];
            if (file && file.type.match('image.*')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                };
                reader.readAsDataURL(file);
            }
        });

        document.querySelector('form')?.addEventListener('submit', function(e) {
            const title = document.getElementById('titleBook').value;
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
        });
    });
</script>
