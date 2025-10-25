<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    // Filter and Search Functionality
    $(document).ready(function() {
        const searchInput = $('#search-input');
        const clearBtn = $('#clear-search');

        // Initialize select2 for filter dropdowns
        $('#category, #author, #publisher, #year').each(function () {
            $(this).select2({
                placeholder: "Semua",
                allowClear: true,
                width: '100%',
                dropdownPosition: 'below'
            });
        });

        // Auto-submit form when filters change
        $('#category, #author, #publisher, #year').on('change', function() {
            $('#search-form').submit();
        });

        searchInput.on('input', function () {
            clearBtn.toggle($(this).val().length > 0);
        });

        clearBtn.on('click', function () {
            searchInput.val('');
            $('#search-form').submit();
        });

        $(window).on('scroll', function () {
            $('#category, #author, #publisher, #year').select2('close');
        });
    });

    // Share Functionality
    document.addEventListener('DOMContentLoaded', function() {
        // Function to show success message
        function showCopySuccess(message) {
            // Remove existing success message
            const existingMessage = document.querySelector('.copy-success');
            if (existingMessage) {
                existingMessage.remove();
            }

            // Create new success message
            const successMessage = document.createElement('div');
            successMessage.className = 'copy-success';
            successMessage.innerHTML = `
                <i class="fas fa-check-circle"></i>
                <span>${message}</span>
            `;
            document.body.appendChild(successMessage);

            // Remove message after 3 seconds with fade out effect
            setTimeout(() => {
                successMessage.classList.add('fade-out');
                setTimeout(() => {
                    if (successMessage.parentNode) {
                        successMessage.remove();
                    }
                }, 300);
            }, 2700);
        }

        // Copy link functionality
        document.querySelectorAll('.copy-link').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const link = this.getAttribute('data-link');
                const fullLink = window.location.origin + link;

                navigator.clipboard.writeText(fullLink).then(() => {
                    showCopySuccess('Link berhasil disalin!');
                }).catch(() => {
                    const textArea = document.createElement('textarea');
                    textArea.value = fullLink;
                    document.body.appendChild(textArea);
                    textArea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textArea);
                    showCopySuccess('Link berhasil disalin!');
                });

                // Close dropdown
                $(this).closest('.dropdown').find('.dropdown-toggle').dropdown('hide');
            });
        });

        // WhatsApp share functionality
        document.querySelectorAll('.share-wa').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const link = this.getAttribute('data-link');
                const title = this.getAttribute('data-title');
                const fullLink = link;

                const message = `📚 *${title}* \n\nBaca buku ini di: ${fullLink}`;
                const whatsappUrl = `https://wa.me/?text=${encodeURIComponent(message)}`;

                window.open(whatsappUrl, '_blank');
                $(this).closest('.dropdown').find('.dropdown-toggle').dropdown('hide');
            });
        });
    });
</script>
