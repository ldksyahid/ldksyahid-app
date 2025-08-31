<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Jost:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
<link href="{{ asset('arsha/vendor/aos/aos.css') }}" rel="stylesheet">
<link href="{{ asset('arsha/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
<link href="{{ asset('arsha/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
<link href="{{ asset('arsha/vendor/boxicons/css/boxicons.min.css') }}" rel="stylesheet">
<link href="{{ asset('arsha/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
<link href="{{ asset('arsha/vendor/remixicon/remixicon.css') }}" rel="stylesheet">
<link href="{{ asset('arsha/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
<link href="{{ asset('arsha/css/style.css') }}" rel="stylesheet">
  <style>
    :root {
      --color-primary: #1667b0;
      --color-secondary: #a20007;
      --color-alpha-secondary: #e4141a;
      --color-beta-secondary: #e4141a;
      --color-gamma-secondary: #e4141a;
    }

    /*--------------------------------------------------------------
    # General
    --------------------------------------------------------------*/
    .faq {
        color: var(--color-secondary);
        text-decoration: none;
    }

    p.answere {
        color: var(--color-gamma-secondary);
        font-family: "Poppins", sans-serif;
    }

    a:hover {
      color: var(--color-alpha-secondary);
      text-decoration: none;
    }

    .faq:hover {
      color: var(--color-secondary);
      text-decoration: none;
    }

    /*--------------------------------------------------------------
    # Preloader
    --------------------------------------------------------------*/
    #preloader {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        z-index: 9999;
        overflow: hidden;
        background: var(--color-primary);
    }

    #preloader:before {
        content: "";
        position: fixed;
        top: calc(50% - 30px);
        left: calc(50% - 30px);
        border: 6px solid var(--color-alpha-secondary);
        border-top-color: #fff;
        border-bottom-color: #fff;
        border-radius: 50%;
        width: 60px;
        height: 60px;
        animation: animate-preloader 1s linear infinite;
    }

    @keyframes animate-preloader {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }

    /*--------------------------------------------------------------
    # Header
    --------------------------------------------------------------*/
    #header.header-scrolled,
    #header.header-inner-pages {
      background: var(--color-secondary);
    }

    /*--------------------------------------------------------------
    # Back to top button
    --------------------------------------------------------------*/
    .back-to-top {
      position: fixed;
      visibility: hidden;
      opacity: 0;
      right: 15px;
      bottom: 15px;
      z-index: 996;
      background: var(--color-beta-secondary);
      width: 40px;
      height: 40px;
      border-radius: 50px;
      transition: all 0.4s;
    }

    .back-to-top:hover {
      background: var(--color-alpha-secondary);
      color: #fff;
    }

    /*--------------------------------------------------------------
    # beranda Section
    --------------------------------------------------------------*/
    #beranda {
      width: 100%;
      height: 80vh;
      background: var(--color-primary);
    }

    #beranda .btn-get-started {
      font-family: "Poppins", sans-serif;
      font-weight: 500;
      font-size: 16px;
      letter-spacing: 1px;
      display: inline-block;
      padding: 10px 28px 11px 28px;
      border-radius: 50px;
      transition: 0.5s;
      margin: 10px 0 0 0;
      color: #fff;
      background: var(--color-alpha-secondary);
    }

    #beranda .btn-get-started:hover {
      background: var(--color-secondary);
    }

    /*--------------------------------------------------------------
    # Sections General
    --------------------------------------------------------------*/
    .section-bg {
      background-color: var(--color-primary);
    }

    .section-title h2::after {
      content: "";
      position: absolute;
      display: block;
      width: 40px;
      height: 3px;
      background: var(--color-alpha-secondary);
      bottom: 0;
      left: calc(50% - 20px);
    }

    /*--------------------------------------------------------------
    # About Us
    --------------------------------------------------------------*/
    .about .content .btn-learn-more {
      font-family: "Poppins", sans-serif;
      font-weight: 500;
      font-size: 14px;
      letter-spacing: 1px;
      display: inline-block;
      padding: 12px 32px;
      border-radius: 4px;
      transition: 0.3s;
      line-height: 1;
      color: var(--color-alpha-secondary);
      animation-delay: 0.8s;
      margin-top: 6px;
      border: 2px solid var(--color-alpha-secondary);
    }

    .about .content .btn-learn-more:hover {
      background: var(--color-alpha-secondary);
      color: #fff;
      text-decoration: none;
    }

    /*--------------------------------------------------------------
    # Frequently Asked Questions
    --------------------------------------------------------------*/
    .faq .faq-list .icon-help {
      font-size: 24px;
      position: absolute;
      right: 0;
      left: 20px;
      color: var(--color-gamma-secondary);
    }

    .faq .faq-list a.collapsed {
      color: var(--color-gamma-secondary);
      transition: 0.3s;
    }

    .faq .faq-list a.collapsed:hover {
      color: var(--color-secondary);
    }

    /*--------------------------------------------------------------
    # Contact
    --------------------------------------------------------------*/
    .contact .info .social-links a:hover {
      background: var(--color-alpha-secondary);
      color: #fff;
    }

    /*--------------------------------------------------------------
    # Services
    --------------------------------------------------------------*/
    .services .icon-box {
        padding: 50px 30px;
        transition: all ease-in-out 0.4s;
        background: rgba(0, 0, 0, 0.0);
        border: 4px solid var(--color-alpha-secondary);
        border-radius: 12px;
        height: 200px;
        width: 300px;
    }

    .services .icon-box:hover h4 a{
      color: var(--color-alpha-secondary);
    }

    .services .icon-box:hover .icon i{
        color: var(--color-alpha-secondary);
    }

    /*--------------------------------------------------------------
    # Footer
    --------------------------------------------------------------*/
    #footer {
      font-size: 14px;
      background: var(--color-secondary);
    }

    #footer .footer-top {
      padding: 60px 0 30px 0;
      background: var(--color-primary);
    }
    
    #footer .footer-top .social-links a {
      font-size: 18px;
      display: inline-block;
      background: var(--color-primary);
      color: #fff;
      line-height: 1;
      padding: 8px 0;
      margin-right: 4px;
      border-radius: 50%;
      text-align: center;
      width: 36px;
      height: 36px;
      transition: 0.3s;
    }

    #footer .footer-top .social-links a:hover {
      background: var(--color-alpha-secondary);
      color: #fff;
      text-decoration: none;
    }

    .border-rules {
        border: 2px solid;
        border-color: var(--color-alpha-secondary);
        border-width: 2.5px;
        border-radius: 5px;
    }

    /*--------------------------------------------------------------
    # Navigation Menu
    --------------------------------------------------------------*/
    .navbar a:hover,
    .navbar .active,
    .navbar .active:focus,
    .navbar li:hover>a {
      color: var(--color-alpha-secondary);
    }

    .navbar .getstarted,
    .navbar .getstarted:focus {
      padding: 8px 20px;
      margin-left: 30px;
      border-radius: 50px;
      color: #fff;
      font-size: 14px;
      border: 2px solid var(--color-alpha-secondary);
      font-weight: 600;
    }

    .navbar .getstarted:hover,
    .navbar .getstarted:focus:hover {
      color: #fff;
      background: var(--color-alpha-secondary);
    }

    /*--------------------------------------------------------------
    # Video Player Styles
    --------------------------------------------------------------*/
    .plyr__control.plyr__tab-focus {
      outline: 3px dotted var(--color-alpha-secondary);
      outline-offset: 2px;
    }

    .plyr__menu__container .plyr__control[role='menuitemradio'][aria-checked='true']:before {
      background: var(--color-alpha-secondary);
    }

    .plyr--full-ui input[type='range'] {
      -webkit-appearance: none;
      -moz-appearance: none;
      appearance: none;
      background: 0 0;
      border: 0;
      border-radius: 26px;
      color: var(--color-alpha-secondary);
      display: block;
      height: 19px;
      margin: 0;
      min-width: 0;
      padding: 0;
      transition: box-shadow 0.3s ease;
      width: 100%;
    }

    .plyr--full-ui input[type='range'].plyr__tab-focus::-webkit-slider-runnable-track {
      outline: 3px dotted var(--color-alpha-secondary);
      outline-offset: 2px;
    }

    .plyr--full-ui input[type='range'].plyr__tab-focus::-moz-range-track {
      outline: 3px dotted var(--color-alpha-secondary);
      outline-offset: 2px;
    }

    .plyr--full-ui input[type='range'].plyr__tab-focus::-ms-track {
      outline: 3px dotted var(--color-alpha-secondary);
      outline-offset: 2px;
    }

    .plyr--audio .plyr__control.plyr__tab-focus,
    .plyr--audio .plyr__control:hover,
    .plyr--audio .plyr__control[aria-expanded='true'] {
      background: var(--color-alpha-secondary);
      color: #fff;
    }

    .plyr--video .plyr__control.plyr__tab-focus,
    .plyr--video .plyr__control:hover,
    .plyr--video .plyr__control[aria-expanded='true'] {
      background: var(--color-alpha-secondary);
      color: #fff;
    }

    .plyr__control--overlaid {
      background: var(--color-alpha-secondary);
      border: 0;
      border-radius: 100%;
      color: #fff;
      display: none;
      left: 50%;
      opacity: 0.9;
      padding: 15px;
      position: absolute;
      top: 50%;
      transform: translate(-50%, -50%);
      transition: 0.3s;
      z-index: 2;
    }
  </style>