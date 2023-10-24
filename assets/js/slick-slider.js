jQuery(document).ready(function ($) {

	$("#portfolioSlider").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: true,
		autoplaySpeed: 6000,
		speed: 600,
		slidesToShow: 1,
		slidesToScroll: 1,
		vertical: true,
		verticalSwiping: true,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					asNavFor: "#portfolioSliderNav",
					vertical: false,
					verticalSwiping: false,
				},
			},
		],
	});

	$("#portfolioSliderNav").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: true,
		autoplaySpeed: 6000,
		speed: 600,
		slidesToShow: 3,
		slidesToScroll: 1,
		vertical: true,
		responsive: [
			{
				breakpoint: 768,
				settings: {
					slidesToShow: 1,
					slidesToScroll: 1,
					asNavFor: "portfolioSlider",
					vertical: false,
					dots: true,
				},
			},
		],
	});

	$("#linkedinSlider").slick({
		infinite: true,
		arrows: false,
		dots: false,
		autoplay: true,
		autoplaySpeed: 6000,
		speed: 600,
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
});
