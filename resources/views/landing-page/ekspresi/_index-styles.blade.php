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
    --color-primary: #CDED15; /* Warna Dasar Hijau Lime */
    --color-secondary: #1E6310; /* Warna Secondary Hijau Tua */
    --color-alpha-secondary: #1E6310;
    --color-beta-secondary: #00C000;
    --color-gamma-secondary: #FFE329;
    --color-lime: #CDED15;
    --color-dark-green: #1E6310;
    --color-bright-green: #00C000;
    --color-gold: #FFE329;
    --color-white: #ffffff;
  }

  /*--------------------------------------------------------------
  # General
  --------------------------------------------------------------*/
  body {
    background-color: var(--color-lime);
    color: var(--color-dark-green);
  }

  .faq {
      color: var(--color-dark-green);
      text-decoration: none;
  }

  p.answere {
      color: #334155;
      font-family: "Poppins", sans-serif;
      line-height: 1.6;
      font-size: 15px;
  }

  a:hover {
    color: var(--color-beta-secondary);
    text-decoration: none;
  }

  .faq:hover {
    color: var(--color-beta-secondary);
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
      background: var(--color-dark-green);
  }

  #preloader:before {
      content: "";
      position: fixed;
      top: calc(50% - 30px);
      left: calc(50% - 30px);
      border: 6px solid var(--color-lime);
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
  # Header / Navbar
  --------------------------------------------------------------*/
  #header {
    background: var(--color-dark-green) !important;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.15);
  }

  #header.header-scrolled,
  #header.header-inner-pages {
    background: rgba(30, 99, 16, 0.98) !important;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
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
    background: var(--color-dark-green);
    width: 40px;
    height: 40px;
    border-radius: 50px;
    transition: all 0.4s;
  }

  .back-to-top:hover {
    background: var(--color-gold);
    color: var(--color-dark-green);
  }

  /*--------------------------------------------------------------
  # Beranda / Hero Section
  --------------------------------------------------------------*/
  #beranda {
    width: 100%;
    min-height: 80vh;
    background: var(--color-lime);
    padding: 60px 0;
  }

  #beranda h1 {
    font-size: 2rem;
    color: var(--color-dark-green) !important;
  }

  #beranda h2 {
    font-size: 1.2rem;
    color: #164f0c !important;
  }

  #beranda .btn-get-started {
    font-family: "Poppins", sans-serif;
    font-weight: 700;
    font-size: 16px;
    letter-spacing: 1px;
    display: inline-block;
    padding: 11px 30px;
    border-radius: 50px;
    transition: 0.4s;
    margin: 10px 0 0 0;
    color: #ffffff !important;
    background: var(--color-dark-green);
    text-align: center;
    border: 2px solid var(--color-dark-green);
    box-shadow: 0 4px 14px rgba(30, 99, 16, 0.35);
  }

  #beranda .btn-get-started:hover {
    background: #14460a;
    border-color: #14460a;
    color: var(--color-gold) !important;
    box-shadow: 0 6px 18px rgba(30, 99, 16, 0.5);
    transform: translateY(-2px);
  }

  #beranda .btn-watch-video {
    font-family: "Poppins", sans-serif;
    font-weight: 600;
    font-size: 16px;
    letter-spacing: 1px;
    display: inline-flex;
    align-items: center;
    padding: 10px 28px 11px 28px;
    transition: 0.5s;
    margin: 10px 0 0 0;
    color: var(--color-dark-green);
    text-align: center;
  }

  #beranda .btn-watch-video i {
    color: var(--color-dark-green);
    font-size: 28px;
    transition: 0.3s;
  }

  #beranda .btn-watch-video:hover {
    color: #14460a;
  }

  #beranda .btn-watch-video:hover i {
    color: #14460a;
    transform: scale(1.1);
  }

  /* Responsive adjustments for hero section */
  @media (max-width: 991px) {
    #header {
      padding: 12px 0 !important;
    }

    #header .logo img {
      max-height: 34px !important;
    }

    #header .logo span {
      font-size: 1.1rem !important;
    }

    #beranda {
      height: auto !important;
      min-height: auto !important;
      padding-top: 115px !important;
      padding-bottom: 50px !important;
      display: block !important;
      text-align: center !important;
    }

    #beranda .hero-img {
      margin-top: 0 !important;
      margin-bottom: 25px !important;
    }

    #beranda .hero-img img {
      max-height: 220px !important;
      width: auto !important;
      margin: 0 auto;
    }

    #beranda h1 {
      font-size: 1.45rem !important;
      line-height: 1.35 !important;
      margin-bottom: 12px !important;
      text-align: center !important;
    }

    #beranda h2 {
      font-size: 0.95rem !important;
      line-height: 1.4 !important;
      margin-bottom: 22px !important;
      text-align: center !important;
    }

    #beranda .btn-get-started {
      width: 100%;
      max-width: 280px;
      margin: 0 auto 12px auto !important;
      display: inline-block;
    }

    #beranda .btn-watch-video {
      justify-content: center;
      margin: 0 auto !important;
    }
  }

  @media (max-width: 576px) {
    #header {
      padding: 10px 0 !important;
    }

    #header .logo img {
      max-height: 30px !important;
    }

    #header .logo span {
      font-size: 1rem !important;
    }

    #beranda {
      padding-top: 100px !important;
      padding-bottom: 35px !important;
    }

    #beranda .hero-img img {
      max-height: 180px !important;
    }

    #beranda h1 {
      font-size: 1.25rem !important;
      line-height: 1.35 !important;
    }

    #beranda h2 {
      font-size: 0.85rem !important;
      line-height: 1.4 !important;
    }
  }

  /*--------------------------------------------------------------
  # Sections General
  --------------------------------------------------------------*/
  .section-bg {
    background-color: var(--color-lime) !important;
  }

  .section-title h2 {
    color: var(--color-dark-green) !important;
  }

  .section-title h2::after {
    content: "";
    position: absolute;
    display: block;
    width: 40px;
    height: 3px;
    background: var(--color-dark-green) !important;
    bottom: 0;
    left: calc(50% - 20px);
  }

  .section-title p {
    color: #164f0c !important;
    font-weight: 500;
  }

  .why-us .content h3,
  .why-us .content h4 {
    color: var(--color-dark-green) !important;
    font-weight: 600;
  }

  .owl-theme .owl-dots .owl-dot.active span {
    background: var(--color-dark-green) !important;
  }

  .owl-theme .owl-dots .owl-dot span {
    background: rgba(30, 99, 16, 0.35) !important;
  }

  /*--------------------------------------------------------------
  # About Us / Syarat
  --------------------------------------------------------------*/
  .border-rules {
      background: #ffffff;
      border: 2.5px solid var(--color-dark-green);
      border-radius: 12px;
      color: var(--color-dark-green);
      box-shadow: 0 4px 12px rgba(30, 99, 16, 0.1);
  }

  .border-rules p {
      color: var(--color-dark-green) !important;
      margin-bottom: 0;
      font-weight: 500;
  }

  .skills .content h3 {
      color: var(--color-dark-green) !important;
  }

  /*--------------------------------------------------------------
  # Date Cards (Tanggal Penting)
  --------------------------------------------------------------*/
  .date-card {
      background: var(--color-dark-green);
      border: 2.5px solid #14460a;
      border-radius: 18px;
      padding: 28px 20px;
      box-shadow: 0 8px 24px rgba(30, 99, 16, 0.25);
      transition: all 0.35s ease;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: flex-start;
  }

  .date-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 30px rgba(30, 99, 16, 0.4);
      border-color: var(--color-gold);
  }

  .date-card-icon i {
      font-size: 42px;
      color: var(--color-gold);
      margin-bottom: 12px;
      display: inline-block;
  }

  .date-card h4 {
      font-size: 1.2rem;
      font-weight: 700;
      color: #ffffff;
      margin-bottom: 12px;
  }

  .date-card .date-badge {
      background: var(--color-gold);
      color: var(--color-dark-green);
      font-weight: 800;
      font-size: 0.95rem;
      padding: 7px 18px;
      border-radius: 50px;
      letter-spacing: 0.5px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.15);
      display: inline-block;
  }

  .date-card-desc {
      color: #e2f58b;
      font-size: 0.9rem;
      line-height: 1.5;
      margin-bottom: 0;
  }

  /*--------------------------------------------------------------
  # Step Process Cards (Tata Cara Pendaftaran)
  --------------------------------------------------------------*/
  .step-card {
      background: #ffffff;
      border: 2.5px solid var(--color-dark-green);
      border-radius: 18px;
      padding: 24px 16px 20px;
      box-shadow: 0 6px 18px rgba(30, 99, 16, 0.12);
      transition: all 0.35s ease;
      position: relative;
      display: flex;
      flex-direction: column;
      align-items: center;
  }

  .step-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 12px 28px rgba(30, 99, 16, 0.25);
      border-color: var(--color-bright-green);
  }

  .step-card .step-badge {
      width: 44px;
      height: 44px;
      border-radius: 50%;
      background: var(--color-dark-green);
      color: var(--color-gold);
      font-weight: 800;
      font-size: 1.05rem;
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 0 auto 10px;
      box-shadow: 0 4px 10px rgba(30, 99, 16, 0.25);
  }

  .step-card .step-icon i {
      font-size: 28px;
      color: var(--color-dark-green);
  }

  .step-card h4 {
      font-size: 1.05rem;
      font-weight: 700;
      color: var(--color-dark-green);
      margin-bottom: 8px;
  }

  .step-card p {
      font-size: 0.88rem;
      color: #334155;
      line-height: 1.5;
      margin-bottom: 0;
  }

  .step-card a {
      color: var(--color-dark-green) !important;
      font-weight: 700 !important;
      text-decoration: underline !important;
      transition: 0.2s;
  }

  .step-card a:hover {
      color: #00C000 !important;
  }

  /*--------------------------------------------------------------
  # Services / Hyperlink
  --------------------------------------------------------------*/
  .services .icon-box {
      padding: 24px 16px;
      transition: all ease-in-out 0.35s;
      background: var(--color-dark-green);
      border: 2.5px solid #14460a;
      border-radius: 16px;
      height: 100%;
      min-height: 180px;
      width: 100%;
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      box-shadow: 0 6px 18px rgba(30, 99, 16, 0.25);
  }

  .services .icon-box.highlight-card {
      background: #14460a;
      border: 2.5px solid var(--color-gold);
      box-shadow: 0 0 22px rgba(30, 99, 16, 0.35);
  }

  .services .icon-box.dashed-card {
      background: rgba(30, 99, 16, 0.92);
      border-style: dashed;
      border-color: rgba(205, 237, 21, 0.6);
  }

  .services .icon-box:hover {
      background: #164f0c;
      border-color: var(--color-gold);
      box-shadow: 0 10px 26px rgba(30, 99, 16, 0.45);
      transform: translateY(-5px);
  }

  .services .icon-box h4 {
      font-size: 1.05rem;
      font-weight: 700;
      color: #ffffff;
      margin-top: 12px;
      margin-bottom: 2px;
      transition: 0.3s;
  }

  .services .icon-box:hover h4 {
      color: var(--color-gold);
  }

  .services .icon-box .badge-card-sub {
      font-size: 12px;
      color: #dcf53b;
      display: block;
      transition: 0.3s;
  }

  .services .icon-box .icon i {
      font-size: 38px;
      color: var(--color-lime);
      transition: 0.3s;
  }

  .services .icon-box:hover .icon i {
      color: var(--color-gold);
      transform: scale(1.1);
  }

  .hyperlink-item {
      text-decoration: none;
      display: block;
      height: 100%;
  }

  .hyperlink-item.disabled-link {
      cursor: not-allowed;
      opacity: 0.88;
  }

  .badge-status-menyusul {
      position: absolute;
      top: 10px;
      right: 12px;
      background: var(--color-gold);
      color: var(--color-dark-green);
      font-size: 10px;
      font-weight: 800;
      letter-spacing: 0.5px;
      padding: 3px 8px;
      border-radius: 12px;
      text-transform: uppercase;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.2);
  }

  /* Contact Strip Bar */
  .contact-strip {
      background: var(--color-dark-green);
      border: 2px solid #14460a;
      border-radius: 20px;
      box-shadow: 0 8px 24px rgba(30, 99, 16, 0.25);
  }

  .btn-contact-wa {
      background: #25D366;
      color: #ffffff !important;
      font-weight: 600;
      font-size: 14px;
      padding: 10px 24px;
      border-radius: 50px;
      border: none;
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      transition: all 0.3s ease;
      box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
  }

  .btn-contact-wa:hover {
      background: #1ebc59;
      color: #ffffff !important;
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(37, 211, 102, 0.45);
  }

  /*--------------------------------------------------------------
  # FAQ Section
  --------------------------------------------------------------*/
  .faq .faq-list li {
      padding: 20px;
      background: #ffffff;
      border-radius: 14px;
      position: relative;
      margin-bottom: 16px;
      border: 2px solid var(--color-lime);
      box-shadow: 0 4px 12px rgba(30, 99, 16, 0.1);
  }

  .faq .faq-list a {
      display: block;
      position: relative;
      font-family: "Poppins", sans-serif;
      font-size: 16px;
      line-height: 24px;
      font-weight: 700;
      padding: 0 30px;
      outline: none;
      cursor: pointer;
      color: var(--color-dark-green);
  }

  .faq .faq-list a:hover {
      color: var(--color-beta-secondary);
  }

  .faq .faq-list a.collapsed {
      color: var(--color-dark-green);
      font-weight: 600;
      transition: 0.3s;
  }

  .faq .faq-list a.collapsed:hover {
      color: var(--color-beta-secondary);
  }

  .faq .faq-list .icon-help {
      font-size: 24px;
      position: absolute;
      right: 0;
      left: 20px;
      color: var(--color-dark-green);
  }

  .faq .faq-list .icon-show,
  .faq .faq-list .icon-close {
      font-size: 24px;
      position: absolute;
      right: 0;
      top: 0;
      color: var(--color-dark-green);
  }

  /*--------------------------------------------------------------
  # Footer
  --------------------------------------------------------------*/
  #footer {
    font-size: 14px;
    background: #14460a;
  }

  #footer .footer-top {
    padding: 60px 0 30px 0;
    background: var(--color-dark-green);
  }
  
  #footer .footer-top .social-links a {
    font-size: 18px;
    display: inline-block;
    background: #14460a;
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
    background: var(--color-gold);
    color: #1E6310;
    text-decoration: none;
  }

  /*--------------------------------------------------------------
  # Navigation Menu
  --------------------------------------------------------------*/
  .navbar a:hover,
  .navbar .active,
  .navbar .active:focus,
  .navbar li:hover>a {
    color: var(--color-lime);
  }

  .navbar .getstarted,
  .navbar .getstarted:focus {
    padding: 8px 22px;
    margin-left: 30px;
    border-radius: 50px;
    color: var(--color-dark-green);
    background: var(--color-lime);
    font-size: 14px;
    border: 2px solid var(--color-lime);
    font-weight: 700;
    transition: 0.4s;
  }

  .navbar .getstarted:hover,
  .navbar .getstarted:focus:hover {
    color: var(--color-dark-green);
    background: var(--color-gold);
    border-color: var(--color-gold);
    box-shadow: 0 4px 12px rgba(205, 237, 21, 0.35);
  }

  /**
  * Mobile Navigation
  */
  .mobile-nav-toggle {
    color: #fff;
    font-size: 28px;
    cursor: pointer;
    display: none;
    line-height: 0;
    transition: 0.5s;
  }

  @media (max-width: 991px) {
    .mobile-nav-toggle {
      display: block;
    }

    .navbar ul {
      display: none;
    }
  }

  .navbar-mobile {
    position: fixed;
    overflow: hidden;
    top: 0;
    right: 0;
    left: 0;
    bottom: 0;
    background: rgba(15, 60, 10, 0.95);
    transition: 0.3s;
    z-index: 999;
  }

  .navbar-mobile .mobile-nav-toggle {
    position: absolute;
    top: 15px;
    right: 15px;
    color: #ffffff;
  }

  .navbar-mobile ul {
    display: block;
    position: absolute;
    top: 55px;
    right: 15px;
    bottom: 15px;
    left: 15px;
    padding: 12px 0;
    border-radius: 14px;
    background-color: #ffffff;
    border: 2px solid var(--color-lime);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
    overflow-y: auto;
    transition: 0.3s;
  }

  .navbar-mobile a,
  .navbar-mobile a:focus {
    padding: 12px 22px;
    font-size: 15px;
    font-weight: 600;
    color: var(--color-dark-green) !important;
  }

  .navbar-mobile a:hover,
  .navbar-mobile .active,
  .navbar-mobile li:hover>a {
    color: #00C000 !important;
    background: rgba(205, 237, 21, 0.25);
  }

  .navbar-mobile .getstarted,
  .navbar-mobile .getstarted:focus {
    margin: 15px 20px;
    color: #ffffff !important;
    background: var(--color-dark-green) !important;
    border-radius: 50px;
    text-align: center;
    font-weight: 700;
    padding: 11px 20px;
  }

  /* Mobile general overflow & spacing protection */
  html, body {
    overflow-x: hidden !important;
    max-width: 100vw;
  }

  @media (max-width: 768px) {
    section {
      padding: 45px 0 !important;
    }

    .section-title {
      padding-bottom: 25px !important;
    }

    .section-title h2 {
      font-size: 24px !important;
      line-height: 1.3 !important;
    }

    .why-us .img {
      min-height: 220px !important;
    }

    .why-us .content {
      padding: 20px 12px !important;
    }

    .date-card {
      padding: 22px 16px !important;
    }

    .date-card h4 {
      font-size: 1.1rem !important;
    }

    .date-card .date-badge {
      font-size: 0.85rem !important;
      padding: 6px 14px !important;
    }

    .step-card {
      padding: 20px 14px !important;
    }

    .contact-strip {
      padding: 22px 16px !important;
      text-align: center;
    }

    .contact-strip .btn-contact-wa {
      width: 100% !important;
      margin-bottom: 10px;
      justify-content: center;
    }

    .faq .faq-list {
      padding: 0 !important;
    }

    .faq .faq-list a {
      padding: 16px 20px 16px 40px !important;
      font-size: 15px !important;
    }

    .faq .faq-list .icon-help {
      left: 15px !important;
    }
  }

  /* ── Dark Mode ── */
  [data-theme="dark"] .section-title h2 { color: #e2e8f0; }
  [data-theme="dark"] .faq .faq-list li {
    background: #1e293b;
    border-color: var(--color-lime);
  }
  [data-theme="dark"] .faq .faq-list a,
  [data-theme="dark"] .faq .faq-list a.collapsed,
  [data-theme="dark"] .faq .faq-list .icon-help,
  [data-theme="dark"] .faq .faq-list .icon-show,
  [data-theme="dark"] .faq .faq-list .icon-close {
    color: var(--color-lime);
  }
  [data-theme="dark"] p.answere {
    color: #cbd5e1;
  }
</style>