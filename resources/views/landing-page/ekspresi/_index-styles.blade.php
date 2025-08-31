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
    min-height: 80vh;
    background: var(--color-primary);
    padding: 60px 0;
  }

  #beranda h1 {
    font-size: 2rem;
  }

  #beranda h2 {
    font-size: 1.2rem;
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
    text-align: center;
  }

  #beranda .btn-get-started:hover {
    background: var(--color-secondary);
  }

  #beranda .btn-watch-video {
    font-family: "Poppins", sans-serif;
    font-weight: 500;
    font-size: 16px;
    letter-spacing: 1px;
    display: inline-flex;
    align-items: center;
    padding: 10px 28px 11px 28px;
    transition: 0.5s;
    margin: 10px 0 0 0;
    color: #fff;
    text-align: center;
  }

  /* Responsive adjustments for hero section */
  @media (max-width: 768px) {
    #beranda {
      height: auto;
      padding: 80px 0 40px;
    }
    
    #beranda h1 {
      font-size: 1.5rem;
      text-align: center;
    }
    
    #beranda h2 {
      font-size: 1rem;
      text-align: center;
    }
    
    #beranda .hero-img {
      margin-top: 30px;
    }
    
    #beranda .hero-img img {
      width: 80% !important;
    }
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
      padding: 30px 20px;
      transition: all ease-in-out 0.4s;
      background: rgba(0, 0, 0, 0.0);
      border: 4px solid var(--color-alpha-secondary);
      border-radius: 12px;
      height: auto;
      min-height: 200px;
      width: 100%;
      max-width: 300px;
      margin: 10px auto;
  }

  .services .icon-box:hover h4 a{
    color: var(--color-alpha-secondary);
  }

  .services .icon-box:hover .icon i{
      color: var(--color-alpha-secondary);
  }

  @media (max-width: 768px) {
    .services .icon-box {
      padding: 20px 15px;
      min-height: 180px;
    }
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

  @media (max-width: 991px) {
    .navbar .getstarted {
      margin: 10px 0 0 0;
    }
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

  /* Additional responsive styles */
  @media (max-width: 576px) {
    .container {
      padding-left: 15px;
      padding-right: 15px;
    }
    
    .section-title h2 {
      font-size: 1.5rem;
    }
    
    .clients img {
      max-width: 50px !important;
    }
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

  .mobile-nav-toggle.bi-x {
    color: #fff;
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
    background: color-mix(in srgb, var(--color-primary) 90%, transparent);
    transition: 0.3s;
    z-index: 999;
  }

  .navbar-mobile .mobile-nav-toggle {
    position: absolute;
    top: 15px;
    right: 15px;
  }

  .navbar-mobile ul {
    display: block;
    position: absolute;
    top: 55px;
    right: 15px;
    bottom: 15px;
    left: 15px;
    padding: 10px 0;
    border-radius: 10px;
    background-color: #fff;
    overflow-y: auto;
    transition: 0.3s;
  }

  .navbar-mobile a,
  .navbar-mobile a:focus {
    padding: 10px 20px;
    font-size: 15px;
    color: #000;
  }

  .navbar-mobile a:hover,
  .navbar-mobile .active,
  .navbar-mobile li:hover>a {
    color: #000;
  }

  .navbar-mobile .getstarted,
  .navbar-mobile .getstarted:focus {
    margin: 15px;
    color: #000;
  }

  .navbar-mobile .dropdown ul {
    position: static;
    display: none;
    margin: 10px 20px;
    padding: 10px 0;
    z-index: 99;
    opacity: 1;
    visibility: visible;
    background: #fff;
    box-shadow: 0px 0px 30px rgba(127, 137, 161, 0.25);
  }

  .navbar-mobile .dropdown ul li {
    min-width: 200px;
  }

  .navbar-mobile .dropdown ul a {
    padding: 10px 20px;
  }

  .navbar-mobile .dropdown ul a i {
    font-size: 12px;
  }

  .navbar-mobile .dropdown ul a:hover,
  .navbar-mobile .dropdown ul .active:hover,
  .navbar-mobile .dropdown ul li:hover>a {
    color: #47b2e4;
  }

  .navbar-mobile .dropdown>.dropdown-active {
    display: block;
    visibility: visible !important;
  }
</style>
<style>
  @import url("https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap");

  .timeline>ul {
      --col-gap: 2rem;
      --row-gap: 2rem;
      --line-w: 0.25rem;
      display: grid;
      grid-template-columns: var(--line-w) 1fr;
      grid-auto-columns: max-content;
      column-gap: var(--col-gap);
      list-style: none;
      width: min(60rem, 90%);
      margin-inline: auto;
  }

  /* line */
  .timeline>ul::before {
      content: "";
      grid-column: 1;
      grid-row: 1 / span 20;
      background: rgb(255, 255, 255, 255);
      border-radius: calc(var(--line-w) / 2);
  }

  /* columns*/

  /* row gaps */
  .timeline>ul li:not(:last-child) {
      margin-bottom: var(--row-gap);
  }

  /* card */
  .timeline>ul li {
      grid-column: 2;
      --inlineP: 1.5rem;
      margin-inline: var(--inlineP);
      grid-row: span 2;
      display: grid;
      grid-template-rows: min-content min-content min-content;
  }

  /* date */
  .timeline>ul li .date {
      --dateH: 3rem;
      height: var(--dateH);
      margin-inline: calc(var(--inlineP) * -1);

      text-align: center;
      background-color: var(--accent-color);

      color: white;
      font-size: 1.25rem;
      font-weight: 700;

      display: grid;
      place-content: center;
      position: relative;

      border-radius: 15px;
  }

  /* circle */
  .timeline>ul li .date::after {
      content: "";
      position: absolute;
      width: 2rem;
      aspect-ratio: 1;
      background: var(--bgColor);
      border: 0.3rem solid var(--accent-color);
      border-radius: 50%;
      top: 50%;

      transform: translate(50%, -50%);
      right: calc(100% + var(--col-gap) + var(--line-w) / 2);
  }

  /* title descr */
  .timeline>ul li .title,
  .timeline>ul li .descr {
      background: var(--bgColor);
      position: relative;
      padding-inline: 1.5rem;
  }

  .timeline>ul li .title {
      overflow: hidden;
      padding-block-start: 1.5rem;
      padding-block-end: 1rem;
      font-weight: 500;
  }

  .timeline>ul li .descr {
      padding-block-end: 1.5rem;
      font-weight: 300;
  }

  /* shadows */
  .timeline>ul li .title::before,
  .timeline>ul li .descr::before {
      content: "";
      position: absolute;
      width: 90%;
      height: 0.5rem;
      background: rgba(0, 0, 0, 0.5);
      left: 50%;
      border-radius: 50%;
      filter: blur(4px);
      transform: translate(-50%, 50%);
  }

  .timeline>ul li .title::before {
      bottom: calc(100% + 0.125rem);
  }

  .timeline>ul li .descr::before {
      z-index: -1;
      bottom: 0.25rem;
  }

  @media (min-width: 40rem) {
      .timeline>ul {
          grid-template-columns: 1fr var(--line-w) 1fr;
      }

      .timeline>ul::before {
          grid-column: 2;
      }

      .timeline>ul li:nth-child(odd) {
          grid-column: 1;
      }

      .timeline>ul li:nth-child(even) {
          grid-column: 3;
      }

      /* start second card */
      .timeline>ul li:nth-child(2) {
          grid-row: 2/4;
      }

      .timeline>ul li:nth-child(odd) .date::before {
          clip-path: polygon(0 0, 100% 0, 100% 100%);
          left: 0;
      }

      .timeline>ul li:nth-child(odd) .date::after {
          transform: translate(-50%, -50%);
          left: calc(100% + var(--col-gap) + var(--line-w) / 2);
      }

      .timeline>ul li:nth-child(odd) .date {
          border-radius: 15px;
      }
  }

  /* Responsive adjustments for timeline */
  @media (max-width: 768px) {
    .timeline>ul {
      grid-template-columns: 1fr;
      padding-left: 0;
    }
    
    .timeline>ul::before {
      display: none;
    }
    
    .timeline>ul li {
      grid-column: 1;
      margin-inline: 0;
    }
    
    .timeline>ul li .date::after {
      display: none;
    }
    
    .skills .content h3 {
      text-align: left !important;
      margin-top: 30px;
    }
  }
</style>