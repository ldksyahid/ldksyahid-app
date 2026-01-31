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
            --transition-duration: 0s; /* No transition initially */
        }

        /* Initial state - menggunakan localStorage jika ada, default light mode */
        body {
            background-color: var(--light-mode-bg);
            transition: background-color var(--transition-duration) ease;
        }

        /* Dark mode class akan ditambahkan oleh JavaScript */
        html.dark-mode,
        html.dark-mode body {
            background-color: var(--dark-mode-bg) !important;
        }

        /* Profile Dropdown Animation */
        .dropdown-profile {
            border-radius: 0 0 12px 12px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 8px 0;
            transform-origin: top center;
        }
        .dropdown-profile.dropdown-animate-in {
            animation: dropdownFadeIn 0.25s ease-out forwards;
        }
        .dropdown-profile.dropdown-animate-out {
            animation: dropdownFadeOut 0.2s ease-in forwards;
        }
        @keyframes dropdownFadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes dropdownFadeOut {
            from { opacity: 1; transform: translateY(0); }
            to { opacity: 0; transform: translateY(-8px); }
        }

        /* Prevent transitions during initial load */
        .dark-mode-loading *:not(.sidebar):not(.content):not(#spinner) {
            transition: none !important;
        }

        /* Dark Mode Toggle Styles */
        .dark-mode-toggle-container {
            position: relative;
            display: inline-block;
        }

        .dark-mode-checkbox {
            opacity: 0;
            width: 0;
            height: 0;
            position: absolute;
        }

        .dark-mode-toggle {
            cursor: pointer;
            display: inline-block;
            position: relative;
            width: 60px;
            height: 30px;
        }

        .toggle-track {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
            border-radius: 34px;
            display: flex;
            align-items: center;
            height: 100%;
            position: relative;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.1);
        }

        .dark-mode-checkbox:checked + .dark-mode-toggle .toggle-track {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            box-shadow: 0 0 15px rgba(102, 126, 234, 0.4);
        }

        .toggle-thumb {
            background-color: white;
            border-radius: 50%;
            height: 26px;
            width: 26px;
            position: absolute;
            left: 2px;
            top: 2px;
            transition: transform 0.4s cubic-bezier(0.68, -0.55, 0.265, 1.55);
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.2);
            z-index: 2;
        }

        .dark-mode-checkbox:checked + .dark-mode-toggle .toggle-thumb {
            transform: translateX(30px);
            background-color: #f8f9fa;
            box-shadow: 0 2px 8px rgba(0,0,0,0.3);
        }

        .sun-icon, .moon-icon {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
            color: #ff9800;
            opacity: 1;
        }

        .moon-icon {
            color: #764ba2;
            opacity: 0;
            transform: rotate(-90deg);
        }

        .dark-mode-checkbox:checked + .dark-mode-toggle .sun-icon {
            opacity: 0;
            transform: rotate(90deg);
        }

        .dark-mode-checkbox:checked + .dark-mode-toggle .moon-icon {
            opacity: 1;
            transform: rotate(0deg);
        }

        /* Hover effects */
        .dark-mode-toggle:hover .toggle-track {
            box-shadow: inset 0 2px 8px rgba(0,0,0,0.2);
        }

        .dark-mode-checkbox:checked + .dark-mode-toggle:hover .toggle-track {
            box-shadow: 0 0 20px rgba(102, 126, 234, 0.6);
        }

        .dark-mode-toggle:hover .toggle-thumb {
            transform: scale(1.1);
            box-shadow: 0 3px 6px rgba(0,0,0,0.25);
        }

        .dark-mode-checkbox:checked + .dark-mode-toggle:hover .toggle-thumb {
            transform: translateX(30px) scale(1.1);
        }

        /* Focus states */
        .dark-mode-checkbox:focus + .dark-mode-toggle .toggle-track {
            outline: 2px solid #00a79d;
            outline-offset: 2px;
        }

        /* Dark mode specific adjustments */
        html.dark-mode .dark-mode-toggle {
            filter: brightness(0.9);
        }

        html.dark-mode .dark-mode-toggle .toggle-track {
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.3);
        }

        /* Ripple effect animation */
        @keyframes ripple {
            0% {
                box-shadow: 0 0 0 0 rgba(0, 167, 157, 0.7);
            }
            70% {
                box-shadow: 0 0 0 10px rgba(0, 167, 157, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(0, 167, 157, 0);
            }
        }

        .dark-mode-checkbox:checked + .dark-mode-toggle .toggle-thumb {
            animation: ripple 0.6s ease-out;
        }

        /* Dark mode toggle in navbar specific */
        .navbar .dark-mode-toggle {
            margin: 0;
        }

        .navbar .dark-mode-toggle-container {
            margin-right: -10px;
            margin-top: 7px;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .dark-mode-toggle {
                width: 50px;
                height: 25px;
            }

            .toggle-thumb {
                height: 21px;
                width: 21px;
                left: 2px;
                top: 2px;
            }

            .dark-mode-checkbox:checked + .dark-mode-toggle .toggle-thumb {
                transform: translateX(25px);
            }

            .sun-icon svg, .moon-icon svg {
                width: 14px;
                height: 14px;
            }
        }

        /* Tooltip for toggle */
        .dark-mode-toggle::after {
            content: 'Toggle Dark Mode';
            position: absolute;
            bottom: -30px;
            left: 50%;
            transform: translateX(-50%);
            background: rgba(0,0,0,0.8);
            color: white;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            white-space: nowrap;
            opacity: 0;
            transition: opacity 0.2s;
            pointer-events: none;
            z-index: 1000;
        }

        .dark-mode-toggle:hover::after {
            opacity: 1;
        }

        /* Notification styles */
        .dark-mode-notification {
            position: fixed;
            top: 80px;
            right: 20px;
            background: #00a79d;
            color: white;
            padding: 12px 20px;
            border-radius: 8px;
            box-shadow: 0 4px 12px rgba(0, 167, 157, 0.3);
            z-index: 9999;
            transform: translateX(150%);
            transition: transform 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .dark-mode-notification.show {
            transform: translateX(0);
        }

        .notification-content {
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        /* Transition classes */
        .dark-mode-transition-ready .container-xxl,
        .dark-mode-transition-ready .card,
        .dark-mode-transition-ready .navbar,
        .dark-mode-transition-ready .form-control,
        .dark-mode-transition-ready .form-select,
        .dark-mode-transition-ready .table,
        .dark-mode-transition-ready .modal-content,
        .dark-mode-transition-ready .dropdown-menu {
            transition: background-color 0.3s ease,
                        border-color 0.3s ease,
                        color 0.3s ease,
                        box-shadow 0.3s ease;
        }
        .dark-mode-transition-ready .sidebar {
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        background-color 0.3s ease,
                        border-color 0.3s ease !important;
        }
        .dark-mode-transition-ready .content {
            transition: margin-left 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        width 0.4s cubic-bezier(0.4, 0, 0.2, 1),
                        background-color 0.3s ease,
                        border-color 0.3s ease !important;
        }

        .dark-mode-transition {
            transition: all 0.3s ease !important;
        }

        /* Animation classes */
        .dark-mode-activated {
            animation: darkModeRipple 0.6s ease-out;
        }

        .light-mode-activated {
            animation: lightModeRipple 0.6s ease-out;
        }

        @keyframes darkModeRipple {
            0% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(102, 126, 234, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(102, 126, 234, 0);
            }
        }

        @keyframes lightModeRipple {
            0% {
                box-shadow: 0 0 0 0 rgba(246, 211, 101, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(246, 211, 101, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(246, 211, 101, 0);
            }
        }

        /* Accessibility improvements */
        .dark-mode-toggle:focus {
            outline: 2px solid #00a79d;
            outline-offset: 2px;
            border-radius: 4px;
        }

        .dark-mode-checkbox:focus-visible + .dark-mode-toggle .toggle-track {
            outline: 2px solid #00a79d;
            outline-offset: 2px;
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .dark-mode-toggle .toggle-track {
                border: 2px solid #333;
            }

            .dark-mode-checkbox:checked + .dark-mode-toggle .toggle-track {
                border: 2px solid #fff;
            }
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            .dark-mode-toggle .toggle-thumb,
            .dark-mode-notification,
            .dark-mode-transition-ready .container-xxl,
            .dark-mode-transition-ready .card,
            .dark-mode-transition-ready .navbar,
            .dark-mode-transition-ready .form-control,
            .dark-mode-transition-ready .form-select,
            .dark-mode-transition-ready .table,
            .dark-mode-transition-ready .modal-content,
            .dark-mode-transition-ready .dropdown-menu {
                transition: none !important;
                animation: none !important;
            }
        }
    </style>

    <script>
        // Synchronous - runs immediately before any rendering
        (function() {
            // Add loading class to prevent transitions
            document.documentElement.classList.add('dark-mode-loading');

            // Check saved preference
            const savedMode = localStorage.getItem('darkMode');
            const isDark = savedMode === 'enabled';

            if (isDark) {
                document.documentElement.classList.add('dark-mode');
                if (document.body) {
                    document.body.classList.add('dark-mode');
                }
            }

            // Remove loading class when DOM is ready
            function enableTransitions() {
                document.documentElement.classList.remove('dark-mode-loading');

                // Apply to body now that it exists
                if (isDark && document.body) {
                    document.body.classList.add('dark-mode');
                }

                // Update CSS variable for transitions
                document.documentElement.style.setProperty('--transition-duration', '0.3s');
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', enableTransitions);
            } else {
                enableTransitions();
            }
        })();
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var profileDropdowns = document.querySelectorAll('.dropdown-profile');
            profileDropdowns.forEach(function(menu) {
                var parent = menu.closest('.dropdown') || menu.closest('.nav-item');
                if (!parent) return;
                var closing = false;

                parent.addEventListener('shown.bs.dropdown', function() {
                    menu.classList.remove('dropdown-animate-out');
                    menu.classList.add('dropdown-animate-in');
                });

                parent.addEventListener('hide.bs.dropdown', function(e) {
                    if (closing) {
                        closing = false;
                        return;
                    }
                    e.preventDefault();
                    menu.classList.remove('dropdown-animate-in');
                    menu.classList.add('dropdown-animate-out');
                    menu.addEventListener('animationend', function handler() {
                        menu.classList.remove('dropdown-animate-out');
                        menu.removeEventListener('animationend', handler);
                        closing = true;
                        var toggle = parent.querySelector('[data-bs-toggle="dropdown"]');
                        var instance = bootstrap.Dropdown.getInstance(toggle);
                        if (instance) instance.hide();
                    });
                });
            });
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
        html.dark-mode body {
            background-color: #1a1d21 !important;
            color: #e4e6eb;
        }

        /* Smooth transitions for dark mode */
        html, body {
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .container-xxl,
        .content,
        .sidebar,
        .card,
        .navbar,
        .form-control,
        .form-select,
        .table,
        .modal-content,
        .dropdown-menu {
            transition: background-color 0.3s ease,
                        border-color 0.3s ease,
                        color 0.3s ease,
                        box-shadow 0.3s ease;
        }

        /* Spinner transition */
        #spinner {
            transition: background-color 0.3s ease;
        }

        /* LDK Logo Spinner */
        .spinner-ldk {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .ldk-logo-spinner {
            animation: ldkPulse 2s ease-in-out infinite, ldkGlow 2s ease-in-out infinite;
            border-radius: 12px;
        }

        .ldk-orbit-ring {
            position: absolute;
            width: 95px;
            height: 95px;
            border: 3px solid transparent;
            border-top-color: var(--primary);
            border-right-color: var(--primary);
            border-radius: 50%;
            animation: ldkOrbit 1.2s cubic-bezier(0.4, 0, 0.2, 1) infinite;
            opacity: 0.6;
        }

        @keyframes ldkPulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }

        @keyframes ldkGlow {
            0%, 100% {
                filter: drop-shadow(0 0 10px rgba(0, 167, 157, 0.4)) brightness(1.1);
            }
            50% {
                filter: drop-shadow(0 0 25px rgba(0, 167, 157, 0.8)) drop-shadow(0 0 50px rgba(0, 167, 157, 0.4)) brightness(1.3);
            }
        }

        @keyframes ldkOrbit {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        /* Dark mode spinner */
        html.dark-mode #spinner {
            background: #1a1d21 !important;
        }

        html.dark-mode .ldk-logo-spinner {
            animation: ldkPulse 2s ease-in-out infinite, ldkGlowDark 2s ease-in-out infinite;
        }

        @keyframes ldkGlowDark {
            0%, 100% {
                filter: drop-shadow(0 0 15px rgba(0, 167, 157, 0.6)) brightness(1.2);
            }
            50% {
                filter: drop-shadow(0 0 35px rgba(0, 167, 157, 1)) drop-shadow(0 0 70px rgba(0, 167, 157, 0.5)) brightness(1.5);
            }
        }

        html.dark-mode .ldk-orbit-ring {
            opacity: 0.8;
            border-top-color: rgba(0, 167, 157, 0.9);
            border-right-color: rgba(0, 167, 157, 0.9);
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
            background-color: #1a1d21;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Cpath d='M20 10l-3 5h6l-3-5zm0 2.5l1.5 2.5h-3l1.5-2.5z' fill='%23ffffff' fill-opacity='0.12'/%3E%3Ccircle cx='60' cy='15' r='4' fill='none' stroke='%23ffffff' stroke-opacity='0.12' stroke-width='0.8'/%3E%3Ccircle cx='60' cy='15' r='1.5' fill='%23ffffff' fill-opacity='0.12'/%3E%3Crect x='8' y='50' width='8' height='10' rx='1' fill='none' stroke='%23ffffff' stroke-opacity='0.12' stroke-width='0.8'/%3E%3Cline x1='10' y1='53' x2='14' y2='53' stroke='%23ffffff' stroke-opacity='0.12' stroke-width='0.6'/%3E%3Cline x1='10' y1='55' x2='14' y2='55' stroke='%23ffffff' stroke-opacity='0.12' stroke-width='0.6'/%3E%3Cline x1='10' y1='57' x2='13' y2='57' stroke='%23ffffff' stroke-opacity='0.12' stroke-width='0.6'/%3E%3Cpath d='M55 48l5 3-5 3z' fill='none' stroke='%23ffffff' stroke-opacity='0.12' stroke-width='0.8'/%3E%3Ccircle cx='40' cy='35' r='5' fill='none' stroke='%23ffffff' stroke-opacity='0.12' stroke-width='0.8'/%3E%3Cpath d='M38 35l1.5 1.5 3-3' fill='none' stroke='%23ffffff' stroke-opacity='0.12' stroke-width='0.8'/%3E%3Cpath d='M55 65a4 4 0 01-4 4h-1v2l-3-2h-2a4 4 0 01-4-4v-2a4 4 0 014-4h6a4 4 0 014 4z' fill='none' stroke='%23ffffff' stroke-opacity='0.12' stroke-width='0.8'/%3E%3C/svg%3E");
            background-size: 80px 80px;
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
        }

        html.dark-mode .content .navbar .dropdown-item {
            color: #e4e6eb;
        }

        html.dark-mode .content .navbar .dropdown-item:hover {
            background: #373b3e;
            color: var(--primary);
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
            <div class="spinner-ldk" role="status">
                <img src="https://lh3.googleusercontent.com/d/1a0T3LKmzN9mow39mWYwFPGqTpmSXjNk1" alt="Loading" class="ldk-logo-spinner" width="70" height="70">
                <!-- Orbiting ring -->
                <div class="ldk-orbit-ring"></div>
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

    {{-- Enhanced Dark Mode Toggle Script --}}
    <script>
    $(function() {
        const darkModeToggle = {
            init: function() {
                this.cacheDOM();
                this.bindEvents();
                this.loadSavedMode();
            },

            cacheDOM: function() {
                this.$switch = $('#darkModeSwitch');
                this.$toggle = $('.dark-mode-toggle');
                this.$html = $('html');
                this.$body = $('body');
            },

            bindEvents: function() {
                // Switch toggle event
                this.$switch.on('change', this.toggleMode.bind(this));

                // Keyboard accessibility
                this.$toggle.on('keydown', function(e) {
                    if (e.key === 'Enter' || e.key === ' ') {
                        e.preventDefault();
                        $(this).find('input').prop('checked',
                            !$(this).find('input').prop('checked')
                        ).trigger('change');
                    }
                });

                // Initialize tooltips
                this.$toggle.tooltip({
                    trigger: 'hover',
                    placement: 'bottom'
                });
            },

            loadSavedMode: function() {
                const isDark = localStorage.getItem('darkMode') === 'enabled';

                // Set initial state
                if (isDark) {
                    this.enableDarkMode();
                } else {
                    this.disableDarkMode();
                }

                // Update checkbox state
                this.$switch.prop('checked', isDark);

                // Add transition after initial load to prevent flash
                setTimeout(() => {
                    this.$body.addClass('dark-mode-transition-ready');
                }, 100);
            },

            toggleMode: function() {
                const isDark = this.$switch.prop('checked');

                if (isDark) {
                    this.enableDarkMode();
                } else {
                    this.disableDarkMode();
                }

                // Save preference
                localStorage.setItem('darkMode', isDark ? 'enabled' : 'disabled');

                // Emit custom event for other components
                $(document).trigger('darkModeChange', [isDark]);

                // Send analytics event
                this.sendAnalyticsEvent(isDark);
            },

            enableDarkMode: function() {
                // Smooth transition
                this.$html.addClass('dark-mode-transition');
                this.$body.addClass('dark-mode-transition');

                setTimeout(() => {
                    this.$html.addClass('dark-mode');
                    this.$body.addClass('dark-mode');
                }, 10);

                // Add animation class
                this.$toggle.find('.toggle-thumb').addClass('dark-mode-activated');
                setTimeout(() => {
                    this.$toggle.find('.toggle-thumb').removeClass('dark-mode-activated');
                }, 600);
            },

            disableDarkMode: function() {
                // Smooth transition
                this.$html.addClass('dark-mode-transition');
                this.$body.addClass('dark-mode-transition');

                setTimeout(() => {
                    this.$html.removeClass('dark-mode');
                    this.$body.removeClass('dark-mode');
                }, 10);

                // Add animation class
                this.$toggle.find('.toggle-thumb').addClass('light-mode-activated');
                setTimeout(() => {
                    this.$toggle.find('.toggle-thumb').removeClass('light-mode-activated');
                }, 600);

                // Remove transition classes after animation
                setTimeout(() => {
                    this.$html.removeClass('dark-mode-transition');
                    this.$body.removeClass('dark-mode-transition');
                }, 300);
            },

            showNotification: function(message) {
                // Create notification element
                const $notification = $(`
                    <div class="dark-mode-notification">
                        <div class="notification-content">
                            <i class="fas ${message.includes('Dark') ? 'fa-moon' : 'fa-sun'} me-2"></i>
                            ${message}
                        </div>
                    </div>
                `);

                // Append to body
                $('body').append($notification);

                // Show with animation
                setTimeout(() => {
                    $notification.addClass('show');
                }, 10);

                // Remove after 2 seconds
                setTimeout(() => {
                    $notification.removeClass('show');
                    setTimeout(() => $notification.remove(), 300);
                }, 2000);
            },

            sendAnalyticsEvent: function(isDark) {
                // You can integrate with Google Analytics or other analytics here
                if (typeof gtag !== 'undefined') {
                    gtag('event', 'dark_mode_toggle', {
                        'event_category': 'User Preference',
                        'event_label': isDark ? 'Dark Mode' : 'Light Mode'
                    });
                }

                // Log to console for debugging
                console.log(`Dark mode ${isDark ? 'enabled' : 'disabled'}`);
            }
        };

        // Initialize dark mode toggle
        darkModeToggle.init();

        // System preference detection
        if (window.matchMedia) {
            const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');

            // Listen for system preference changes
            prefersDarkScheme.addListener((e) => {
                if (localStorage.getItem('darkMode') === null) {
                    const isDark = e.matches;
                    $('#darkModeSwitch').prop('checked', isDark).trigger('change');
                }
            });

            // Auto-detect on first visit (if no preference saved)
            if (localStorage.getItem('darkMode') === null) {
                const isDark = prefersDarkScheme.matches;
                $('#darkModeSwitch').prop('checked', isDark).trigger('change');
            }
        }

        // Listen for dark mode changes to update other components
        $(document).on('darkModeChange', function(e, isDark) {
            // Update any component that needs to know about dark mode
            console.log('Dark mode changed:', isDark);

            // You can add additional component updates here
            // For example: update charts, maps, etc.
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
