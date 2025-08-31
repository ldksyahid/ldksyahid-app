<script src="{{ asset('arsha/vendor/aos/aos.js') }}"></script>
<script src="{{ asset('arsha/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('arsha/vendor/glightbox/js/glightbox.min.js') }}"></script>
<script src="{{ asset('arsha/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
<script src="{{ asset('arsha/vendor/swiper/swiper-bundle.min.js') }}"></script>
<script src="{{ asset('arsha/vendor/waypoints/noframework.waypoints.js') }}"></script>
<script src="{{ asset('arsha/vendor/php-email-form/validate.js') }}"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="{{ asset('landing-page-ext-rsrc/lib/owlcarousel/owl.carousel.min.js') }}"></script>
<script src="{{ asset('arsha/js/main.js') }}"></script>
<script>
    $(document).ready(function() {
        $(".owl-ekspresi-aboutus").owlCarousel({
            dots: true,
            items: 1,
            loop: true,
            nav: false,
            autoplay: true,
            autoplayTimeout: 5000,
            autoplayHoverPause: true
        });

        function handleResponsive() {
            if ($(window).width() < 768) {

            }
        }

        handleResponsive();
        $(window).resize(handleResponsive);
    });
</script>