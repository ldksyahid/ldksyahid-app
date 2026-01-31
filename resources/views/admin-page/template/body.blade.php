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
        body.dark-mode {
            background-color: var(--dark-mode-bg) !important;
        }
    </style>

    <script>
        // Cek localStorage saat halaman dimuat
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeEnabled = localStorage.getItem('darkMode') === 'enabled';

            if (darkModeEnabled) {
                document.documentElement.classList.add('dark-mode');
                document.body.classList.add('dark-mode');
            } else {
                document.documentElement.classList.remove('dark-mode');
                document.body.classList.remove('dark-mode');
            }
        });
    </script>
</head>

<body>
    <!-- Custom Styles untuk dark/light mode -->
    <style>
        /* Light mode default */
        body {
            background-color: #ffffff !important;
            color: #212529;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        /* Dark mode overrides - digunakan saat class dark-mode ada di html atau body */
        html.dark-mode body,
        body.dark-mode {
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

        /* Dark Mode Overrides - menggunakan selector body.dark-mode */
        body.dark-mode .container-xxl {
            background: #212529 !important;
        }

        body.dark-mode .content {
            background: #1a1d21;
        }

        body.dark-mode .sidebar {
            background: #212529;
        }

        body.dark-mode .sidebar .navbar {
            background: #212529 !important;
        }

        body.dark-mode .sidebar .navbar .navbar-nav .nav-link {
            color: #e4e6eb;
            border-left-color: #212529;
        }

        body.dark-mode .sidebar .navbar .navbar-nav .nav-link:hover,
        body.dark-mode .sidebar .navbar .navbar-nav .nav-link.active {
            color: var(--primary);
            background: #2b2f33;
            border-color: var(--primary);
        }

        body.dark-mode .sidebar .navbar .navbar-nav .nav-link i {
            background: #2b2f33;
        }

        body.dark-mode .sidebar .navbar .navbar-nav .nav-link:hover i,
        body.dark-mode .sidebar .navbar .navbar-nav .nav-link.active i {
            background: #373b3e;
        }

        body.dark-mode .sidebar .navbar .dropdown-item {
            color: #b0b3b8;
        }

        body.dark-mode .sidebar .navbar .dropdown-item:hover,
        body.dark-mode .sidebar .navbar .dropdown-item.active {
            color: var(--primary);
            background: #2b2f33;
        }

        body.dark-mode .content .navbar {
            background: #212529 !important;
            border-radius: 0 0 12px 12px;
        }

        body.dark-mode .content .navbar .navbar-nav .nav-link {
            color: #e4e6eb;
        }

        body.dark-mode .content .navbar .navbar-nav .nav-link:hover,
        body.dark-mode .content .navbar .navbar-nav .nav-link.active {
            color: var(--primary);
        }

        body.dark-mode .content .navbar .sidebar-toggler,
        body.dark-mode .content .navbar .navbar-nav .nav-link i {
            background: #2b2f33;
            color: #e4e6eb;
        }

        body.dark-mode .breadcrumb-item + .breadcrumb-item::before {
            color: #b0b3b8;
        }

        body.dark-mode .breadcrumb-item .text-muted {
            color: #b0b3b8 !important;
        }

        body.dark-mode .breadcrumb-item .text-dark {
            color: #e4e6eb !important;
        }

        body.dark-mode .content .navbar .dropdown-menu {
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

        body.dark-mode .content .navbar .dropdown-item {
            color: #e4e6eb;
        }

        body.dark-mode .content .navbar .dropdown-item:hover {
            background: #373b3e;
            color: var(--primary);
        }

        body.dark-mode #spinner {
            background: #1a1d21 !important;
        }

        body.dark-mode .card,
        body.dark-mode .bg-light {
            background: #2b2f33 !important;
            border-color: #373b3e !important;
        }

        body.dark-mode .card {
            box-shadow: 0 0 10px rgba(0,0,0,0.3);
        }

        body.dark-mode .card-header {
            background: #212529 !important;
            border-color: #373b3e !important;
            color: #e4e6eb;
        }

        body.dark-mode .card-body,
        body.dark-mode .card-footer {
            color: #e4e6eb;
        }

        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode h5,
        body.dark-mode h6,
        body.dark-mode p,
        body.dark-mode span,
        body.dark-mode label,
        body.dark-mode .text-dark {
            color: #e4e6eb !important;
        }

        body.dark-mode .text-muted {
            color: #b0b3b8 !important;
        }

        body.dark-mode .text-secondary {
            color: #b0b3b8 !important;
        }

        body.dark-mode .form-control,
        body.dark-mode .form-select {
            background-color: #1a1d21;
            border-color: #373b3e;
            color: #e4e6eb;
        }

        body.dark-mode .form-control:focus,
        body.dark-mode .form-select:focus {
            background-color: #1a1d21;
            border-color: var(--primary);
            color: #e4e6eb;
        }

        body.dark-mode .form-control::placeholder {
            color: #6c757d;
        }

        body.dark-mode .input-group-text {
            background-color: #212529;
            border-color: #373b3e;
            color: #b0b3b8;
        }

        body.dark-mode .table {
            color: #e4e6eb;
        }

        body.dark-mode .table thead th {
            border-color: #373b3e;
        }

        body.dark-mode .table td,
        body.dark-mode .table th {
            border-color: #373b3e;
        }

        body.dark-mode .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(255,255,255,0.02);
        }

        body.dark-mode .table-hover tbody tr:hover {
            background-color: rgba(0,167,157,0.1) !important;
            color: #e4e6eb;
        }

        body.dark-mode .modal-content {
            background-color: #2b2f33;
            border-color: #373b3e;
            color: #e4e6eb;
        }

        body.dark-mode .modal-header {
            border-color: #373b3e;
        }

        body.dark-mode .modal-footer {
            border-color: #373b3e;
        }

        body.dark-mode .dropdown-menu {
            background-color: #2b2f33;
            border-color: #373b3e;
        }

        body.dark-mode .dropdown-item {
            color: #e4e6eb;
        }

        body.dark-mode .dropdown-item:hover {
            background-color: #373b3e;
            color: var(--primary);
        }

        body.dark-mode .list-group-item {
            background-color: #2b2f33;
            border-color: #373b3e;
            color: #e4e6eb;
        }

        body.dark-mode .border {
            border-color: #373b3e !important;
        }

        body.dark-mode hr {
            border-color: #373b3e;
        }

        body.dark-mode .bg-white {
            background-color: #1a1d21 !important;
        }

        body.dark-mode .shadow,
        body.dark-mode .shadow-sm {
            box-shadow: 0 0 10px rgba(0,0,0,0.4) !important;
        }

        /* SweetAlert dark mode */
        body.dark-mode .swal2-popup {
            background: #2b2f33 !important;
            color: #e4e6eb !important;
        }

        body.dark-mode .swal2-title {
            color: #e4e6eb !important;
        }

        body.dark-mode .swal2-html-container {
            color: #b0b3b8 !important;
        }

        body.dark-mode .swal2-input {
            background: #1a1d21 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }

        /* Scrollbar dark mode */
        body.dark-mode ::-webkit-scrollbar {
            width: 8px;
        }

        body.dark-mode ::-webkit-scrollbar-track {
            background: #1a1d21;
        }

        body.dark-mode ::-webkit-scrollbar-thumb {
            background: #373b3e;
            border-radius: 4px;
        }

        body.dark-mode ::-webkit-scrollbar-thumb:hover {
            background: #4a4f54;
        }

        /* DataTables dark mode */
        body.dark-mode .dataTables_wrapper .dataTables_length,
        body.dark-mode .dataTables_wrapper .dataTables_filter,
        body.dark-mode .dataTables_wrapper .dataTables_info,
        body.dark-mode .dataTables_wrapper .dataTables_paginate {
            color: #b0b3b8;
        }

        body.dark-mode .dataTables_wrapper .dataTables_filter input,
        body.dark-mode .dataTables_wrapper .dataTables_length select {
            background-color: #1a1d21;
            border-color: #373b3e;
            color: #e4e6eb;
        }

        body.dark-mode .page-link {
            background-color: #2b2f33;
            border-color: #373b3e;
            color: #e4e6eb;
        }

        body.dark-mode .page-link:hover {
            background-color: #373b3e;
            color: var(--primary);
        }

        body.dark-mode .page-item.active .page-link {
            background-color: var(--primary);
            border-color: var(--primary);
            color: #fff;
        }

        /* Select2 dark mode */
        body.dark-mode .select2-container--default .select2-selection--single {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
        }

        body.dark-mode .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #e4e6eb !important;
        }

        body.dark-mode .select2-dropdown {
            background-color: #2b2f33 !important;
            border-color: #373b3e !important;
        }

        body.dark-mode .select2-container--default .select2-results__option {
            color: #e4e6eb !important;
        }

        body.dark-mode .select2-container--default .select2-results__option[aria-selected="true"] {
            background-color: #373b3e !important;
            color: var(--primary) !important;
        }

        body.dark-mode .select2-search--dropdown .select2-search__field {
            background-color: #1a1d21 !important;
            border-color: #373b3e !important;
            color: #e4e6eb !important;
        }

        /* Footer dark mode */
        body.dark-mode footer,
        body.dark-mode .footer {
            background: #212529 !important;
            color: #b0b3b8 !important;
        }

        body.dark-mode footer a {
            color: var(--primary) !important;
        }

        /* Sidebar brand/logo area */
        body.dark-mode .sidebar .navbar-brand {
            color: #e4e6eb;
        }

        /* Light mode specific overrides */
        body:not(.dark-mode) {
            background-color: #ffffff !important;
        }

        body:not(.dark-mode) .container-xxl {
            background: #FFFFFF !important;
        }

        body:not(.dark-mode) .content {
            background: #FFFFFF;
        }

        body:not(.dark-mode) .content > .navbar {
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
            var isDark = document.body.classList.contains('dark-mode');
            updateToggleSwitch(isDark);

            $('#darkModeToggle').on('click', function() {
                isDark = !document.body.classList.contains('dark-mode');

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

    {{-- Script Admin Page Start --}}
    @yield('scripts')
    @stack('scripts')
    {{-- Script Admin Page End --}}
    @include('sweetalert::alert')
</body>
</html>
