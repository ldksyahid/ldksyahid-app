<div class="ve-wrap">
    {{-- Background blobs --}}
    <div class="ve-blob ve-blob-1"></div>
    <div class="ve-blob ve-blob-2"></div>
    <div class="ve-blob ve-blob-3"></div>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-7 col-md-9">
                <div class="ve-card wow fadeInUp" data-wow-delay="0.1s">

                    {{-- Badge --}}
                    <div class="ve-badge">
                        <span>✉️</span>
                        <span>Verifikasi Email</span>
                        <span class="ve-badge-pulse"></span>
                    </div>

                    {{-- Animated icon --}}
                    <div class="ve-icon-wrap">
                        <div class="ve-icon-orbit">
                            <span class="ve-orbit-dot" style="--d:0s">✨</span>
                            <span class="ve-orbit-dot" style="--d:1.2s">⭐</span>
                            <span class="ve-orbit-dot" style="--d:2.4s">💫</span>
                        </div>
                        <div class="ve-icon-inner">
                            <i class="fas fa-envelope-open-text"></i>
                        </div>
                        <div class="ve-icon-ring ve-ring-1"></div>
                        <div class="ve-icon-ring ve-ring-2"></div>
                    </div>

                    {{-- Headline --}}
                    <h3 class="ve-title">Satu Langkah Lagi! 🚀</h3>
                    <p class="ve-subtitle">Kami telah mengirimkan link verifikasi ke</p>

                    {{-- Email chip --}}
                    <div class="ve-email-chip">
                        <i class="fas fa-at"></i>
                        <span>{{ Auth::user()->email }}</span>
                    </div>

                    <p class="ve-hint">Buka email kamu dan klik link verifikasi untuk mengaktifkan akun.</p>

                    {{-- Steps --}}
                    <div class="ve-steps">
                        <div class="ve-step">
                            <div class="ve-step-icon">📬</div>
                            <span>Buka Email</span>
                        </div>
                        <div class="ve-step-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="ve-step">
                            <div class="ve-step-icon">🔗</div>
                            <span>Klik Link</span>
                        </div>
                        <div class="ve-step-arrow">
                            <i class="fas fa-chevron-right"></i>
                        </div>
                        <div class="ve-step">
                            <div class="ve-step-icon">🎉</div>
                            <span>Akun Aktif!</span>
                        </div>
                    </div>

                    {{-- Divider --}}
                    <div class="ve-divider"></div>

                    {{-- Resend --}}
                    <p class="ve-resend-label">Tidak menerima email?</p>
                    <form method="POST" action="{{ route('verification.resend') }}" class="ve-resend-form">
                        @csrf
                        <button type="submit" class="ve-resend-btn">
                            <span class="ve-btn-icon"><i class="fas fa-paper-plane"></i></span>
                            <span>Kirim Ulang Email</span>
                            <div class="ve-btn-shine"></div>
                        </button>
                    </form>

                    {{-- Success alert --}}
                    @if (session('resent'))
                    <div class="ve-success-alert">
                        <span class="ve-success-icon">🎊</span>
                        <div>
                            <strong>Terkirim!</strong> Email verifikasi baru telah dikirim. Segera periksa inbox kamu ya!
                        </div>
                    </div>
                    @endif

                    {{-- Note --}}
                    <div class="ve-note">
                        <i class="fas fa-circle-info"></i>
                        Jika belum menerima email setelah kirim ulang, coba lagi besok karena ada batas pengiriman dari server.
                    </div>

                    {{-- Floating tags --}}
                    <div class="ve-float-tag ve-ftag-1">📧 Cek Inbox</div>
                    <div class="ve-float-tag ve-ftag-2">🔒 Aman & Terenkripsi</div>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ===== VERIFY EMAIL ===== */
    .ve-wrap {
        position: relative;
        padding: 5rem 0 4rem;
        min-height: 80vh;
        display: flex;
        align-items: center;
        overflow: hidden;
    }

    /* Background blobs */
    .ve-blob {
        position: absolute;
        border-radius: 50%;
        filter: blur(60px);
        pointer-events: none;
        z-index: 0;
    }
    .ve-blob-1 {
        width: 400px; height: 400px;
        background: radial-gradient(circle, rgba(0,167,157,0.12) 0%, transparent 70%);
        top: -100px; right: -80px;
        animation: veBlobFloat 10s ease-in-out infinite;
    }
    .ve-blob-2 {
        width: 300px; height: 300px;
        background: radial-gradient(circle, rgba(0,167,157,0.08) 0%, transparent 70%);
        bottom: 0; left: -60px;
        animation: veBlobFloat 14s ease-in-out infinite reverse;
    }
    .ve-blob-3 {
        width: 200px; height: 200px;
        background: radial-gradient(circle, rgba(0,167,157,0.06) 0%, transparent 70%);
        top: 40%; left: 30%;
        animation: veBlobFloat 18s ease-in-out infinite 3s;
    }
    @keyframes veBlobFloat {
        0%, 100% { transform: translate(0, 0) scale(1); }
        50%       { transform: translate(20px, -20px) scale(1.05); }
    }

    /* Card */
    .ve-card {
        position: relative;
        background: white;
        border-radius: 28px;
        padding: 3rem 2.5rem 2.5rem;
        box-shadow: 0 20px 60px rgba(0,167,157,0.12), 0 4px 20px rgba(0,0,0,0.05);
        text-align: center;
        border: 1px solid rgba(0,167,157,0.1);
        z-index: 1;
        overflow: hidden;
    }

    .ve-card::before {
        content: '';
        position: absolute;
        top: 0; left: 10%; right: 10%;
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, rgba(0,167,157,0.35) 30%, rgba(0,167,157,0.35) 70%, transparent 100%);
        border-radius: 0 0 4px 4px;
        filter: blur(1px);
    }

    /* Badge */
    .ve-badge {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        border: 1px solid rgba(0,167,157,0.2);
        border-radius: 50px;
        padding: 0.45rem 1.2rem;
        margin-bottom: 2rem;
        font-size: 0.88rem;
        font-weight: 500;
        color: var(--primary);
        position: relative;
    }
    .ve-badge-pulse {
        width: 7px; height: 7px;
        background: var(--primary);
        border-radius: 50%;
        animation: badgePulse 2s ease-in-out infinite;
    }

    /* Icon */
    .ve-icon-wrap {
        position: relative;
        display: inline-block;
        margin-bottom: 1.75rem;
    }

    .ve-icon-inner {
        width: 90px; height: 90px;
        background: var(--primary-gradient);
        border-radius: 26px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 2.2rem;
        box-shadow: var(--shadow-primary);
        position: relative;
        z-index: 2;
        animation: veIconBounce 3s ease-in-out infinite;
    }

    @keyframes veIconBounce {
        0%, 100% { transform: translateY(0); }
        50%       { transform: translateY(-8px); }
    }

    /* Rings */
    .ve-icon-ring {
        position: absolute;
        border-radius: 50%;
        border: 2px solid rgba(0,167,157,0.15);
        top: 50%; left: 50%;
        transform: translate(-50%, -50%) scale(0);
        animation: veRingExpand 3s ease-out infinite;
    }
    .ve-ring-1 { width: 130px; height: 130px; animation-delay: 0s; }
    .ve-ring-2 { width: 170px; height: 170px; animation-delay: 0.8s; }

    @keyframes veRingExpand {
        0%   { transform: translate(-50%, -50%) scale(0.5); opacity: 0.6; }
        100% { transform: translate(-50%, -50%) scale(1.3); opacity: 0; }
    }

    /* Orbit dots */
    .ve-icon-orbit {
        position: absolute;
        inset: -22px;
        animation: orbitSpin 14s linear infinite;
        z-index: 3;
    }
    .ve-orbit-dot {
        position: absolute;
        font-size: 0.95rem;
        animation: orbitDotPulse 3s ease-in-out infinite;
        animation-delay: var(--d);
    }
    .ve-orbit-dot:nth-child(1) { top: 0; left: 50%; transform: translateX(-50%); }
    .ve-orbit-dot:nth-child(2) { bottom: 4px; left: 0; }
    .ve-orbit-dot:nth-child(3) { bottom: 4px; right: 0; }

    /* Title */
    .ve-title {
        font-family: var(--font-primary);
        font-size: 1.6rem;
        font-weight: 700;
        color: var(--dark);
        margin-bottom: 0.5rem;
    }

    .ve-subtitle {
        color: var(--secondary);
        margin-bottom: 0.75rem;
        font-size: 0.95rem;
    }

    /* Email chip */
    .ve-email-chip {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: var(--primary-light);
        border: 1px solid rgba(0,167,157,0.25);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        font-weight: 600;
        color: var(--dark);
        font-size: 0.92rem;
        margin-bottom: 0.75rem;
        word-break: break-all;
    }
    .ve-email-chip i {
        color: var(--primary);
        font-size: 0.85rem;
    }

    .ve-hint {
        color: var(--secondary);
        font-size: 0.88rem;
        margin-bottom: 1.75rem;
        line-height: 1.6;
    }

    /* Steps */
    .ve-steps {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.75rem;
        margin-bottom: 1.75rem;
        flex-wrap: wrap;
    }

    .ve-step {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 0.4rem;
    }

    .ve-step-icon {
        width: 52px; height: 52px;
        background: var(--primary-light);
        border-radius: 16px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        transition: var(--transition-bounce);
        border: 1px solid rgba(0,167,157,0.15);
    }

    .ve-step:hover .ve-step-icon {
        transform: translateY(-4px);
        box-shadow: 0 8px 20px rgba(0,167,157,0.15);
    }

    .ve-step span {
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--secondary);
    }

    .ve-step-arrow {
        color: rgba(0,167,157,0.4);
        font-size: 0.8rem;
        margin-top: -14px;
    }

    /* Divider */
    .ve-divider {
        width: 100%; height: 1px;
        background: linear-gradient(90deg, transparent 0%, rgba(0,167,157,0.15) 50%, transparent 100%);
        margin: 0 0 1.5rem;
    }

    /* Resend */
    .ve-resend-label {
        color: var(--secondary);
        font-size: 0.88rem;
        margin-bottom: 0.75rem;
    }

    .ve-resend-form { margin-bottom: 0; }

    .ve-resend-btn {
        display: inline-flex;
        align-items: center;
        gap: 0.6rem;
        padding: 0.75rem 2rem;
        background: var(--primary-gradient);
        color: white;
        border: none;
        border-radius: 50px;
        font-size: 0.95rem;
        font-weight: 600;
        cursor: pointer;
        box-shadow: var(--shadow-primary);
        transition: var(--transition-bounce);
        position: relative;
        overflow: hidden;
    }

    .ve-btn-icon {
        width: 28px; height: 28px;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 0.8rem;
        transition: var(--transition);
    }

    .ve-btn-shine {
        position: absolute;
        top: 0; left: -100%;
        width: 100%; height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.6s ease;
    }

    @media (hover: hover) {
        .ve-resend-btn:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 12px 30px rgba(0,167,157,0.3);
        }
        .ve-resend-btn:hover .ve-btn-icon {
            transform: rotate(-20deg) scale(1.1);
        }
        .ve-resend-btn:hover .ve-btn-shine { left: 100%; }
    }

    /* Success alert */
    .ve-success-alert {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        background: linear-gradient(135deg, #e8fdf5, #d0faf0);
        border: 1px solid rgba(0,167,157,0.25);
        border-radius: 14px;
        padding: 1rem 1.25rem;
        margin-top: 1.25rem;
        text-align: left;
        font-size: 0.88rem;
        color: var(--dark);
        animation: veSuccessIn 0.4s cubic-bezier(0.4,0,0.2,1);
    }
    .ve-success-icon { font-size: 1.5rem; flex-shrink: 0; }

    @keyframes veSuccessIn {
        from { opacity: 0; transform: translateY(-8px) scale(0.97); }
        to   { opacity: 1; transform: translateY(0) scale(1); }
    }

    /* Note */
    .ve-note {
        display: flex;
        align-items: flex-start;
        gap: 0.5rem;
        margin-top: 1.5rem;
        padding: 0.85rem 1rem;
        background: #f8f9fa;
        border-radius: 12px;
        font-size: 0.8rem;
        color: var(--secondary);
        text-align: left;
        line-height: 1.5;
    }
    .ve-note i {
        color: var(--primary);
        margin-top: 2px;
        flex-shrink: 0;
    }

    /* Floating tags */
    .ve-float-tag {
        position: absolute;
        background: white;
        padding: 0.35rem 0.8rem;
        border-radius: 50px;
        font-size: 0.72rem;
        font-weight: 600;
        color: var(--primary);
        box-shadow: var(--shadow-sm);
        z-index: 3;
        animation: tagFloat 4s ease-in-out infinite;
    }
    .ve-ftag-1 { top: 20px; right: 20px; animation-delay: 0s; }
    .ve-ftag-2 { bottom: 70px; left: 16px; animation-delay: 2s; }

    /* Responsive */
    @media (max-width: 575.98px) {
        .ve-card {
            padding: 2.5rem 1.5rem 2rem;
            border-radius: 22px;
        }
        .ve-title { font-size: 1.35rem; }
        .ve-float-tag { display: none; }
        .ve-icon-inner { width: 76px; height: 76px; font-size: 1.8rem; }
        .ve-steps { gap: 0.5rem; }
        .ve-step-icon { width: 44px; height: 44px; font-size: 1.25rem; }
    }
</style>
