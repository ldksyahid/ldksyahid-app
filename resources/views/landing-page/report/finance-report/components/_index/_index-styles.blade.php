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

    /* Table Styling */
    .finance-report-container .table {
        margin-bottom: 0;
    }

    .finance-report-container .table thead th {
        background-color: #f8f9fa;
        border-bottom: 2px solid #00a79d;
        color: #495057;
        font-weight: 600;
        padding: 15px 12px;
    }

    .finance-report-container .table tbody td {
        padding: 15px 12px;
        vertical-align: middle;
        border-bottom: 1px solid #eee;
    }

    .finance-report-container .table tbody tr:hover {
        background-color: rgba(0, 168, 204, 0.05);
    }

    /* Report Row Styling */
    .report-row {
        transition: all 0.3s ease;
    }

    .report-row:hover {
        transform: translateX(5px);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }

    /* Card Styling */
    .finance-report-container .card {
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .finance-report-container .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .finance-report-container .card-header {
        border-bottom: 2px solid #00a79d;
    }

    /* Button Group Styling */
    .btn-group .btn {
        border-radius: 6px !important;
        margin: 0 2px;
        transition: all 0.3s ease;
    }

    .btn-group .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .btn-view {
        color: #3498db;
        border-color: #3498db;
    }

    .btn-view:hover {
        background-color: #3498db;
        color: white;
    }

    .btn-download {
        color: #2ecc71;
        border-color: #2ecc71;
    }

    .btn-download:hover {
        background-color: #2ecc71;
        color: white;
    }

    .btn-share {
        color: #9b59b6;
        border-color: #9b59b6;
    }

    .btn-share:hover {
        background-color: #9b59b6;
        color: white;
    }

    /* Badge Styling */
    .badge.bg-primary {
        background-color: #00a79d !important;
    }

    .badge.bg-light {
        font-weight: 500;
        padding: 5px 12px;
    }

    /* Modal Styling */
    #shareModal .modal-header {
        background-color: #00a79d;
        color: white;
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
        .finance-report-container .table {
            display: block;
            overflow-x: auto;
        }

        .finance-report-container .table thead {
            display: none;
        }

        .finance-report-container .table tbody tr {
            display: block;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
        }

        .finance-report-container .table tbody td {
            display: block;
            text-align: center;
            border: none;
            padding: 10px;
        }

        .finance-report-container .table tbody td:before {
            content: attr(data-label);
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
            color: #00a79d;
        }

        .btn-group {
            justify-content: center;
        }

        .finance-report-container .card-header {
            flex-direction: column;
            text-align: center;
        }

        .finance-report-container .card-header .badge {
            margin-top: 10px;
        }
    }

    /* Animation for table rows */
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

    .report-row {
        animation: fadeInUp 0.5s ease forwards;
    }

    /* Loading animation */
    .skeleton-loading {
        background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
        background-size: 200% 100%;
        animation: loading 1.5s infinite;
    }

    @keyframes loading {
        0% {
            background-position: 200% 0;
        }
        100% {
            background-position: -200% 0;
        }
    }

    /* PDF Icon Animation */
    .fa-file-pdf {
        animation: pulse 2s infinite;
    }

    @keyframes pulse {
        0% {
            transform: scale(1);
        }
        50% {
            transform: scale(1.1);
        }
        100% {
            transform: scale(1);
        }
    }

    /* Divider Styling */
    .divider-custom {
        transition: width 0.3s ease;
    }

    .card:hover .divider-custom {
        width: 150px;
    }
</style>
