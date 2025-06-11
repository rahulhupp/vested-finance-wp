jQuery(document).ready(function () {
  jQuery(".services_list").slick({
    slidesToShow: 3,
    arrows: false,
    infinite: false,
    variableWidth: false,
    dots: false,
    autoplay: true,
    autoplaySpeed: 6000,
    responsive: [
        {
          breakpoint: 767,
          settings: {
              slidesToShow: 1,
              dots: true,
          }
        }
    ]
  });
  jQuery(".vests_list").slick({
    slidesToShow: 3,
    arrows: false,
    infinite: false,
    variableWidth: false,
    dots: false,
    responsive: [
        {
          breakpoint: 767,
          settings: {
              slidesToShow: 1,
              autoplay: true,
              autoplaySpeed: 6000,
          }
        }
    ]
  });

  jQuery(".testimonials-slider").slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		infinite: true,
		arrows: true,
		dots: false,
		autoplay: true,
		speed: 800,
		adaptiveHeight: true,
		prevArrow: jQuery(".testimonial-prev"),
    nextArrow: jQuery(".testimonial-next"),
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					adaptiveHeight: false,
				},
			},
		],
	});

  jQuery(function ($) {
		$(".faq_que").click(function (j) {
			var dropDown = $(this).closest(".single_faq").find(".faq_content");
			$(this)
				.closest(".faqs_wrapper")
				.find(".faq_content")
				.not(dropDown)
				.slideUp();
			if ($(this).hasClass("active")) {
				$(this).removeClass("active");
			} else {
				$(this)
					.closest(".faqs_wrapper")
					.find(".faq_que.active")
					.removeClass("active");
				$(this).addClass("active");
			}
			dropDown.stop(false, true).slideToggle();
			j.preventDefault();
		});
	});
});
