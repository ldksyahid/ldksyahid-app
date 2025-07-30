<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
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
    }
    .img-thumbnail {
        padding: 0.25rem;
        background-color: #fff;
        border: 1px solid #dee2e6;
        border-radius: 0.25rem;
        max-width: 100%;
        height: auto;
    }
    /* Select2 styles remain the same as before */
    .select2-container .select2-selection--single {
        height: 38px;
        padding: 6px 12px;
        border: 1px solid #ced4da;
        border-radius: 6px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 38px;
        right: 10px;
    }
    .select2-container--default .select2-results__option {
        padding: 10px 12px;
        font-size: 0.95rem;
        color: #333;
        transition: background-color 0.2s ease-in-out;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected] {
        background-color: #00a79d !important;
        color: #fff;
    }
    .select2-container--default .select2-results__option[aria-selected="true"] {
        background-color: #e0f7f5;
        color: #008b84;
        font-weight: 600;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        color: #6c757d;
        font-weight: 500;
    }
    .select2-container--default .select2-selection__arrow b {
        border-color: #00a79d transparent transparent transparent;
    }
    .select2-container--open .select2-selection--single {
        border: 1px solid #00bfa6 !important;
    }
    .select2-container--default .select2-results__option--highlighted[aria-selected],
    .select2-container--default .select2-results__option--highlighted {
        background-color: #00a79d !important;
        color: white !important;
    }
    .select2-container--default .select2-results__option[aria-selected="true"] {
        background-color: #e0f7f5 !important;
        color: #008b84 !important;
        font-weight: 600;
    }
    .select2-container--default .select2-search__field {
        border: 1px solid #ced4da !important;
        border-radius: 4px;
        padding: 6px 10px;
        font-size: 0.9rem;
        color: #6c757d;
        outline: none;
        box-shadow: none !important;
    }
    .select2-container--default .select2-search__field:focus {
        border-color: #00a79d !important;
        box-shadow: 0 0 0 0.2rem rgba(0, 167, 157, 0.25) !important;
    }
    .select2-container--default .select2-selection__placeholder {
        color: #6c757d;
    }
    .select2-container--default .select2-selection {
        background-color: #ffffff !important;
        border: 1px solid #ced4da;
        border-radius: 6px;
    }
    .select2-container--default .select2-selection--single {
        height: calc(2.5rem + 2px);
        padding: 0.375rem 1rem;
        border-radius: 0.5rem;
        border: 1px solid #ced4da;
        background-color: #fff;
        font-size: 1rem;
        transition: border-color .15s ease-in-out,box-shadow .15s ease-in-out;
    }
    .select2-container--default .select2-selection__arrow {
        top: 8px;
        right: 10px;
    }
    .select2-dropdown {
        border-radius: 0.75rem;
        border: 1px solid #00bfa6;
        font-size: 0.95rem;
        overflow: hidden;
        animation: dropdownFadeIn 0.2s ease forwards;
    }
    .select2-results__option {
        padding: 10px 14px;
        transition: all 0.2s ease;
        border-bottom: 1px solid #e0f2ef;
        cursor: pointer;
    }
    .select2-results__option:last-child {
        border-bottom: none;
    }
    .select2-results__option--highlighted {
        background-color: #00bfa6 !important;
        color: white !important;
    }
    .select2-results__option[aria-selected="true"] {
        background-color: #e6f9f6;
        color: #007f73;
    }
    .select2-search__field {
        outline: none !important;
        box-shadow: none !important;
        color: #6c757d;
    }
    @keyframes dropdownFadeIn {
        from {
            opacity: 0;
            transform: translateY(-4px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
