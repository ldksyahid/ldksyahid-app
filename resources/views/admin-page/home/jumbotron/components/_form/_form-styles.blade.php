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

    /* Image Preview */
    .image-preview-container {
        position: relative;
        width: 100%;
        max-width: 400px;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #dee2e6;
        background-color: #f8f9fa;
    }
    .image-preview-container img {
        width: 100%;
        height: auto;
        display: block;
    }
    .image-preview-container.has-image {
        border-color: #00a79d;
    }

    /* Toggle Switch for Button */
    .toggle-switch {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 12px 16px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        cursor: pointer;
        transition: all 0.2s ease;
    }
    .toggle-switch:hover {
        border-color: #00a79d;
        background-color: #e0f7f5;
    }
    .toggle-switch input[type="checkbox"] {
        width: 20px;
        height: 20px;
        appearance: none;
        -webkit-appearance: none;
        border: 2px solid #dee2e6;
        border-radius: 4px;
        background-color: #fff;
        cursor: pointer;
        position: relative;
    }
    .toggle-switch input[type="checkbox"]:checked {
        border-color: #00a79d;
        background-color: #00a79d;
    }
    .toggle-switch input[type="checkbox"]:checked::after {
        content: '✓';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: #fff;
        font-size: 12px;
        font-weight: bold;
    }

    /* Button Fields Container */
    .button-fields {
        padding: 16px;
        background-color: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #dee2e6;
        margin-top: 12px;
    }

    /* View mode specific */
    .form-label.fw-bold {
        color: #495057;
        font-weight: 600;
    }

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
        .image-preview-container {
            max-width: 100%;
        }
    }
</style>
