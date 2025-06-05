jQuery(document).ready(function () {
  jQuery(".features_list").slick({
    slidesToShow: 3, // or whatever fits your design
    arrows: true,
    infinite: false,
    variableWidth: false,
    prevArrow: jQuery('.features_prev'),
    nextArrow: jQuery('.features_next'),
    responsive: [
        {
          breakpoint: 1440,
          settings: {
              slidesToShow: 2
          }
        },
        {
          breakpoint: 990,
          settings: {
              slidesToShow: 1
          }
        }
    ]
  });
});
