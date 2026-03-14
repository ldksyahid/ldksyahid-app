{{-- Load SweetAlert2 FIRST before using it --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ========================================
    // AJAX FORM SUBMISSION WITH TOAST
    // ========================================
    // Initialize Toast (Swal is now loaded) - positioned below navbar
    window.ContactToast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        customClass: {
            container: 'toast-below-navbar'
        }
    });

    // Handle contact form submission
    window.handleContactSubmit = function(event) {
        event.preventDefault();
        event.stopPropagation();

        const form = event.target;
        const formInputs = form.querySelectorAll('.contact-form__input, .contact-form__textarea');
        let isValid = true;

        // Validate all fields
        formInputs.forEach(input => {
            const parent = input.closest('.contact-form__group');

            if (!input.validity.valid || input.value.trim() === '') {
                input.classList.add('invalid');
                input.classList.remove('valid');
                parent.classList.add('has-error');
                isValid = false;
            } else {
                input.classList.remove('invalid');
                input.classList.add('valid');
                parent.classList.remove('has-error');
            }
        });

        if (!isValid) {
            // Scroll to first error
            const firstError = form.querySelector('.contact-form__input.invalid, .contact-form__textarea.invalid');
            if (firstError) {
                firstError.focus();
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }

            ContactToast.fire({ icon: 'error', title: 'Harap lengkapi semua field yang wajib diisi!' });
            return false;
        }

        // Show loading state
        const submitBtn = form.querySelector('.contact-form__submit');
        const btnEmoji = submitBtn.querySelector('.btn-emoji');
        const btnText = submitBtn.querySelector('span:not(.btn-emoji)');
        const btnIcon = submitBtn.querySelector('i');
        const originalText = btnText.textContent;

        submitBtn.disabled = true;
        btnEmoji.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
        btnText.textContent = 'Mengirim...';
        if (btnIcon) btnIcon.style.display = 'none';

        // Send AJAX request
        const formData = new FormData(form);

        fetch('/about/contact/message/store', {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                ContactToast.fire({
                    icon: 'success',
                    title: data.message || 'Pesan berhasil dikirim! Terima kasih telah menghubungi kami. 🎉'
                });

                // Reset form
                form.reset();
                formInputs.forEach(input => {
                    input.classList.remove('valid', 'invalid');
                    input.closest('.contact-form__group').classList.remove('has-error');
                });
            } else {
                const errorMsg = data.message || 'Terjadi kesalahan saat mengirim pesan!';
                ContactToast.fire({ icon: 'error', title: errorMsg });
            }
        })
        .catch(error => {
            console.error('Contact form error:', error);
            ContactToast.fire({ icon: 'error', title: 'Terjadi kesalahan jaringan. Silakan coba lagi!' });
        })
        .finally(() => {
            submitBtn.disabled = false;
            btnEmoji.innerHTML = '🚀';
            btnText.textContent = originalText;
            if (btnIcon) btnIcon.style.display = '';
        });

        return false;
    };
</script>
