<style>
    @keyframes authRightIn {
        from { opacity: 0; transform: translateX(28px); }
        to   { opacity: 1; transform: translateX(0); }
    }

    /* ===== AUTH — MOBILE COMPACT ===== */
    @media (max-width: 767.98px) {
        .auth-section {
            padding: 4.5rem 0 1.5rem !important;
            overflow-x: hidden;
        }

        /* Kurangi gutter vertikal saat kolom stack */
        .auth-section .row.g-5 {
            --bs-gutter-y: 1.5rem;
        }

        /* Kompakkan konten dekoratif */
        .auth-badge        { margin-bottom: 0.6rem !important; }
        .auth-heading      { font-size: 1.2rem !important; margin-bottom: 0.6rem !important; }
        .auth-quote        { padding: 0.65rem 0.9rem !important; margin-bottom: 0.6rem !important; }
        .auth-features     { margin-top: 0 !important; margin-bottom: 0 !important; }
        .auth-features li  { margin-bottom: 0.35rem !important; font-size: 0.8rem !important; }

        /* Kompakkan form card */
        .auth-card-header  { margin-bottom: 0.9rem !important; }
        .auth-card-icon    { width: 48px !important; height: 48px !important; font-size: 1.1rem !important; margin-bottom: 0.5rem !important; }
        .auth-input-wrap   { margin-bottom: 0.7rem !important; }
    }
</style>
