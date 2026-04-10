<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
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

    /* News Content Preview */
    .news-content-preview {
        max-height: 600px;
        overflow-y: auto;
        line-height: 1.8;
    }
    .news-content-preview img {
        max-width: 100%;
        height: auto;
    }

    /* Summernote Customization */
    .note-editor.note-frame {
        border: 1px solid #dee2e6;
        border-radius: 8px;
    }
    .note-editor.note-frame .note-toolbar {
        background-color: #f8f9fa;
        border-bottom: 1px solid #dee2e6;
        border-radius: 8px 8px 0 0;
    }
    .note-editor.note-frame .note-editing-area {
        min-height: 400px;
    }
    .note-editor.note-frame .note-editing-area .note-editable {
        padding: 15px;
    }

    /* View mode specific */
    .form-label.fw-bold {
        color: #495057;
        font-weight: 600;
    }

    /* Email Notification Warning */
    .email-notif-warning {
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 16px rgba(245, 158, 11, 0.12);
        padding: 1rem 1.25rem;
        display: flex;
        align-items: center;
        gap: 1rem;
        overflow: hidden;
        margin-bottom: 0.5rem;
        transition: opacity 0.35s ease, transform 0.35s ease, max-height 0.4s ease, padding 0.35s ease, margin 0.35s ease;
        max-height: 200px;
    }
    .email-notif-warning.dismissing {
        opacity: 0;
        transform: translateY(-8px);
        max-height: 0;
        padding-top: 0;
        padding-bottom: 0;
        margin-bottom: 0 !important;
    }
    .email-notif-warning .en-icon {
        width: 42px; height: 42px; flex-shrink: 0;
        background: rgba(245, 158, 11, 0.1);
        border-radius: 10px;
        display: flex; align-items: center; justify-content: center;
        color: #f59e0b; font-size: 1.1rem;
    }
    .email-notif-warning .en-title { font-weight: 700; font-size: 0.95rem; color: #d97706; margin-bottom: 0.15rem; }
    .email-notif-warning .en-sub   { font-size: 0.78rem; color: #6c757d; margin-bottom: 0.4rem; }
    .email-notif-warning .en-meta  { display: flex; flex-wrap: wrap; align-items: center; gap: 0.5rem; font-size: 0.82rem; color: #495057; }
    .email-notif-warning .en-close {
        margin-left: auto; flex-shrink: 0; align-self: flex-start;
        background: none; border: none; cursor: pointer;
        color: #adb5bd; font-size: 1rem; padding: 0.2rem 0.4rem;
        border-radius: 6px; line-height: 1; transition: color 0.2s, background 0.2s;
    }
    .email-notif-warning .en-close:hover { color: #f59e0b; background: rgba(245, 158, 11, 0.08); }
    html.dark-mode .email-notif-warning {
        background: #2b2f33;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.3);
    }
    html.dark-mode .email-notif-warning .en-icon  { background: rgba(245, 158, 11, 0.18); color: #fbbf24; }
    html.dark-mode .email-notif-warning .en-title { color: #fbbf24; }
    html.dark-mode .email-notif-warning .en-sub   { color: #8a9099; }
    html.dark-mode .email-notif-warning .en-meta  { color: #c8cdd3; }
    html.dark-mode .email-notif-warning .en-close { color: #6c757d; }
    html.dark-mode .email-notif-warning .en-close:hover { color: #fbbf24; background: rgba(245, 158, 11, 0.15); }

    /* Responsive adjustments */
    @media (max-width: 768px) {
        .page-title { font-size: 1.35rem; }
        .card-body { padding: 1rem; }
        .section-title { font-size: 1rem; }
        .form-label { font-size: 0.9rem; }
        .form-text { font-size: 0.75rem; }
        .form-control, .form-select { font-size: 0.9rem; }
        .d-flex.justify-content-end.gap-2 {
            flex-direction: column;
        }
        .d-flex.justify-content-end.gap-2 .btn {
            width: 100%;
        }
        .image-preview-container {
            max-width: 100%;
        }
        .note-editor.note-frame .note-editing-area {
            min-height: 300px;
        }
    }
</style>
