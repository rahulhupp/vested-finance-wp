jQuery(document).ready(function () {
  jQuery(".features_list").slick({
    slidesToShow: 3,
    // autoplay: true,
    // autoplaySpeed: 6000,
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

document.addEventListener("DOMContentLoaded", function () {
  console.log("JS New Partner Template Loaded");
  
  const menuLinks = document.querySelectorAll(".mega-menu a");
  const body = document.body;

  menuLinks.forEach((link) => {
    link.addEventListener("click", () => {
      document.querySelector(".humburger").click();
    });
  });
});
