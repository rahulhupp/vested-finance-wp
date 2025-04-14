jQuery(document).ready(function ($) {
    $(".advantages-slider").slick({
		infinite: false,
		arrows: false,
		dots: false,
		autoplay: true,
		autoplaySpeed: 6000,
		speed: 600,
		slidesToShow: 4,
		slidesToScroll: 1,
        centerMode: false,
        adaptiveHeight: false,
		responsive: [
			{
				breakpoint: 1240,
				settings: {
					slidesToShow: 3,
				},
			},
			{
				breakpoint: 991,
				settings: {
					slidesToShow: 2,
				},
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".testimonials-slider").slick({
		slidesToShow: 3,
		slidesToScroll: 1,
		infinite: true,
		arrows: true,
		dots: false,
		autoplay: true,
		speed: 800,
		prevArrow: $(".testimonial-prev"),
    	nextArrow: $(".testimonial-next"),
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	jQuery(function ($) {
		$(".faq_que").click(function (j) {
			var dropDown = $(this).closest(".single_faq").find(".faq_content");
			$(this)
				.closest(".home_page_faq_wrap")
				.find(".faq_content")
				.not(dropDown)
				.slideUp();
			if ($(this).hasClass("active")) {
				$(this).removeClass("active");
			} else {
				$(this)
					.closest(".home_page_faq_wrap")
					.find(".faq_que.active")
					.removeClass("active");
				$(this).addClass("active");
			}
			dropDown.stop(false, true).slideToggle();
			j.preventDefault();
		});
	});
});