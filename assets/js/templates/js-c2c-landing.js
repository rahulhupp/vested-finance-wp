jQuery(document).ready(function ($) {
    $('.earn-block-grid').slick({
        slidesToShow: 4,
        responsive: [
            {
                breakpoint: 991,
                settings: {
                  slidesToShow: 1,
                  dots: true,
                  variableWidth: true
                }
              },
            {
              breakpoint: 768,
              settings: {
                slidesToShow: 1,
                dots: true,
                variableWidth: true
              }
            },
            {
                breakpoint: 350,
                settings: {
                  slidesToShow: 1,
                  dots: true,
                  variableWidth: true
                }
              },
            ]
      });
});
