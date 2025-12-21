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
    }

    .finance-accordion-container .accordion-button:not(.collapsed) {
        background-color: rgba(0, 167, 157, 0.05);
        color: #00a79d;
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

    .btn-view {
        color: #3498db;
        border-color: #3498db;
        background-color: transparent;
    }

    .btn-view:hover {
        background-color: #3498db;
        color: white;
    }

    .btn-download {
        color: #2ecc71;
        border-color: #2ecc71;
        background-color: transparent;
    }

    .btn-download:hover {
        background-color: #2ecc71;
        color: white;
    }

    .btn-share {
        color: #9b59b6;
        border-color: #9b59b6;
        background-color: transparent;
    }

    .btn-share:hover {
        background-color: #9b59b6;
        color: white;
    }

    /* Modal Styling */
    #shareModal .modal-header {
        background-color: #00a79d;
        color: white;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    #shareModal .btn-share-whatsapp {
        background-color: #25D366;
        border-color: #25D366;
        color: white;
    }

    #shareModal .btn-share-telegram {
        background-color: #0088cc;
        border-color: #0088cc;
        color: white;
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

    /* Animation */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .wow.fadeInUp {
        animation: fadeInUp 0.5s ease forwards;
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

    /* Toast Styling */
    .toast-alert {
        z-index: 9999;
    }

    /* Empty State */
    .empty-state-icon {
        font-size: 4rem;
        opacity: 0.3;
    }
</style>
