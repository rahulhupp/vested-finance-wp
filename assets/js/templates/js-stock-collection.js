jQuery(document).ready(function ($) {
    if ($(window).width() <= 767) {
        $(".post_listing .posts_wrap").slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            infinite: true,
            autoplay: true,
            autoplaySpeed: 2000,
            dots: false,
            arrows: false,
        });
    }
    });