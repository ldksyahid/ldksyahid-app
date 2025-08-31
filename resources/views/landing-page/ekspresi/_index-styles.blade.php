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
/*--------------------------------------------------------------
# General
--------------------------------------------------------------*/
.faq {
    color: #366566;
    text-decoration: none;
}

p.answere {
    color: #5aa7a8;
    font-family: "Poppins", sans-serif;
}

a:hover {
  color: #CFAF76;
  text-decoration: none;
}

.faq:hover {
  color: #366566;
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
    background: #791E3D;
}

#preloader:before {
    content: "";
    position: fixed;
    top: calc(50% - 30px);
    left: calc(50% - 30px);
    border: 6px solid #CFAF76;
    border-top-color: #fff;
    border-bottom-color: #fff;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: animate-preloader 1s linear infinite;
}

/*--------------------------------------------------------------
# Header
--------------------------------------------------------------*/
#header.header-scrolled,
#header.header-inner-pages {
  background: #366566;
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
  background: #F8DFA3;
  width: 40px;
  height: 40px;
  border-radius: 50px;
  transition: all 0.4s;
}

.back-to-top:hover {
  background: #CFAF76;
  color: #fff;
}

/*--------------------------------------------------------------
# beranda Section
--------------------------------------------------------------*/
#beranda {
  width: 100%;
  height: 80vh;
  background: #791E3D;
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
  background: #CFAF76;
}

#beranda .btn-get-started:hover {
  background: #366566;
}

#beranda .btn-watch-video:hover i {
  color: #CFAF76;
}

/*--------------------------------------------------------------
# Sections General
--------------------------------------------------------------*/
.section-bg {
  background-color: #791E3D;
}

.section-title h2::after {
  content: "";
  position: absolute;
  display: block;
  width: 40px;
  height: 3px;
  background: #CFAF76;
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
  color: #CFAF76;
  animation-delay: 0.8s;
  margin-top: 6px;
  border: 2px solid #CFAF76;
}

.about .content .btn-learn-more:hover {
  background: #CFAF76;
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
  color: #5aa7a8;
}

.faq .faq-list a.collapsed {
  color: #5aa7a8;
  transition: 0.3s;
}

.faq .faq-list a.collapsed:hover {
  color: #366566;
}

/*--------------------------------------------------------------
# Contact
--------------------------------------------------------------*/
.contact .info .social-links a:hover {
  background: #CFAF76;
  color: #fff;
}


/*--------------------------------------------------------------
# Services
--------------------------------------------------------------*/
.services .icon-box {
    padding: 50px 30px;
    transition: all ease-in-out 0.4s;
    background: rgba(0, 0, 0, 0.0);
    border: 4px solid #CFAF76;
    border-radius: 12px;
    height: 200px;
    width: 300px;
}

.services .icon-box:hover h4 a{
  color: #CFAF76;
}

.services .icon-box:hover .icon i{
    color: #CFAF76;
}

/*--------------------------------------------------------------
# Footer
--------------------------------------------------------------*/
#footer {
  font-size: 14px;
  background: #366566;
}

#footer .footer-top {
  padding: 60px 0 30px 0;
  background: #791E3D;
}
#footer .footer-top .social-links a {
  font-size: 18px;
  display: inline-block;
  background: #791E3D;
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
  background: #CFAF76;
  color: #fff;
  text-decoration: none;
}

.border-rules {
    border: 2px solid;
    border-color : #CFAF76;
    border-width: 2.5px;
    border-radius: 5px;
}

/*--------------------------------------------------------------
# Navigation Menu
--------------------------------------------------------------*/
/**
* Desktop Navigation
*/
.navbar a:hover,
.navbar .active,
.navbar .active:focus,
.navbar li:hover>a {
  color: #CFAF76;
}

.navbar .getstarted,
.navbar .getstarted:focus {
  padding: 8px 20px;
  margin-left: 30px;
  border-radius: 50px;
  color: #fff;
  font-size: 14px;
  border: 2px solid #CFAF76;
  font-weight: 600;
}

.navbar .getstarted:hover,
.navbar .getstarted:focus:hover {
  color: #fff;
  background: #CFAF76;
}
</style>