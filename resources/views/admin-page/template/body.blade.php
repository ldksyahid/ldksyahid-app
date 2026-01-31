<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{-- Off This Meta For Development --}}
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests" />
    <title>{{ $title ?? 'Admin Panel' }} &#9679; LDK Syahid</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- include libraries(jQuery, bootstrap) -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.4/summernote.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Favicon -->
    <link href="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Heebo:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="{{ asset('admin-page-ext-rsrc/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-page-ext-rsrc/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css') }}" rel="stylesheet" />

    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ asset('admin-page-ext-rsrc/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/required-field.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ asset('admin-page-ext-rsrc/css/style.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.0.3/css/buttons.dataTables.min.css">
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <!-- Flatpickr -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    @yield('head')

    <!-- Anti-flash script untuk mencegah flash konten putih -->
    <style>
        /* Anti-flash styling - diterapkan sebelum JavaScript berjalan */
        :root {
            --dark-mode-bg: #1a1d21;
            --light-mode-bg: #ffffff;
        }

        /* Initial state - menggunakan localStorage jika ada, default light mode */
        body {
            background-color: var(--light-mode-bg);
            transition: background-color 0.3s ease;
        }

        /* Dark mode class akan ditambahkan oleh JavaScript */
        html.dark-mode,
        html.dark-mode body {
            background-color: var(--dark-mode-bg) !important;
        }
    </style>

    <script>
        // Synchronous - runs immediately before any rendering
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
</head>

<body>
    <script>
        // Runs immediately when body is available - ensures body has the class
        if (localStorage.getItem('darkMode') === 'enabled') {
            document.body.classList.add('dark-mode');
        }
    </script>
    <!-- Custom Styles untuk dark/light mode -->
    <style>
        /* Light mode default */
        body {
            background-color: #ffffff !important;
            color: #212529;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dark mode overrides - digunakan saat class dark-mode ada di html atau body */
        html.dark-mode body {
            background-color: #1a1d21 !important;
            color: #e4e6eb;
        }

        /* Active dropdown item styling */
        .sidebar .navbar .dropdown-item.active {
            color: var(--primary);
            background: #FFFFFF;
            font-weight: 500;
        }

        /* Breadcrumb styling */
        .breadcrumb-item + .breadcrumb-item::before {
            content: "/" !important;
            color: #6c757d;
        }

        /* Fix navbar connection with sidebar - remove the gap */
        .container-xxl {
            background: #FFFFFF !important;
            transition: background-color 0.3s ease;
        }

        .content {
            background: #FFFFFF;
            transition: background-color 0.3s ease;
        }

        .content > .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            background: var(--light) !important;
            border-radius: 0 0 12px 12px;
            transition: background-color 0.3s ease;
        }

        .sidebar.pe-4 {
            padding-right: 1 !important;
        }

        /* Dark Mode Overrides - menggunakan selector html.dark-mode */
        html.dark-mode .container-xxl {
            background: #212529 !important;
        }

        html.dark-mode .content {
            background: #1a1d21;
        }

        html.dark-mode .sidebar {
            background: #212529;
        }

        html.dark-mode .sidebar .navbar {
            background: #212529 !important;
        }

        html.dark-mode .sidebar .navbar .navbar-nav .nav-link {
            color: #e4e6eb;
            border-left-color: #212529;
        }

        html.dark-mode .sidebar .navbar .navbar-nav .nav-link:hover,
        html.dark-mode .sidebar .navbar .navbar-nav .nav-link.active {
            color: var(--primary);
            background: #2b2f33;
            border-color: var(--primary);
        }

        html.dark-mode .sidebar .navbar .navbar-nav .nav-link i {
            background: #2b2f33;
        }

        html.dark-mode .sidebar .navbar .navbar-nav .nav-link:hover i,
        html.dark-mode .sidebar .navbar .navbar-nav .nav-link.active i {
            background: #373b3e;
        }

        html.dark-mode .sidebar .navbar .dropdown-item {
            color: #b0b3b8;
        }

        html.dark-mode .sidebar .navbar .dropdown-item:hover,
        html.dark-mode .sidebar .navbar .dropdown-item.active {
            color: var(--primary);
            background: #2b2f33;
        }

        html.dark-mode .content .navbar {
            background: #212529 !important;
            border-radius: 0 0 12px 12px;
        }

        html.dark-mode .content .navbar .navbar-nav .nav-link {
            color: #e4e6eb;
        }

        html.dark-mode .content .navbar .navbar-nav .nav-link:hover,
        html.dark-mode .content .navbar .navbar-nav .nav-link.active {
            color: var(--primary);
        }

        html.dark-mode .content .navbar .sidebar-toggler,
        html.dark-mode .content .navbar .navbar-nav .nav-link i {
            background: #2b2f33;
            color: #e4e6eb;
        }

        html.dark-mode .breadcrumb-item + .breadcrumb-item::before {
            color: #b0b3b8;
        }

        html.dark-mode .breadcrumb-item .text-muted {
            color: #b0b3b8 !important;
        }

        html.dark-mode .breadcrumb-item .text-dark {
            color: #e4e6eb !important;
        }

        html.dark-mode .content .navbar .dropdown-menu {
            background: #2b2f33 !important;
            border-color: #373b3e !important;
            border-radius: 0 0 12px 12px;
            animation: dropdownSlide 0.25s ease-out;
            transform-origin: top center;
        }

        @keyframes dropdownSlide {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        html.dark-mode .content .navbar .dropdown-item {
            color: #e4e6eb;
        }

        html.dark-mode .content .navbar .dropdown-item:hover {
            background: #373b3e;
            color: var(--primary);
        }

        html.dark-mode #spinner {
            background: #1a1d21 !important;
        }

        html.dark-mode .card,
        html.dark-mode .bg-light {
            background: #2b2f33 !important;
            border-color: #373b3e !important;
        }

        html.dark-mode .card {
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        html.dark-mode .card-header {
            background: #212529 !important;
            border-color: #373b3e !important;
            color: #e4e6eb;
        }

        html.dark-mode .card-body,
        html.dark-mode .card-footer {
            color: #e4e6eb;
        }

        html.dark-mode h1,
        html.dark-mode h2,
        html.dark-mode h3,
        html.dark-mode h4,
        html.dark-mode h5,
        html.dark-mode h6,
        html.dark-mode p,
        html.dark-mode span,
        html.dark-mode label,
        html.dark-mode .text-dark {
            color: #e4e6eb !important;
        }

        html.dark-mode .text-muted {
            color: #b0b3b8 !important;
        }

        html.dark-mode .text-secondary {
            color: #b0b3b8 !important;
        }

        html.dark-mode .form-control,
        html.dark-mode .form-select {
            background-color: #1a1d21;
            border-color: #373b3e;
            color: #e4e6eb;
        }

        html.dark-mode .form-control:focus,
        html.dark-mode .form-select:focus {
            background-color: #1a1d21;
            border-color: var(--primary);
            color: #e4e6eb;
        }

        html.dark-mode .form-control::placeholder {
            color: #6c757d;
        }

        html.dark-mode .form-control:-webkit-autofill,
        html.dark-mode .form-control:-webkit-autofill:hover,
        html.dark-mode .form-control:-webkit-autofill:focus,
        html.dark-mode .form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #1a1d21 inset !important;
            -webkit-text-fill-color: #e4e6eb !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        html.dark-mode .input-group-text {
            background-color: #212529;
            border-color: #373b3e;
            color: #b0b3b8;
        }

        html.dark-mode .table {
            color: #e4e6eb;
        }

        html.dark-mode .table thead th {
            border-color: #373b3e;
        }

        html.dark-mode .table td,
        html.dark-mode .table th {
            border-color: #373b3e;
        }

        html.dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255,255,255,0.02);
        }

        html.dark-mode .table-hover tbody tr:hover {
            background-color: rgba(0,167,157,0.1) !important;
            color: #e4e6eb;
        }

        html.dark-mode .modal-content {
            background-color: #2b2f33;
            border-color: #373b3e;
            color: #e4e6eb;
        }

        html.dark-mode .modal-header {
            border-color: #373b3e;
        }

        html.dark-mode .modal-footer {
            border-color: #373b3e;
        }

        html.dark-mode .dropdown-menu {
            background-color: #2b2f33;
            border-color: #373b3e;
        }

        html.dark-mode .dropdown-item {
            color: #e4e6eb;
        }

        html.dark-mode .dropdown-item:hover {
            background-color: #373b3e;
            color: var(--primary);
        }

        html.dark-mode .list-group-item {
            background-color: #2b2f33;
            border-color: #373b3e;
            color: #e4e6eb;
        }

        html.dark-mode .border {
            border-color: #373b3e !important;
        }

        html.dark-mode hr {
            border-color: #373b3e;
        }

        html.dark-mode .bg-white {
            background-color: #1a1d21 !important;
        }

        html.dark-mode .shadow,
        html.dark-mode .shadow-sm {
            box-shadow: 0 0 10px rgba(0,0,0,0.4) !important;
        }

        /* SweetAlert dark mode */
        html.dark-mode .swal2-popup {
            background: #2b2f33 !important;
            color: #e4e6eb !important;
        }

        html.dark-mode .swal2-title {
            color: #e4e6eb !important;
        }

        html.dark-mode .swal2-html-container {
            color: #b0b3b8 !important;
        }

        html.dark-mode .swal2-input {
            background: #1a1d21 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }

        /* Scrollbar dark mode */
        html.dark-mode ::-webkit-scrollbar {
            width: 8px;
        }

        html.dark-mode ::-webkit-scrollbar-track {
            background: #1a1d21;
        }

        html.dark-mode ::-webkit-scrollbar-thumb {
            background: #373b3e;
            border-radius: 4px;
        }

        html.dark-mode ::-webkit-scrollbar-thumb:hover {
            background: #4a4f54;
        }

        /* DataTables dark mode */
        html.dark-mode .dataTables_wrapper .dataTables_length,
        html.dark-mode .dataTables_wrapper .dataTables_filter,
        html.dark-mode .dataTables_wrapper .dataTables_info,
        html.dark-mode .dataTables_wrapper .dataTables_paginate {
            color: #b0b3b8;
        }

        html.dark-mode .dataTables_wrapper .dataTables_filter input,
        html.dark-mode .dataTables_wrapper .dataTables_length select {
            background-color: #1a1d21;
            border-color: #373b3e;
            color: #e4e6eb;
        }

        html.dark-mode .page-link {
            background-color: #2b2f33;
            border-color: #373b3e;
            color: #e4e6eb;
        }

        html.dark-mode .page-link:hover {
            background-color: #373b3e;
            color: var(--primary);
        }

        html.dark-mode .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        /* Select2 dark mode */
        html.dark-mode .select2-container--default .select2-selection--single {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
        }

        html.dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #e4e6eb !important;
        }

        html.dark-mode .select2-dropdown {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
        }

        html.dark-mode .select2-container--default .select2-results__option {
            color: #e4e6eb !important;
        }

        html.dark-mode .select2-container--default .select2-results__option[aria-selected="true"] {
            background-color: #373b3e !important;
            color: var(--primary) !important;
        }

        html.dark-mode .select2-search--dropdown .select2-search__field {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }

        /* Footer dark mode */
        html.dark-mode footer,
        html.dark-mode .footer {
            background: #212529 !important;
            color: #b0b3b8 !important;
        }

        html.dark-mode footer a {
            color: var(--primary) !important;
        }

        /* Sidebar brand/logo area */
        html.dark-mode .sidebar .navbar-brand {
            color: #e4e6eb;
        }

        /* Daterangepicker dark mode (global) */
        html.dark-mode .daterangepicker {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        html.dark-mode .daterangepicker::before,
        html.dark-mode .daterangepicker::after {
            border-bottom-color: #2b2f33 !important;
        }
        html.dark-mode .daterangepicker .calendar-table {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
        }
        html.dark-mode .daterangepicker .calendar-table thead tr:first-child th,
        html.dark-mode .daterangepicker .calendar-table thead tr:last-child th {
            color: #e4e6eb !important;
        }
        html.dark-mode .daterangepicker td,
        html.dark-mode .daterangepicker th {
            color: #e4e6eb !important;
        }
        html.dark-mode .daterangepicker td.off,
        html.dark-mode .daterangepicker td.off.in-range,
        html.dark-mode .daterangepicker td.off.start-date,
        html.dark-mode .daterangepicker td.off.end-date {
            color: #6c757d !important;
            background-color: transparent !important;
        }
        html.dark-mode .daterangepicker td.available:hover,
        html.dark-mode .daterangepicker th.available:hover {
            background-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        html.dark-mode .daterangepicker td.in-range {
            background-color: rgba(0, 167, 157, 0.2) !important;
            color: #e4e6eb !important;
        }
        html.dark-mode .daterangepicker td.active,
        html.dark-mode .daterangepicker td.active:hover,
        html.dark-mode .daterangepicker td.start-date,
        html.dark-mode .daterangepicker td.end-date {
            background-color: #00a79d !important;
            color: #fff !important;
        }
        html.dark-mode .daterangepicker td.today {
            color: #00a79d !important;
            font-weight: bold;
        }
        html.dark-mode .daterangepicker td.today.active {
            color: #fff !important;
        }
        html.dark-mode .daterangepicker .drp-buttons {
            border-top-color: #373b3e !important;
        }
        html.dark-mode .daterangepicker .drp-buttons .btn.cancelBtn {
            color: #b0b3b8 !important;
            background-color: transparent !important;
        }
        html.dark-mode .daterangepicker .drp-buttons .btn.cancelBtn:hover {
            background-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        html.dark-mode .daterangepicker .drp-selected {
            color: #b0b3b8 !important;
        }
        html.dark-mode .daterangepicker select.monthselect,
        html.dark-mode .daterangepicker select.yearselect {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        html.dark-mode .daterangepicker .ranges li {
            color: #e4e6eb !important;
        }
        html.dark-mode .daterangepicker .ranges li:hover {
            background-color: #373b3e !important;
        }
        html.dark-mode .daterangepicker .ranges li.active {
            background-color: #00a79d !important;
            color: #fff !important;
        }

        /* Global form dark mode overrides (all admin forms) */
        html.dark-mode .section-title {
            color: #00a79d;
            border-bottom-color: #373b3e;
        }
        html.dark-mode .form-text {
            color: #b0b3b8 !important;
        }
        html.dark-mode .form-label,
        html.dark-mode .form-label.fw-bold {
            color: #e4e6eb !important;
        }
        html.dark-mode .form-control-plaintext {
            color: #e4e6eb;
        }
        html.dark-mode .info-card {
            border-color: #373b3e !important;
            border-left-color: #00a79d !important;
            background-color: #2b2f33 !important;
            color: #e4e6eb;
        }
        html.dark-mode .image-preview-container {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
        }
        html.dark-mode .no-image-placeholder {
            color: #b0b3b8 !important;
        }
        html.dark-mode .role-option {
            background-color: #1a1d21;
            border-color: #373b3e;
            color: #e4e6eb;
        }
        html.dark-mode .role-option:hover {
            border-color: #00a79d;
            background-color: #2b2f33;
        }
        html.dark-mode .role-option.selected {
            border-color: #00a79d;
            background-color: rgba(0, 167, 157, 0.15);
        }
        html.dark-mode .role-option input[type="radio"] {
            border-color: #373b3e;
            background-color: #1a1d21;
        }
        html.dark-mode .role-option input[type="radio"]:checked {
            border-color: #00a79d;
            background-color: #1a1d21;
        }
        /* Card guide (index pages) */
        html.dark-mode .card-guide {
            background: #2b2f33 !important;
            border-color: #373b3e !important;
        }
        html.dark-mode .card-guide .card-title {
            color: #e4e6eb !important;
        }
        html.dark-mode .card-guide .card-text {
            color: #b0b3b8 !important;
        }
        /* Summernote editor dark mode */
        html.dark-mode .note-editor {
            border-color: #373b3e !important;
        }
        html.dark-mode .note-editor .note-toolbar {
            background-color: #212529 !important;
            border-color: #373b3e !important;
        }
        html.dark-mode .note-editor .note-editing-area .note-editable {
            background-color: #1a1d21 !important;
            color: #e4e6eb !important;
        }
        html.dark-mode .note-editor .note-statusbar {
            background-color: #212529 !important;
            border-color: #373b3e !important;
        }
        html.dark-mode .note-btn {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        /* Toggle switch (jumbotron) */
        html.dark-mode .toggle-switch {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        html.dark-mode .toggle-switch:hover {
            border-color: #00a79d !important;
            background-color: rgba(0, 167, 157, 0.1) !important;
        }
        html.dark-mode .toggle-switch input[type="checkbox"] {
            border-color: #373b3e;
            background-color: #1a1d21;
        }
        /* Button fields container (jumbotron) */
        html.dark-mode .button-fields {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        /* Content preview (news) */
        html.dark-mode .news-content-preview {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        /* Container fluid bg-light inside content - slightly different shade for contrast */
        html.dark-mode .content .container-fluid .bg-light {
            background: #212529 !important;
            border: 1px solid #373b3e !important;
        }
        /* File input dark mode */
        html.dark-mode .form-control[type="file"] {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
            color: #b0b3b8 !important;
        }
        html.dark-mode .form-control[type="file"]::file-selector-button {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        /* Input group (event contact, etc.) */
        html.dark-mode .input-group .input-group-text {
            background-color: #212529 !important;
            border-color: #373b3e !important;
            color: #b0b3b8 !important;
        }
        /* Link field (call-kestari) */
        html.dark-mode .link-field {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
        }
        /* Reader link preview (catalog-book) */
        html.dark-mode .reader-link-preview,
        html.dark-mode .reader-link-content {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        /* Finance report card bg-light */
        html.dark-mode .card.bg-light {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
        }
        /* Campaign progress info (celsyahid) */
        html.dark-mode .progress {
            background-color: #373b3e !important;
        }
        /* No media/image placeholder */
        html.dark-mode .no-media-placeholder,
        html.dark-mode .no-image-placeholder {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
            color: #b0b3b8 !important;
        }
        /* Select2 in forms (all modules) */
        html.dark-mode .select2-container--default .select2-selection--single {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        html.dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #e4e6eb !important;
        }
        html.dark-mode .select2-container--default .select2-selection--single .select2-selection__placeholder {
            color: #6c757d !important;
        }
        html.dark-mode .select2-dropdown {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
        }
        html.dark-mode .select2-search--dropdown .select2-search__field {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }
        html.dark-mode .select2-container--default .select2-results__option {
            color: #e4e6eb !important;
        }
        html.dark-mode .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #00a79d !important;
            color: #fff !important;
        }
        html.dark-mode .select2-container--default .select2-results__option[aria-selected="true"] {
            background-color: #373b3e !important;
            color: var(--primary) !important;
        }
        html.dark-mode .select2-container--default .select2-results__option:hover {
            background-color: #373b3e !important;
        }

        /* SVG Placeholder dark mode */
        html.dark-mode .svg-placeholder {
            border-color: #373b3e !important;
        }
        html.dark-mode .svg-placeholder-bg { fill: #2b2f33; }
        html.dark-mode .svg-placeholder-mountain { fill: #373b3e; }
        html.dark-mode .svg-placeholder-mountain-sm { fill: #4a4f54; }
        html.dark-mode .svg-placeholder-sun { fill: #4a4f54; }
        html.dark-mode .svg-placeholder-ground { fill: #373b3e; }
        html.dark-mode .svg-placeholder-text { fill: #6c757d; }

        /* Flatpickr general overrides (light + dark) */
        .flatpickr-current-month {
            font-size: 110% !important;
        }
        .flatpickr-current-month .cur-month {
            font-weight: 500;
        }
        .flatpickr-current-month input.cur-year {
            font-weight: 500;
        }

        /* Flatpickr dark mode */
        html.dark-mode .flatpickr-calendar {
            background: #2b2f33 !important;
            border-color: #373b3e !important;
            box-shadow: 0 0 10px rgba(0,0,0,0.4) !important;
        }
        html.dark-mode .flatpickr-calendar::before,
        html.dark-mode .flatpickr-calendar::after {
            border-bottom-color: #2b2f33 !important;
        }
        html.dark-mode .flatpickr-months {
            background: #212529 !important;
            border-radius: 5px 5px 0 0;
        }
        html.dark-mode .flatpickr-months .flatpickr-month,
        html.dark-mode .flatpickr-months .flatpickr-prev-month,
        html.dark-mode .flatpickr-months .flatpickr-next-month {
            color: #e4e6eb !important;
            fill: #e4e6eb !important;
        }
        html.dark-mode .flatpickr-months .flatpickr-prev-month:hover,
        html.dark-mode .flatpickr-months .flatpickr-next-month:hover {
            color: #00a79d !important;
        }
        html.dark-mode .flatpickr-months .flatpickr-prev-month:hover svg,
        html.dark-mode .flatpickr-months .flatpickr-next-month:hover svg {
            fill: #00a79d !important;
        }
        html.dark-mode .flatpickr-current-month .cur-month,
        html.dark-mode .flatpickr-current-month input.cur-year {
            color: #e4e6eb !important;
        }
        html.dark-mode .flatpickr-weekdays {
            background: #212529 !important;
        }
        html.dark-mode span.flatpickr-weekday {
            color: #b0b3b8 !important;
            background: #212529 !important;
        }
        html.dark-mode .flatpickr-day {
            color: #e4e6eb !important;
        }
        html.dark-mode .flatpickr-day:hover {
            background: #373b3e !important;
            border-color: #373b3e !important;
        }
        html.dark-mode .flatpickr-day.today {
            border-color: #00a79d !important;
            color: #00a79d !important;
        }
        html.dark-mode .flatpickr-day.today:hover {
            background: #00a79d !important;
            color: #fff !important;
        }
        html.dark-mode .flatpickr-day.selected,
        html.dark-mode .flatpickr-day.selected:hover {
            background: #00a79d !important;
            border-color: #00a79d !important;
            color: #fff !important;
        }
        html.dark-mode .flatpickr-day.prevMonthDay,
        html.dark-mode .flatpickr-day.nextMonthDay {
            color: #6c757d !important;
        }
        html.dark-mode .flatpickr-day.disabled,
        html.dark-mode .flatpickr-day.disabled:hover {
            color: #4a4f54 !important;
        }
        html.dark-mode .flatpickr-time {
            background: #2b2f33 !important;
            border-color: #373b3e !important;
        }
        html.dark-mode .flatpickr-time input {
            color: #e4e6eb !important;
        }
        html.dark-mode .flatpickr-time input:hover,
        html.dark-mode .flatpickr-time input:focus {
            background: #373b3e !important;
        }
        html.dark-mode .flatpickr-time .flatpickr-am-pm {
            color: #e4e6eb !important;
        }
        html.dark-mode .flatpickr-time .flatpickr-am-pm:hover {
            background: #373b3e !important;
        }
        html.dark-mode .flatpickr-time .flatpickr-time-separator {
            color: #e4e6eb !important;
        }

        /* Light mode autofill */
        html:not(.dark-mode) .form-control:-webkit-autofill,
        html:not(.dark-mode) .form-control:-webkit-autofill:hover,
        html:not(.dark-mode) .form-control:-webkit-autofill:focus,
        html:not(.dark-mode) .form-control:-webkit-autofill:active {
            -webkit-box-shadow: 0 0 0 1000px #ffffff inset !important;
            -webkit-text-fill-color: #212529 !important;
            transition: background-color 5000s ease-in-out 0s;
        }

        /* Light mode specific overrides */
        html:not(.dark-mode) {
            background-color: #ffffff !important;
        }

        html:not(.dark-mode) .container-xxl {
            background: #FFFFFF !important;
        }

        html:not(.dark-mode) .content {
            background: #FFFFFF;
        }

        html:not(.dark-mode) .content > .navbar {
            background: var(--light) !important;
        }
    </style>

    @yield('styles')
    @stack('styles')

    <div class="container-xxl position-relative bg-white d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <!-- Spinner End -->

        <!-- Sidebar Start -->
        @include('admin-page.template.side-bar')
        <!-- Sidebar End -->

        <!-- Content Start -->
        <div class="content">
            <!-- Navbar Start -->
            @include('admin-page.template.nav-bar')
            <!-- Navbar End -->

            {{-- Body Admin Page Start --}}
            @yield('content')
            {{-- Body Admin Page End --}}

            <!-- Footer Start -->
            @include('admin-page.template.footer')
            <!-- Footer End -->
        </div>
        <!-- Content End -->

        <!-- Back to Top -->
        <a href="#" class="btn btn-lg btn-primary btn-lg-square back-to-top"><i class="bi bi-arrow-up"></i></a>
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <!-- Bootstrap JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>

    {{-- START Datatable FROM https://brilliansolution.com/tutorial-laravel-8-datatables-yajra-datatables/--}}
    <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.0.3/js/dataTables.buttons.min.js"></script>
    {{-- END Datatable FROM https://brilliansolution.com/tutorial-laravel-8-datatables-yajra-datatables/--}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin-page-ext-rsrc/lib/chart/chart.min.js') }}"></script>
    <script src="{{ asset('admin-page-ext-rsrc/lib/easing/easing.min.js') }}"></script>
    <script src="{{ asset('admin-page-ext-rsrc/lib/waypoints/waypoints.min.js') }}"></script>
    <script src="{{ asset('admin-page-ext-rsrc/lib/owlcarousel/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('admin-page-ext-rsrc/lib/tempusdominus/js/moment.min.js') }}"></script>
    <script src="{{ asset('admin-page-ext-rsrc/lib/tempusdominus/js/moment-timezone.min.js') }}"></script>
    <script src="{{ asset('admin-page-ext-rsrc/lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js') }}"></script>

    <!-- Template Javascript -->
    <script src="{{ asset('admin-page-ext-rsrc/js/main.js') }}"></script>

    {{-- Dark Mode Toggle Script --}}
    <script>
        $(function() {
            function updateToggleSwitch(isDark) {
                var $toggle = $('#darkModeToggle');
                if (isDark) {
                    $toggle.css('background', '#00a79d');
                    $toggle.find('.dark-mode-knob').css('transform', 'translateX(20px)');
                } else {
                    $toggle.css('background', '#ccc');
                    $toggle.find('.dark-mode-knob').css('transform', 'translateX(0)');
                }
            }

            // Initialize based on current state
            var isDark = document.documentElement.classList.contains('dark-mode');
            if (isDark) document.body.classList.add('dark-mode');
            updateToggleSwitch(isDark);

            $('#darkModeToggle').on('click', function() {
                isDark = !document.documentElement.classList.contains('dark-mode');

                if (isDark) {
                    document.documentElement.classList.add('dark-mode');
                    document.body.classList.add('dark-mode');
                } else {
                    document.documentElement.classList.remove('dark-mode');
                    document.body.classList.remove('dark-mode');
                }

                localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');
                updateToggleSwitch(isDark);
            });
        });
    </script>

    {{-- Global Flatpickr Init --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr('.flatpickr-date', {
                dateFormat: 'Y-m-d',
                altInput: true,
                altFormat: 'd/m/Y',
                allowInput: true,
                monthSelectorType: 'static'
            });
            flatpickr('.flatpickr-datetime', {
                dateFormat: 'Y-m-d H:i',
                altInput: true,
                altFormat: 'd/m/Y H:i',
                enableTime: true,
                time_24hr: true,
                allowInput: true,
                monthSelectorType: 'static'
            });
        });
    </script>

    {{-- Script Admin Page Start --}}
    @yield('scripts')
    @stack('scripts')
    {{-- Script Admin Page End --}}
    @include('sweetalert::alert')
</body>
</html>
