<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Form validation
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const name = document.getElementById('name');
                const email = document.getElementById('email');
                const whatsapp = document.getElementById('whatsapp');

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

                if (email && !email.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Email Required!',
                        text: 'Please enter an email.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    email.focus();
                    return;
                }

                // Show loading
                const submitBtn = $(form).find('button[type="submit"]');
                if (submitBtn.length) {
                    submitBtn.prop('disabled', true).html('<i class="fa fa-spinner fa-spin me-1"></i> Processing...');
                }
            });
        }

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
