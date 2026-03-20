<script>
document.addEventListener('DOMContentLoaded', function() {
    const overlay = document.getElementById('vepOverlay');
    const closeBtn = document.getElementById('vepClose');
    const backToTop = document.querySelector('.back-to-top');
    if (!overlay) return;

    function lockScroll()   { document.body.style.overflow = 'hidden'; }
    function unlockScroll() { document.body.style.overflow = ''; }

    lockScroll();

    // Hide back-to-top while modal is open
    if (backToTop) backToTop.classList.add('vepm-suppressed');

    function closeModal() {
        overlay.style.animation = 'vepmFadeOut 0.3s ease forwards';
        unlockScroll();
        // Restore back-to-top smoothly after modal fades out
        if (backToTop) {
            setTimeout(() => backToTop.classList.remove('vepm-suppressed'), 250);
        }
        setTimeout(() => overlay.style.display = 'none', 320);
    }

    closeBtn.addEventListener('click', closeModal);
    overlay.addEventListener('click', function(e) {
        if (e.target === overlay) closeModal();
    });
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeModal();
    });
});
</script>

<script>
// Handle resend verification email
function handleResendVerification(event) {
    event.preventDefault();
    event.stopPropagation();

    const form = event.target;
    const submitBtn = document.getElementById('resendBtn');
    const btnIcon = submitBtn.querySelector('.vepm-btn-icon');
    const btnText = document.getElementById('resendBtnText');
    const messageDiv = document.getElementById('resendMessage');
    const originalText = btnText.textContent;

    // Hide previous message
    messageDiv.style.display = 'none';
    messageDiv.className = 'vepm-message';

    // Disable button & show loading animation
    submitBtn.disabled = true;
    btnIcon.innerHTML = '<i class="fas fa-spinner fa-spin"></i>';
    btnText.textContent = 'Mengirim...';

    // Send AJAX request
    const formData = new FormData(form);

    fetch('{{ route("verification.resend") }}', {
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
            // Show success message
            messageDiv.className = 'vepm-message success';
            messageDiv.innerHTML = '<span class="vepm-message-icon">🎊</span><div><strong>Terkirim!</strong> ' + (data.message || 'Email verifikasi berhasil dikirim ulang. Segera periksa inbox kamu ya!') + '</div>';
            messageDiv.style.display = 'flex';
        } else {
            // Show error message
            const errorMsg = data.message || 'Terjadi kesalahan saat mengirim email!';
            messageDiv.className = 'vepm-message error';
            messageDiv.innerHTML = '<span class="vepm-message-icon">⚠️</span><div><strong>Gagal!</strong> ' + errorMsg + '</div>';
            messageDiv.style.display = 'flex';
        }
    })
    .catch(error => {
        console.error('Resend verification error:', error);
        // Show network error
        messageDiv.className = 'vepm-message error';
        messageDiv.innerHTML = '<span class="vepm-message-icon">⚠️</span><div><strong>Error!</strong> Terjadi kesalahan jaringan. Silakan coba lagi!</div>';
        messageDiv.style.display = 'flex';
    })
    .finally(() => {
        submitBtn.disabled = false;
        btnIcon.innerHTML = '<i class="fas fa-paper-plane"></i>';
        btnText.textContent = originalText;
    });

    return false;
}
</script>
