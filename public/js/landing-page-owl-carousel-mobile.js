$(function() {
    $(".owl-kmb").owlCarousel({
        autoplay:true,
        autoplayTimeout:2500,
        autoplayHoverPause:true,
        dots:false,
        items: 1,
        margin: 0,
        loop: true,
        nav: false,

    });
    $(".owl-article").owlCarousel({
        stagePadding: 50,
        loop:false,
        margin:10,
        nav:false,
        responsive:{
            0:{
                items:1
            },
            600:{
                items:3
            },
            1000:{
                items:5
            }
        }
    });
    $(".owl-event").owlCarousel({
        dots:true,
        items: 1,
        margin: 30,
        loop: false,
        nav: false,

    });

    $(".owl-testimony").owlCarousel({
        autoplay:true,
        autoplayTimeout:5000,
        autoplayHoverPause:true,
        dots:true,
        items: 1,
        margin: 30,
        loop: true,
        nav: false,

    });

    $(".owl-ekspresi-aboutus").owlCarousel({
        dots:true,
        items: 1,
        loop: true,
        nav: false,
    });
});
