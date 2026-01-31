<style>
    .page-title {
        font-size: 1.65rem;
        font-weight: 600;
        text-align: center;
        color: #00a79d;
        margin: .75rem 0 1.5rem;
        position: relative;
        display: inline-block;
    }
    .page-title .highlighted-text {
        color: #008b84;
        font-weight: 700;
    }
    .page-title::after {
        content: '';
        display: block;
        height: 4px;
        width: 120px;
        margin: .35rem auto 0;
        border-radius: 3px;
        background: linear-gradient(90deg,#00a79d 0%,#008b84 100%);
    }
    .section-title {
        font-size: 1.1rem;
        font-weight: 600;
        color: #00a79d;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e0f7f5;
    }
    .btn-custom-primary {
        color: #fff;
        background-color: #00a79d;
        border: 1px solid #00a79d;
        transition: all 0.3s ease;
    }
    .btn-custom-primary:hover {
        background-color: #008b84;
        border-color: #008b84;
        color: #fff;
    }
    .btn-custom-primary:focus {
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .card {
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }
    .form-control:focus, .form-select:focus {
        border-color: #00a79d;
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25);
    }
    .form-text {
        font-size: 0.8rem;
        color: #6c757d;
    }
    .invalid-feedback {
        font-size: 0.85rem;
    }
    .form-control-plaintext {
        padding: 0.375rem 0;
        margin-bottom: 0;
        line-height: 1.5;
        background-color: transparent;
        border: solid transparent;
        border-width: 1px 0;
        min-height: 38px;
        display: flex;
        align-items: center;
    }
    .badge {
        font-size: 0.85rem;
        padding: 0.35rem 0.65rem;
    }

    /* Role Radio Buttons */
    .role-option {
        display: flex;
        align-items: center;
        padding: 0.75rem 1rem;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        margin-bottom: 0.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        background-color: #fff;
    }
    .role-option:hover {
        border-color: #00a79d;
        background-color: #f8f9fa;
    }
    .role-option.selected {
        border-color: #00a79d;
        background-color: #e0f7f5;
    }
    .role-option input[type="radio"] {
        margin-right: 0.75rem;
        width: 18px;
        height: 18px;
        appearance: none;
        -webkit-appearance: none;
        border: 2px solid #dee2e6;
        border-radius: 50%;
        background-color: #fff;
        cursor: pointer;
        position: relative;
    }
    .role-option input[type="radio"]:checked {
        border-color: #00a79d;
        background-color: #fff;
    }
    .role-option input[type="radio"]:checked::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background-color: #00a79d;
    }
    .role-option .role-badge {
        margin-left: auto;
    }

    /* Status icons */
    .fa-check-circle.text-success {
        color: #28a745;
    }
    .fa-times-circle.text-danger {
        color: #dc3545;
    }

    /* Button Styles */
    .btn-outline-primary {
        color: #00a79d;
        border-color: #00a79d;
        transition: all 0.3s ease;
    }
    .btn-outline-primary:hover {
        color: white !important;
        background-color: #00a79d;
        border-color: #00a79d;
    }
    .btn-outline-secondary {
        color: #6c757d;
        border-color: #6c757d;
    }
    .btn-outline-secondary:hover {
        color: white !important;
        background-color: #6c757d;
        border-color: #6c757d;
    }

    /* Info Card */
    .info-card {
        border: 1px solid #dee2e6;
        border-left: 4px solid #00a79d;
        background-color: #f8f9fa !important;
        border-radius: 8px;
    }

    /* View mode specific */
    .form-label.fw-bold {
        color: #495057;
        font-weight: 600;
    }

    /* Profile picture */
    .profile-picture-container {
        width: 120px;
        height: 120px;
        border-radius: 50%;
        overflow: hidden;
        border: 3px solid #00a79d;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    .profile-picture-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    /* Role badge colors */
    .badge.bg-role-superadmin { background-color: #dc3545 !important; }
    .badge.bg-role-helperadmin { background-color: #ffc107 !important; color: #212529 !important; }
    .badge.bg-role-helpercelsyahid { background-color: #28a745 !important; }
    .badge.bg-role-helpereventmart { background-color: #5352ed !important; }
    .badge.bg-role-helperspam { background-color: #17a2b8 !important; }
    .badge.bg-role-helpermedia { background-color: #343a40 !important; }
    .badge.bg-role-helperletter { background-color: #6c757d !important; }
    .badge.bg-role-user { background-color: #007bff !important; }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .page-title {
            font-size: 1.35rem;
        }
        .d-flex.justify-content-between,
        .d-flex.align-items-center {
            flex-direction: column;
            align-items: flex-start !important;
            gap: 0.5rem;
        }
        .d-flex.justify-content-between .btn,
        .d-flex.align-items-center .btn {
            width: 100%;
            margin-top: 0.5rem;
        }
        .section-title {
            font-size: 1rem;
        }
        .role-option {
            padding: 0.5rem 0.75rem;
        }
    }
</style>
