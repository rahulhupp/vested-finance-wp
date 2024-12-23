jQuery(document).ready(function () {
  jQuery(".logo-slider").slick({
    slidesToShow: 7,
    slidesToScroll: 1,
    autoplay: true,
    autoplaySpeed: 2000,
    arrows: true,
    dots: false,
    responsive: [
      {
        breakpoint: 1024,
        settings: {
          slidesToShow: 5,
        },
      },
      {
        breakpoint: 768,
        settings: {
          slidesToShow: 3,
        },
      },
      {
        breakpoint: 480,
        settings: {
          slidesToShow: 2,
        },
      },
    ],
  });
  if (jQuery(".accordion-trigger").length) {
    jQuery(".accordion-trigger").click(function () {
      var content = jQuery(this).next(".accordion-content");
      jQuery(".accordion-content").not(content).slideUp();
      content.slideToggle();
      if (jQuery(this).hasClass("active")) {
        jQuery(this).removeClass("active");
      } else {
        jQuery(".accordion-trigger").removeClass("active");
        jQuery(this).addClass("active");
      }
    });
  }
});
