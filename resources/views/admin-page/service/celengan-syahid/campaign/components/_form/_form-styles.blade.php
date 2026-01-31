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
    .form-text { font-size: 0.8rem; color: #6c757d; }
    .invalid-feedback { font-size: 0.85rem; }
    .form-control-plaintext {
        padding: 0.375rem 0;
        margin-bottom: 0;
        line-height: 1.5;
        background-color: transparent;
        border: solid transparent;
        border-width: 1px 0;
        min-height: 38px;
        display: block;
        word-break: break-all;
        overflow-wrap: break-word;
    }
    .image-preview-container {
        position: relative;
        border-radius: 12px;
        overflow: hidden;
        border: 2px solid #dee2e6;
        background-color: #f8f9fa;
        display: inline-block;
    }
    .image-preview-container img {
        width: 250px;
        height: 150px;
        object-fit: cover;
        display: block;
    }
    .image-preview-container.has-image {
        border-color: #00a79d;
    }
    .form-label.fw-bold { color: #495057; font-weight: 600; }

    /* Select2 Styles */
    .select2-container {
        z-index: 1050;
    }
    .select2-container .select2-selection--single {
        height: calc(2.5rem + 2px);
        padding: 0 0.75rem;
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
        background-color: #fff;
        font-size: 1rem;
        display: flex;
        align-items: center;
        transition: border-color .15s ease-in-out, box-shadow .15s ease-in-out;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered,
    .select2-container--default .select2-selection--clearable .select2-selection__rendered {
        color: #6c757d !important;
        font-weight: 500;
        line-height: calc(2.5rem);
        padding-left: 0;
        padding-right: 40px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        right: 8px;
        height: 100%;
        top: 0;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow b {
        border-color: #00a79d transparent transparent transparent;
        border-width: 6px 5px 0 5px;
    }
    .select2-container--default .select2-selection--single .select2-selection__clear {
        color: #999;
        font-size: 1.2rem;
        font-weight: 400;
        margin-right: 8px;
        cursor: pointer;
    }
    .select2-container--default .select2-selection--single .select2-selection__clear:hover,
    .select2-container--default .select2-selection--single .select2-selection__clear:active {
        color: #666;
    }
    .select2-container--default .select2-selection__placeholder {
        color: #6c757d;
    }
    .select2-container--open .select2-selection--single {
        border-color: #ced4da !important;
        box-shadow: none !important;
    }
    .select2-dropdown {
        border-radius: 0.5rem;
        border: 1px solid #e8e8e8;
        font-size: 0.95rem;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        animation: dropdownFadeIn 0.2s ease forwards;
    }
    .select2-search--dropdown {
        padding: 6px;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field,
    .select2-dropdown .select2-search .select2-search__field,
    .select2-search__field {
        border: 1px solid #dee2e6 !important;
        border-radius: 4px !important;
        padding: 6px 10px !important;
        font-size: 0.9rem !important;
        color: #495057 !important;
        outline: none !important;
        box-shadow: none !important;
    }
    .select2-container--default .select2-search--dropdown .select2-search__field:focus,
    .select2-dropdown .select2-search .select2-search__field:focus,
    .select2-search__field:focus {
        border-color: #bbb !important;
        box-shadow: none !important;
        outline: none !important;
    }
    .select2-container--default .select2-results__option {
        padding: 10px 14px;
        font-size: 0.95rem;
        color: #333;
        transition: all 0.15s ease;
        border-bottom: 1px solid #e0f2ef;
        cursor: pointer;
    }
    .select2-results__option:last-child {
        border-bottom: none;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #00a79d !important;
        color: #fff !important;
    }
    .select2-container--default .select2-results__option[aria-selected="true"] {
        background-color: #e0f7f5 !important;
        color: #008b84 !important;
        font-weight: 600;
    }
    @keyframes dropdownFadeIn {
        from { opacity: 0; transform: translateY(-4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    @media (max-width: 768px) {
        .page-title { font-size: 1.35rem; }
        .section-title { font-size: 1rem; }
        .select2-container .select2-selection--single {
            height: calc(2.25rem + 2px);
            font-size: 0.9rem;
        }
    }
</style>
