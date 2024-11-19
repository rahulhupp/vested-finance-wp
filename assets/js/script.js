
jQuery(document).ready(function ($) {
	$(".investors_slider").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: true,
		speed: 800,
		slidesToShow: 4,
		slidesToScroll: 1,
		responsive: [
			{
				breakpoint: 992,
				settings: {
					slidesToShow: 3,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 2,
					slidesToScroll: 1,
				},
			},
			{
				breakpoint: 601,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
				},
			},
		],
	});

	$(".investor_prev").click(function () {
		$(".investors_slider").slick("slickPrev");
	});

	$(".investor_next").click(function () {
		$(".investors_slider").slick("slickNext");
	});
	$(".investor_prev").addClass("slick-disabled");
	$(".investors_slider").on("afterChange", function () {
		if ($(".slick-prev").hasClass("slick-disabled")) {
			$(".investor_prev").addClass("slick-disabled");
		} else {
			$(".investor_prev").removeClass("slick-disabled");
		}
		if ($(".slick-next").hasClass("slick-disabled")) {
			$(".investor_next").addClass("slick-disabled");
		} else {
			$(".investor_next").removeClass("slick-disabled");
		}
	});

	jQuery(function ($) {
		$('.faqs_sec .faq_que').click(function (j) {
			var dropDown = $(this).closest('.single_faq').find('.faq_content');
			$(this).closest('.faqs_wrap').find('.faq_content').not(dropDown).slideUp();
			if ($(this).hasClass('active')) {
				$(this).removeClass('active');
			} else {
				$(this).closest('.faqs_wrap').find('.faq_que.active').removeClass('active');
				$(this).addClass('active');
			}
			dropDown.stop(false, true).slideToggle();
			j.preventDefault();
		});
	});
	
});

