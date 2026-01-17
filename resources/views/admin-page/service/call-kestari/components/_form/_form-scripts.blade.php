<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
    $(document).ready(function () {
        // Initialize Select2 for appear dropdown
        const appearElement = $('#appear');
        if (appearElement.length && appearElement.is('select')) {
            appearElement.select2({
                placeholder: 'Select Position',
                width: '100%',
                dropdownPosition: 'below'
            });
        }

        // Form validation and submission
        document.querySelector('form')?.addEventListener('submit', function(e) {
            const buttonName = document.getElementById('buttonName')?.value;
            if (!buttonName) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Button Name is required',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                return;
            }

            const appear = document.getElementById('appear')?.value;
            if (!appear) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Appear Position is required',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                return;
            }

            const link = document.getElementById('link')?.value;
            if (!link) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Link is required',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                return;
            }

            // Validate URL format
            if (link && !isValidUrl(link)) {
                e.preventDefault();
                Swal.fire({
                    title: 'Error!',
                    text: 'Please enter a valid URL starting with http:// or https://',
                    icon: 'error',
                    confirmButtonColor: '#00a79d'
                });
                return;
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
    });

    // Function to copy link to clipboard (available globally for view mode)
    function copyLink(text, withBaseUrl = false) {
        navigator.clipboard.writeText(text).then(function() {
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                icon: 'success',
                title: 'Link copied to clipboard!'
            });
        }, function(err) {
            console.error('Could not copy text: ', err);
        });
    }
</script>
