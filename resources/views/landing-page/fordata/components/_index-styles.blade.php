<style>
  :root {
    --primary: #f59e0b;
    --primary-hover: #d97706;
    --primary-light: #fef3c7;
    --dark: #111827;
    --dark-card: #1f2937;
    --gray-bg: #f9fafb;
    --gray-border: #e5e7eb;
    --gray-text: #6b7280;
    --success: #10b981;
    --success-dark: #059669;
    --wa-green: #25d366;
  }

  * {
    box-sizing: border-box;
    margin: 0;
    padding: 0;
  }

  body,
  html {
    min-height: 100%;
    font-family: 'Plus Jakarta Sans', 'Montserrat', sans-serif;
    color: #1f2937;
    background: linear-gradient(135deg, #fffbeb 0%, #fef3c7 40%, #fed7aa 100%);
    background-attachment: fixed;
  }

  .portal-wrapper {
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    padding: 24px 16px;
  }

  .portal-container {
    width: 100%;
    max-width: 580px;
    margin: 0 auto;
    text-align: center;
  }

  /* Banner */
  .banner-container {
    position: relative;
    margin-bottom: 16px;
  }

  .header-banner {
    display: block;
    margin: 0 auto;
    width: 100%;
    max-width: 540px;
    height: auto;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08), 0 8px 10px -6px rgba(0, 0, 0, 0.04);
    transition: all 0.3s ease;
  }

  /* Card */
  .portal-card {
    background: #ffffff;
    border-radius: 20px;
    padding: 28px 24px;
    box-shadow: 0 20px 35px -10px rgba(0, 0, 0, 0.08), 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid rgba(255, 255, 255, 0.9);
    position: relative;
    margin-top: 12px;
    transition: all 0.3s ease;
  }

  .badge-period {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    background: #fef3c7;
    color: #92400e;
    font-size: 0.75rem;
    font-weight: 700;
    letter-spacing: 0.05em;
    text-transform: uppercase;
    padding: 4px 12px;
    border-radius: 9999px;
    margin-bottom: 10px;
  }

  .portal-title {
    font-weight: 800;
    font-size: 1.45rem;
    color: var(--dark);
    margin-bottom: 6px;
    letter-spacing: -0.02em;
  }

  .portal-subtitle {
    font-size: 0.88rem;
    color: var(--gray-text);
    line-height: 1.5;
    margin-bottom: 22px;
  }

  /* Form Fields */
  .form-group {
    text-align: left;
    margin-bottom: 18px;
  }

  .form-label {
    display: flex;
    align-items: center;
    gap: 6px;
    font-size: 0.82rem;
    font-weight: 700;
    color: #374151;
    margin-bottom: 7px;
    text-transform: uppercase;
    letter-spacing: 0.03em;
  }

  .form-label i {
    color: var(--primary);
  }

  .input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .input-icon-left {
    position: absolute;
    left: 14px;
    color: #9ca3af;
    font-size: 0.95rem;
    pointer-events: none;
    transition: color 0.2s;
  }

  .form-control-modern {
    width: 100%;
    height: 48px;
    padding: 10px 14px 10px 42px;
    font-size: 0.95rem;
    font-weight: 600;
    color: #111827;
    background-color: #f9fafb;
    border: 1.5px solid #e5e7eb;
    border-radius: 12px;
    transition: all 0.2s ease;
    outline: none;
    font-family: inherit;
  }

  .form-control-modern::placeholder {
    color: #9ca3af;
    font-weight: 400;
  }

  .form-control-modern:focus {
    background-color: #ffffff;
    border-color: var(--primary);
    box-shadow: 0 0 0 4px rgba(245, 158, 11, 0.15);
  }

  .form-control-modern:focus + .input-icon-left,
  .input-wrapper:focus-within .input-icon-left {
    color: var(--primary-hover);
  }

  /* Input Group NIM */
  .nim-group {
    display: flex;
    gap: 8px;
    align-items: stretch;
  }

  .nim-group .input-wrapper {
    flex: 1;
  }

  .btn-cek {
    background: #f3f4f6;
    color: #374151;
    border: 1.5px solid #e5e7eb;
    border-radius: 12px;
    padding: 0 18px;
    font-size: 0.88rem;
    font-weight: 700;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 6px;
    transition: all 0.2s ease;
    white-space: nowrap;
    font-family: inherit;
  }

  .btn-cek:hover {
    background: #e5e7eb;
    color: #111827;
    border-color: #d1d5db;
  }

  .btn-cek:active {
    transform: scale(0.97);
  }

  /* Quick Badge for Verified NIM */
  .nim-quick-badge {
    display: none;
    margin-top: 8px;
    padding: 8px 12px;
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    border-radius: 10px;
    font-size: 0.8rem;
    color: #166534;
    text-align: left;
    line-height: 1.4;
    animation: fadeIn 0.3s ease;
  }

  .form-hint {
    display: block;
    font-size: 0.75rem;
    color: #9ca3af;
    margin-top: 5px;
  }

  /* Buttons */
  .btn-primary-action {
    width: 100%;
    height: 50px;
    background: linear-gradient(135deg, #1f2937 0%, #111827 100%);
    color: #ffffff;
    border: none;
    border-radius: 12px;
    font-size: 1rem;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    cursor: pointer;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(17, 24, 39, 0.15);
    font-family: inherit;
    text-decoration: none;
    margin-top: 6px;
  }

  .btn-primary-action:hover {
    background: linear-gradient(135deg, #111827 0%, #000000 100%);
    transform: translateY(-1px);
    box-shadow: 0 6px 20px rgba(17, 24, 39, 0.25);
    color: #ffffff;
  }

  .btn-primary-action:active {
    transform: translateY(0);
  }

  .btn-success-action {
    background: linear-gradient(135deg, #10b981 0%, #059669 100%);
    box-shadow: 0 4px 14px rgba(16, 185, 129, 0.3);
  }

  .btn-success-action:hover {
    background: linear-gradient(135deg, #059669 0%, #047857 100%);
    box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
  }

  .btn-wa-share {
    background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
    box-shadow: 0 4px 14px rgba(37, 211, 102, 0.25);
  }

  .btn-wa-share:hover {
    background: linear-gradient(135deg, #128c7e 0%, #075e54 100%);
  }

  /* Result Containers */
  .result-box {
    padding: 18px;
    border-radius: 14px;
    margin: 14px 0;
    text-align: center;
    font-size: 0.9rem;
    line-height: 1.6;
  }

  .result-box.info {
    background: #eff6ff;
    border: 1px solid #bfdbfe;
    color: #1e40af;
  }

  .result-box.success {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #166534;
  }

  .result-box.warning {
    background: #fffbeb;
    border: 1px solid #fde68a;
    color: #92400e;
  }

  /* Spinner */
  .spinner-modern {
    width: 42px;
    height: 42px;
    border: 4px solid #fef3c7;
    border-top-color: #f59e0b;
    border-radius: 50%;
    animation: spin 0.8s linear infinite;
    margin: 20px auto 14px;
  }

  @keyframes spin {
    to { transform: rotate(360deg); }
  }

  @keyframes fadeIn {
    from { opacity: 0; transform: translateY(-4px); }
    to { opacity: 1; transform: translateY(0); }
  }

  /* Modal */
  .modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: rgba(17, 24, 39, 0.5);
    backdrop-filter: blur(4px);
    align-items: center;
    justify-content: center;
    padding: 16px;
  }

  .modal-card {
    background: #ffffff;
    width: 100%;
    max-width: 420px;
    border-radius: 20px;
    padding: 24px;
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    position: relative;
    text-align: center;
    animation: modalPop 0.25s cubic-bezier(0.16, 1, 0.3, 1);
  }

  @keyframes modalPop {
    from { opacity: 0; transform: scale(0.95); }
    to { opacity: 1; transform: scale(1); }
  }

  .modal-icon-header {
    width: 54px;
    height: 54px;
    background: #fef3c7;
    color: #d97706;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.35rem;
    margin: 0 auto 14px;
  }

  .modal-close-btn {
    position: absolute;
    top: 14px;
    right: 14px;
    background: #f3f4f6;
    border: none;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    cursor: pointer;
    color: #6b7280;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.2s;
  }

  .modal-close-btn:hover {
    background: #e5e7eb;
    color: #111827;
  }

  /* Footer */
  .portal-footer {
    max-width: 580px;
    margin: 20px auto 0;
    width: 100%;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.78rem;
    color: #78716c;
    flex-wrap: wrap;
    gap: 10px;
  }

  .btn-logout {
    background: rgba(255, 255, 255, 0.6);
    color: #4b5563;
    border: 1px solid rgba(0, 0, 0, 0.08);
    padding: 6px 14px;
    border-radius: 8px;
    font-size: 0.76rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 5px;
    transition: all 0.2s;
  }

  .btn-logout:hover {
    background: #fee2e2;
    color: #b91c1c;
    border-color: #fecaca;
  }

  @media (max-width: 480px) {
    .portal-card {
      padding: 24px 18px;
    }
    .nim-group {
      flex-direction: column;
    }
    .btn-cek {
      height: 44px;
      justify-content: center;
    }
  }
</style>

