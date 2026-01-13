<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    $(document).ready(function () {
        // Role option click handler
        $('.role-option').on('click', function() {
            $('.role-option').removeClass('selected');
            $(this).addClass('selected');
            $(this).find('input[type="radio"]').prop('checked', true);
        });

        // Initialize selected state
        $('input[name="roleName"]:checked').closest('.role-option').addClass('selected');

        // Form validation and submission
        const form = document.querySelector('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                const name = document.getElementById('name');
                const email = document.getElementById('email');
                const password = document.getElementById('password');
                const roleName = document.querySelector('input[name="roleName"]:checked');

                // Validate name
                if (name && !name.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Name Required!',
                        text: 'Please enter the user name.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    name.focus();
                    return;
                }

                // Validate email
                if (email && !email.value.trim()) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Email Required!',
                        text: 'Please enter a valid email address.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    email.focus();
                    return;
                }

                // Validate email format
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (email && !emailPattern.test(email.value.trim())) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Invalid Email!',
                        text: 'Please enter a valid email address.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    email.focus();
                    return;
                }

                // Validate password for create operation
                const isCreateForm = form.action.includes('store');
                if (isCreateForm && password && !password.value) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Password Required!',
                        text: 'Please enter a password for the user.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    password.focus();
                    return;
                }

                // Validate password minimum length
                if (password && password.value && password.value.length < 6) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Password Too Short!',
                        text: 'Password must be at least 6 characters.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    password.focus();
                    return;
                }

                // Validate role selection
                if (!roleName) {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Role Required!',
                        text: 'Please select a role for the user.',
                        icon: 'error',
                        confirmButtonColor: '#00a79d'
                    });
                    return;
                }

                // Show loading on form submit
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
