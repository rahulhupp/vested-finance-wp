jQuery(document).ready(function ($) {

	function addProgressBarsToNav() {
		console.log('Select the #portfolioSliderNav element');
		// Select the #portfolioSliderNav element
		var $nav = $("#portfolioSliderNav");

		// Get the number of items in the navigation slider
		var itemCount = $nav.find(".slick-slide").length;

		// Create and append progress bars for each item
		for (var i = 0; i < itemCount; i++) {
			$nav.find(".slick-slide").eq(i).append("<div class='progress-bar'></div>");
		}
	}

	// Update the progress bars as you navigate through the slides
	$("#portfolioSlider").on("init reInit afterChange", function (event, slick, currentSlide, nextSlide) {
		console.log('Calculate the progress for the active slide');
		var progressBar = (currentSlide / (slick.slideCount - 1)) * 100;

		// Update the corresponding progress bar
		$("#portfolioSliderNav .slick-slide .progress-bar").eq(currentSlide).css("height", progressBar + "%");
	});


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

	addProgressBarsToNav();
});
