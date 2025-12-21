<style>
    /* Breadcrumb Styling */
    .breadcrumb .breadcrumb-item a {
        color: #6c757d;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .breadcrumb .breadcrumb-item a:hover {
        color: #00a79d !important;
    }

    /* Divider Styling */
    .divider-custom {
        transition: width 0.3s ease;
    }

    /* Accordion Styling */
    .finance-accordion-container .accordion {
        --bs-accordion-border-color: transparent;
        --bs-accordion-border-width: 0;
        --bs-accordion-border-radius: 12px;
        --bs-accordion-inner-border-radius: 12px;
        --bs-accordion-btn-padding-x: 0;
        --bs-accordion-btn-padding-y: 0;
        --bs-accordion-body-padding-x: 0;
        --bs-accordion-body-padding-y: 0;
    }

    .finance-accordion-container .accordion-item {
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
        transition: all 0.3s ease;
        background: white;
        margin-bottom: 15px !important;
    }

    .finance-accordion-container .accordion-item:hover {
        box-shadow: 0 5px 20px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .finance-accordion-container .accordion-button {
        background-color: white;
        box-shadow: none !important;
        border: none;
        padding: 20px 25px;
        font-weight: 500;
        transition: all 0.3s ease;
        border-left: 4px solid #00a79d !important;
    }

    .finance-accordion-container .accordion-button:not(.collapsed) {
        background-color: white !important;
        color: inherit;
    }

    .finance-accordion-container .accordion-button:focus {
        border-color: #00a79d;
        box-shadow: 0 0 0 0.25rem rgba(0, 167, 157, 0.25) !important;
    }

    .finance-accordion-container .accordion-button::after {
        display: none;
    }

    .finance-accordion-container .accordion-icon {
        transition: transform 0.3s ease;
        font-size: 0.9rem;
        color: #00a79d;
    }

    .finance-accordion-container .accordion-button:not(.collapsed) .accordion-icon {
        transform: rotate(180deg);
    }

    /* Report List Styling */
    .finance-accordion-container .report-list {
        background-color: rgba(248, 249, 250, 0.5);
    }

    .finance-accordion-container .report-item {
        background-color: white;
        transition: all 0.3s ease;
        padding: 15px 25px !important;
    }

    .finance-accordion-container .report-item:hover {
        background-color: rgba(0, 167, 157, 0.03);
        padding-left: 30px;
    }

    .finance-accordion-container .report-item:last-child {
        border-bottom: none !important;
    }

    .finance-accordion-container .report-item h6 {
        font-size: 0.95rem;
        font-weight: 500;
        color: #333;
        margin-bottom: 3px;
        line-height: 1.4;
    }

    .finance-accordion-container .report-item small {
        font-size: 0.8rem;
    }

    /* Button Group Styling */
    .finance-accordion-container .action-buttons .btn-group {
        flex-wrap: nowrap;
    }

    .finance-accordion-container .action-buttons .btn {
        border-radius: 6px !important;
        padding: 6px 10px;
        font-size: 0.8rem;
        transition: all 0.3s ease;
        border-width: 1px;
    }

    .finance-accordion-container .action-buttons .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
    }

    /* ========== CUSTOM MODAL STYLING ========== */

    /* Share Modal Custom Styling */
    #shareModal .modal-content {
        border-radius: 12px;
        overflow: hidden;
        border: none;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    }

    #shareModal .modal-header {
        background-color: #00a79d;
        color: white;
        border-bottom: none;
        padding: 20px 25px;
    }

    #shareModal .modal-title {
        font-weight: 600;
        font-size: 1.25rem;
    }

    #shareModal .modal-header .btn-close {
        filter: brightness(0) invert(1);
        opacity: 0.8;
        transition: opacity 0.2s ease;
    }

    #shareModal .modal-header .btn-close:hover {
        opacity: 1;
        background-color: transparent;
    }

    #shareModal .modal-body {
        padding: 25px;
    }

    #shareModal .form-label {
        font-weight: 500;
        color: #495057;
        margin-bottom: 8px;
        font-size: 0.95rem;
    }

    #shareModal .form-control {
        border-radius: 8px;
        border: 1px solid #dee2e6;
        padding: 10px 15px;
        font-size: 0.95rem;
        background-color: #f8f9fa;
        transition: all 0.3s ease;
    }

    #shareModal .form-control:focus {
        border-color: #00a79d;
        box-shadow: 0 0 0 0.25rem rgba(0, 167, 157, 0.25);
        background-color: white;
    }

    /* Link input field clickable style */
    #shareModal #shareReportUrl {
        cursor: pointer;
        transition: all 0.3s ease;
    }

    #shareModal #shareReportUrl:hover {
        background-color: #e9ecef;
        border-color: #00a79d;
    }

    #shareModal #shareReportUrl:active {
        background-color: #dee2e6;
        transform: scale(0.995);
    }

    #shareModal .border-top {
        border-top: 1px solid #e9ecef !important;
        padding-top: 20px;
    }

    /* Share buttons in modal */
    #shareModal .btn-success {
        background-color: #25D366;
        border-color: #25D366;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    #shareModal .btn-success:hover {
        background-color: #128C7E;
        border-color: #128C7E;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(18, 140, 126, 0.3);
    }

    #shareModal .btn-primary {
        background-color: #0088cc;
        border-color: #0088cc;
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    #shareModal .btn-primary:hover {
        background-color: #0077b5;
        border-color: #0077b5;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 119, 181, 0.3);
    }

    #shareModal .btn-outline-primary {
        border-radius: 8px;
        padding: 10px 20px;
        font-weight: 500;
        transition: all 0.3s ease;
        color: #00a79d;
        border-color: #00a79d;
    }

    #shareModal .btn-outline-primary:hover {
        background-color: #00a79d;
        border-color: #00a79d;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 167, 157, 0.3);
    }

    /* Modal responsive design */
    @media (max-width: 576px) {
        #shareModal .modal-dialog {
            margin: 10px;
        }

        #shareModal .modal-body {
            padding: 20px;
        }

        #shareModal .d-flex.justify-content-center.gap-3 {
            flex-direction: column;
            gap: 10px !important;
        }

        #shareModal .btn {
            width: 100%;
            margin-bottom: 5px;
        }
    }

    /* Toast notification styling */
    .toast-alert {
        z-index: 1060;
        border-radius: 12px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.1);
        font-weight: 500;
    }

    /* Tooltip customization */
    .custom-tooltip .tooltip-inner {
        background-color: #00a79d;
        color: white;
        border-radius: 12px;
        padding: 8px 12px;
        font-size: 0.85rem;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .custom-tooltip.bs-tooltip-top .tooltip-arrow::before {
        border-top-color: #00a79d;
    }

    .custom-tooltip.bs-tooltip-bottom .tooltip-arrow::before {
        border-bottom-color: #00a79d;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .finance-accordion-container .accordion-button {
            padding: 15px 20px;
        }

        .finance-accordion-container .report-item {
            flex-direction: column;
            align-items: flex-start !important;
            padding: 15px !important;
        }

        .finance-accordion-container .report-item:hover {
            padding-left: 20px !important;
        }

        .finance-accordion-container .action-buttons {
            width: 100%;
            margin-top: 10px;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        .finance-accordion-container .action-buttons .btn-group {
            justify-content: center;
            width: 100%;
        }

        .finance-accordion-container .d-flex.align-items-center .flex-shrink-0 .rounded-circle {
            width: 35px !important;
            height: 35px !important;
        }

        .finance-accordion-container .accordion-button .d-flex.align-items-center .flex-shrink-0 .rounded-circle {
            width: 40px !important;
            height: 40px !important;
        }
    }

    @media (max-width: 576px) {
        .finance-accordion-container .report-item h6 {
            font-size: 0.9rem;
        }

        .finance-accordion-container .action-buttons .btn {
            padding: 5px 8px;
            font-size: 0.75rem;
        }
    }

    /* PDF Icon Animation */
    .fa-file-pdf {
        position: relative;
        transition: transform 0.3s ease;
    }

    .report-item:hover .fa-file-pdf {
        transform: scale(1.1);
        animation: pulse 1.5s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.15);
        }
        100% {
            transform: scale(1);
        }
    }

    /* Tooltip Styling */
    .tooltip {
        font-size: 0.85rem;
    }

    /* Empty State */
    .empty-state-icon {
        font-size: 4rem;
        opacity: 0.3;
    }

    /* Card hover effect */
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }
</style>
